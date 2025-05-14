@extends('layouts.app')

@section('title', 'Результаты поиска')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Результаты поиска: "{{ $query }}"</h1>
    
    <div class="mb-8">
        <form action="{{ route('catalog.search') }}" method="GET" class="flex gap-2">
            <input type="text" name="query" value="{{ $query }}" class="flex-grow p-2 border border-gray-300 dark:border-gray-700 rounded-lg" placeholder="Поиск товаров и услуг...">
            <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600">Искать</button>
        </form>
    </div>
    
    @if($products->isEmpty() && $services->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 text-center mb-12">
            <p class="text-gray-600 dark:text-gray-300">По вашему запросу ничего не найдено.</p>
        </div>
    @else
        <!-- Результаты товаров -->
        @if($products->isNotEmpty())
            <section class="mb-12">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Товары ({{ $products->count() }})</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                    <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="product-image-container h-48 overflow-hidden">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 h-12 overflow-hidden">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
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
        @endif
        
        <!-- Результаты услуг -->
        @if($services->isNotEmpty())
            <section>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Услуги ({{ $services->count() }})</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($services as $service)
                    <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="product-image-container h-48 overflow-hidden">
                            <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="product-image w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 h-12 overflow-hidden">{{ Str::limit($service->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
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
        @endif
    @endif
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