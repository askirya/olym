<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Отображает список заказов пользователя.
     */
    public function index(): View
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        
        return view('orders.index', [
            'orders' => $orders,
        ]);
    }
    
    /**
     * Отображает детали конкретного заказа.
     */
    public function show(Order $order): View
    {
        // Проверяем, что заказ принадлежит текущему пользователю
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('orders.show', [
            'order' => $order->load('items.itemable'),
        ]);
    }
    
    /**
     * Создает новый заказ из корзины пользователя.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('itemable')->get();
        
        // Проверяем, что корзина не пуста
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста.');
        }
        
        // Проверяем, что все товары в наличии
        foreach ($cartItems as $cartItem) {
            if ($cartItem->itemable_type === 'App\\Models\\Product' && !$cartItem->itemable->in_stock) {
                return redirect()->route('cart.index')->with('error', 'Некоторые товары отсутствуют на складе.');
            }
            
            if ($cartItem->itemable_type === 'App\\Models\\Service' && !$cartItem->itemable->available) {
                return redirect()->route('cart.index')->with('error', 'Некоторые услуги временно недоступны.');
            }
        }
        
        // Валидация данных
        $request->validate([
            'delivery_address' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'recipient_email' => 'required|email|max:255',
            'payment_method' => 'required|string|in:cash,card',
            'delivery_comment' => 'nullable|string',
        ]);
        
        // Рассчитываем общую сумму заказа
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->itemable->price * $item->quantity;
        });
        
        // Создаем заказ в транзакции
        try {
            DB::beginTransaction();
            
            // Создаем заказ
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'recipient_email' => $request->recipient_email,
                'delivery_comment' => $request->delivery_comment,
                'payment_method' => $request->payment_method,
            ]);
            
            // Создаем элементы заказа
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'itemable_id' => $cartItem->itemable_id,
                    'itemable_type' => $cartItem->itemable_type,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->itemable->price,
                ]);
            }
            
            // Очищаем корзину
            CartItem::where('user_id', $user->id)->delete();
            
            DB::commit();
            
            return redirect()->route('orders.show', $order)->with('success', 'Ваш заказ успешно оформлен.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Произошла ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }
}
