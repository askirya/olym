@extends('layouts.app')

@section('title', 'Каталог')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Каталог</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Блок товаров -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:transform hover:scale-105">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/products.jpg') }}" alt="Товары" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <h2 class="text-3xl font-bold text-white">Товары</h2>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Широкий ассортимент качественных резиновых изделий для различных областей применения. 
                    Наши товары отличаются высоким качеством и долговечностью.
                </p>
                <div class="flex justify-end">
                    <a href="{{ route('catalog.products') }}" class="btn btn-primary transition-transform duration-300 hover:scale-105">
                        Перейти к товарам
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Блок услуг -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:transform hover:scale-105">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/services.png') }}" alt="Услуги" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <h2 class="text-3xl font-bold text-white">Услуги</h2>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Профессиональные услуги по производству, ремонту и обслуживанию резиновых изделий.
                    Мы предлагаем индивидуальный подход к каждому клиенту.
                </p>
                <div class="flex justify-end">
                    <a href="{{ route('catalog.services') }}" class="btn btn-primary transition-transform duration-300 hover:scale-105">
                        Перейти к услугам
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Популярные товары -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Популярные товары</h2>
            <a href="{{ route('catalog.products') }}" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-500 text-sm font-medium">
                Смотреть все →
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($popularProducts as $product)
            <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="product-image-container h-48 overflow-hidden">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 h-12 overflow-hidden">{{ Str::limit($product->description, 80) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-red-600 dark:text-red-400">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        @if($product->in_stock)
                        <button class="btn btn-primary" onclick="addToCart('product', {{ $product->id }})">
                            В корзину
                        </button>
                        @else
                        <span class="text-red-600 dark:text-red-400 text-sm font-medium">Нет в наличии</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    
    <!-- Популярные услуги -->
    <section>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Популярные услуги</h2>
            <a href="{{ route('catalog.services') }}" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-500 text-sm font-medium">
                Смотреть все →
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($popularServices as $service)
            <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="product-image-container h-48 overflow-hidden">
                    <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="product-image w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $service->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 h-12 overflow-hidden">{{ Str::limit($service->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-red-600 dark:text-red-400">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
                        @if($service->available)
                        <button class="btn btn-primary" onclick="addToCart('service', {{ $service->id }})">
                            Заказать
                        </button>
                        @else
                        <span class="text-red-600 dark:text-red-400 text-sm font-medium">Недоступно</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
function addToCart(type, id) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            itemable_type: type,
            itemable_id: id,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            // Показываем уведомление
            alert(data.message);
            
            // Обновляем счетчик корзины
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.cartCount;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при добавлении товара в корзину');
    });
}
</script>
@endsection 