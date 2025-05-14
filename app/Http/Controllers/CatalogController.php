<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Отображает страницу каталога с разделами товаров и услуг.
     */
    public function index(): View
    {
        $popularProducts = Product::where('in_stock', true)->take(4)->get();
        $popularServices = Service::where('available', true)->take(4)->get();
        
        return view('catalog.index', [
            'popularProducts' => $popularProducts,
            'popularServices' => $popularServices,
        ]);
    }
    
    /**
     * Отображает список всех товаров.
     */
    public function products(): View
    {
        $products = Product::where('in_stock', true)->paginate(12);
        $categories = \App\Models\Category::query()->products()->orderBy('name')->get();
        
        return view('catalog.products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
    
    /**
     * Отображает список всех услуг.
     */
    public function services(): View
    {
        $services = Service::where('available', true)->paginate(12);
        $categories = \App\Models\Category::query()->services()->orderBy('name')->get();
        
        return view('catalog.services', [
            'services' => $services,
            'categories' => $categories,
        ]);
    }
    
    /**
     * Поиск по товарам и услугам.
     */
    public function search(Request $request): View
    {
        $query = $request->input('query');
        
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('in_stock', true)
            ->get();
            
        $services = Service::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('available', true)
            ->get();
            
        return view('catalog.search', [
            'query' => $query,
            'products' => $products,
            'services' => $services,
        ]);
    }
    
    /**
     * Отображает детальную страницу товара.
     */
    public function showProduct(Product $product): View
    {
        if (!$product->in_stock) {
            abort(404);
        }
        
        return view('catalog.product', [
            'product' => $product,
        ]);
    }
    
    /**
     * Отображает детальную страницу услуги.
     */
    public function showService(Service $service): View
    {
        if (!$service->available) {
            abort(404);
        }
        
        return view('catalog.service', [
            'service' => $service,
        ]);
    }
}
