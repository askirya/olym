<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Получаем 3 активных товара
        $popularProducts = \App\Models\Product::where('in_stock', true)
            ->latest()
            ->take(3)
            ->get();
            
        return view('home', [
            'popularProducts' => $popularProducts
        ]);
    }
}
