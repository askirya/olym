<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Отображает содержимое корзины пользователя.
     */
    public function index(): View
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('itemable')->get();
        
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->itemable->price * $item->quantity;
        });
        
        return view('cart.index', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
        ]);
    }
    
    /**
     * Добавляет товар или услугу в корзину.
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'itemable_id' => 'required|integer',
            'itemable_type' => 'required|string|in:product,service',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $userId = Auth::id();
        $itemableType = $request->itemable_type === 'product' ? Product::class : Service::class;
        $itemableId = $request->itemable_id;
        $quantity = $request->quantity;
        
        // Проверяем, что товар/услуга существует и доступен
        $itemable = $itemableType::findOrFail($itemableId);
        
        if ($itemableType === Product::class && !$itemable->in_stock) {
            return response()->json([
                'message' => 'Товар отсутствует на складе.',
            ], 400);
        }
        
        if ($itemableType === Service::class && !$itemable->available) {
            return response()->json([
                'message' => 'Услуга временно недоступна.',
            ], 400);
        }
        
        // Проверяем, есть ли уже такой товар/услуга в корзине
        $cartItem = CartItem::where('user_id', $userId)
            ->where('itemable_id', $itemableId)
            ->where('itemable_type', $itemableType)
            ->first();
            
        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity,
            ]);
        } else {
            CartItem::create([
                'user_id' => $userId,
                'itemable_id' => $itemableId,
                'itemable_type' => $itemableType,
                'quantity' => $quantity,
            ]);
        }
        
        return response()->json([
            'message' => 'Товар добавлен в корзину.',
        ]);
    }
    
    /**
     * Обновляет количество товара/услуги в корзине.
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $cartItem = CartItem::findOrFail($request->id);
        
        // Проверяем, что это корзина текущего пользователя
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }
        
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);
        
        // Пересчитываем общую стоимость
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('itemable')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->itemable->price * $item->quantity;
        });
        
        return response()->json([
            'success' => true,
            'total' => $total,
            'cartCount' => $cartItems->sum('quantity'),
        ]);
    }
    
    /**
     * Удаляет товар/услугу из корзины.
     */
    public function remove($id): JsonResponse
    {
        $cartItem = CartItem::findOrFail($id);
        
        // Проверяем, что это корзина текущего пользователя
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }
        
        $cartItem->delete();
        
        // Пересчитываем общую стоимость
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('itemable')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->itemable->price * $item->quantity;
        });
        
        return response()->json([
            'success' => true,
            'total' => $total,
            'cartCount' => $cartItems->sum('quantity'),
        ]);
    }
    
    /**
     * Очищает корзину пользователя.
     */
    public function clear(): JsonResponse
    {
        CartItem::where('user_id', Auth::id())->delete();
        
        return response()->json([
            'success' => true,
            'cartCount' => 0,
        ]);
    }
}
