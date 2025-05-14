<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Отображает список всех услуг.
     */
    public function index(): View
    {
        $services = Service::latest()->paginate(10);
        
        return view('admin.services.index', [
            'services' => $services,
        ]);
    }

    /**
     * Отображает форму для создания новой услуги.
     */
    public function create(): View
    {
        $categories = \App\Models\Category::where('type', 'service')->orderBy('name')->get();
        
        return view('admin.services.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Сохраняет новую услугу в базе данных.
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
        
        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->available = $request->has('available');
        $service->category_id = $request->category_id;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $service->image = 'storage/' . $imagePath;
        } elseif ($request->filled('image_url')) {
            // Если предоставлен URL изображения, используем его напрямую
            $service->image = $request->image_url;
        }
        
        $service->save();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга успешно создана.');
    }

    /**
     * Отображает информацию об услуге.
     */
    public function show(Service $service): View
    {
        return view('admin.services.show', [
            'service' => $service,
        ]);
    }

    /**
     * Отображает форму для редактирования услуги.
     */
    public function edit(Service $service): View
    {
        $categories = \App\Models\Category::where('type', 'service')->orderBy('name')->get();
        
        return view('admin.services.edit', [
            'service' => $service,
            'categories' => $categories,
        ]);
    }

    /**
     * Обновляет услугу в базе данных.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', // Maximum 2MB
            'image_url' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->available = $request->has('available');
        $service->category_id = $request->category_id;
        
        // Проверяем, передан ли новый файл изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если оно есть
            if ($service->image && !Str::startsWith($service->image, 'http')) {
                $oldPath = str_replace('storage/', '', $service->image);
                Storage::disk('public')->delete($oldPath);
            }
            
            // Сохраняем новое изображение
            $imagePath = $request->file('image')->store('services', 'public');
            $service->image = 'storage/' . $imagePath;
        } elseif ($request->filled('image_url')) {
            // Если предоставлен URL изображения, используем его напрямую
            $service->image = $request->image_url;
        }
        
        $service->save();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга успешно обновлена.');
    }

    /**
     * Удаляет услугу.
     */
    public function destroy(Service $service): RedirectResponse
    {
        // Удаляем изображение услуги, если оно есть
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга успешно удалена.');
    }
    
    /**
     * Изменяет статус доступности услуги.
     */
    public function toggleAvailability(Service $service): RedirectResponse
    {
        $service->update([
            'available' => !$service->available,
        ]);
        
        $status = $service->available ? 'доступна' : 'недоступна';
        
        return redirect()->route('admin.services.index')
            ->with('success', "Статус услуги изменен на: {$status}.");
    }
}
