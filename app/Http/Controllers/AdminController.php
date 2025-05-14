<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Отображает главную страницу админ-панели.
     */
    public function dashboard(): View
    {
        // Получаем статистику для дашборда
        $totalOrders = Order::count();
        $newOrders = Order::where('status', 'new')->count();
        $totalProducts = Product::count();
        $totalServices = Service::count();
        $totalUsers = User::count();
        
        // Последние заказы
        $latestOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'newOrders' => $newOrders,
            'totalProducts' => $totalProducts,
            'totalServices' => $totalServices, 
            'totalUsers' => $totalUsers,
            'latestOrders' => $latestOrders,
        ]);
    }
} 