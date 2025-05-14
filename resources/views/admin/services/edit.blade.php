@extends('layouts.admin')

@php
use Illuminate\Support\Str;
@endphp

@section('title', 'Редактирование услуги')
@section('header', 'Редактирование услуги')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.services.index') }}" class="text-admin-600 hover:text-admin-800 dark:text-admin-400 dark:hover:text-admin-300 transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2"></i>Вернуться к списку услуг
    </a>
</div>

@if($errors->any())
    <div class="bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-200 p-4 mb-6 rounded-md">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Название услуги</label>
                    <input type="text" name="name" id="name" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-admin-500 focus:ring focus:ring-admin-500 focus:ring-opacity-50 transition-colors duration-300" value="{{ old('name', $service->name) }}" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</label>
                    <textarea name="description" id="description" rows="5" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-admin-500 focus:ring focus:ring-admin-500 focus:ring-opacity-50 transition-colors duration-300" required>{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Цена (₽)</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-admin-500 focus:ring focus:ring-admin-500 focus:ring-opacity-50 transition-colors duration-300" value="{{ old('price', $service->price) }}" required>
                </div>
            </div>

            <div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Изображение</label>
                    
                    @if($service->image)
                    <div class="mb-2">
                        <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="h-32 w-auto object-cover rounded-md">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Текущее изображение</p>
                    </div>
                    @endif
                    
                    <input type="file" name="image" id="image" class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2 dark:bg-gray-900 dark:text-white transition-colors duration-300">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Оставьте пустым, чтобы сохранить текущее изображение. Рекомендуемый размер: 800x600 пикселей. Максимальный размер: 2MB.</p>
                </div>

                <div class="mb-4">
                    <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Изображение по ссылке</label>
                    <input type="url" name="image_url" id="image_url" placeholder="https://i.ibb.co/example/image.png" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-admin-500 focus:ring focus:ring-admin-500 focus:ring-opacity-50 transition-colors duration-300" value="{{ old('image_url', Str::startsWith($service->image ?? '', 'http') ? $service->image : '') }}">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Вы можете указать прямую ссылку на изображение вместо загрузки файла</p>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Категория</label>
                    <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-admin-500 focus:ring focus:ring-admin-500 focus:ring-opacity-50 transition-colors duration-300">
                        <option value="">Без категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="available" class="rounded border-gray-300 dark:border-gray-700 text-admin-600 shadow-sm focus:border-admin-500 focus:ring focus:ring-admin-500 focus:ring-opacity-50 transition-colors duration-300" {{ old('available', $service->available) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Доступно для заказа</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-admin-600 hover:bg-admin-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors duration-300">
                <i class="fas fa-save mr-2"></i>Сохранить изменения
            </button>
        </div>
    </form>
</div>
@endsection 