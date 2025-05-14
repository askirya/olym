<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Отображает список всех заказов.
     */
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(10);
        
        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Отображает информацию о заказе.
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'items.itemable']);
        
        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Отображает форму для редактирования заказа.
     */
    public function edit(Order $order): View
    {
        $order->load(['user', 'items.itemable']);
        
        return view('admin.orders.edit', [
            'order' => $order,
        ]);
    }

    /**
     * Обновляет статус заказа в базе данных.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,canceled',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'recipient_email' => 'required|email|max:255',
            'delivery_address' => 'required|string',
            'delivery_comment' => 'nullable|string',
            'payment_method' => 'required|string|in:cash,card',
        ]);
        
        $order->update([
            'status' => $request->status,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'recipient_email' => $request->recipient_email,
            'delivery_address' => $request->delivery_address,
            'delivery_comment' => $request->delivery_comment,
            'payment_method' => $request->payment_method,
        ]);
        
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Заказ успешно обновлен.');
    }

    /**
     * Удаляет заказ из базы данных.
     */
    public function destroy(Order $order)
    {
        // Удаляем все элементы заказа
        $order->items()->delete();
        
        // Удаляем сам заказ
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Заказ успешно удален.');
    }

    /**
     * Быстрое обновление статуса заказа.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,canceled',
        ]);
        
        $order->update([
            'status' => $request->status,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Статус заказа успешно обновлен',
            'order' => $order
        ]);
    }
}
