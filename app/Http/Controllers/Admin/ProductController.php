<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Отображает список всех товаров.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(10);
        
        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Отображает форму для создания нового товара.
     */
    public function create(): View
    {
        $categories = \App\Models\Category::where('type', 'product')->orderBy('name')->get();
        
        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Сохраняет новый товар в базе данных.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required_without:image_url|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'required_without:image|nullable|url',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->in_stock = $request->has('in_stock');
        $product->category_id = $request->category_id;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = 'storage/' . $imagePath;
        } elseif ($request->filled('image_url')) {
            // Если предоставлен URL изображения, используем его напрямую
            $product->image = $request->image_url;
        }
        
        $product->save();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно создан.');
    }

    /**
     * Отображает информацию о товаре.
     */
    public function show(Product $product): View
    {
        return view('admin.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Отображает форму для редактирования товара.
     */
    public function edit(Product $product): View
    {
        $categories = \App\Models\Category::where('type', 'product')->orderBy('name')->get();
        
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Обновляет товар в базе данных.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->in_stock = $request->has('in_stock');
        $product->category_id = $request->category_id;
        
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image && !Str::startsWith($product->image, 'http')) {
                $oldPath = str_replace('storage/', '', $product->image);
                Storage::disk('public')->delete($oldPath);
            }
            
            // Сохраняем новое изображение
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = 'storage/' . $imagePath;
        } elseif ($request->filled('image_url')) {
            // Если предоставлен URL изображения, используем его
            $product->image = $request->image_url;
        }
        
        $product->save();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен.');
    }

    /**
     * Удаляет товар из базы данных.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Удаляем изображение
        if ($product->image) {
            $imagePath = str_replace('storage/', '', $product->image);
            Storage::disk('public')->delete($imagePath);
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно удален.');
    }
    
    /**
     * Изменяет статус наличия товара.
     */
    public function toggleStock(Product $product): RedirectResponse
    {
        $product->update([
            'in_stock' => !$product->in_stock,
        ]);
        
        $status = $product->in_stock ? 'в наличии' : 'отсутствует';
        
        return redirect()->route('admin.products.index')
            ->with('success', "Статус товара изменен на: {$status}.");
    }
}
