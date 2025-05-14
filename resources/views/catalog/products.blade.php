@extends('layouts.app')

@section('title', 'Товары')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div class="w-full md:w-auto mb-4 md:mb-0">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Товары</h1>
            <p class="text-gray-600 dark:text-gray-400">Найдено {{ $products->total() }} товаров</p>
        </div>
        
        <div class="w-full md:w-auto flex flex-wrap items-center gap-4">
            <!-- Фильтр по категории -->
            <div>
                <select id="category-filter" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Сортировка -->
            <div>
                <select id="sort-filter" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>По цене (сначала дешевле)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>По цене (сначала дороже)</option>
                    <option value="new" {{ request('sort') == 'new' ? 'selected' : '' }}>Сначала новые</option>
                </select>
            </div>
            
            <!-- Поиск -->
            <div>
                <form method="GET" action="{{ route('catalog.products') }}" class="flex">
                    <input type="text" name="search" placeholder="Поиск..." value="{{ request('search') }}" 
                        class="rounded-l-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-r-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Отображение товаров -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <a href="{{ route('catalog.products.show', $product) }}" class="block">
                <div class="product-image-container h-48 overflow-hidden">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
            </a>
            <div class="p-4">
                <a href="{{ route('catalog.products.show', $product) }}" class="block">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 hover:text-red-600 dark:hover:text-red-400">{{ $product->name }}</h3>
                </a>
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
        @empty
        <div class="col-span-full text-center py-8">
            <p class="text-gray-500 dark:text-gray-400 text-lg">Товары не найдены</p>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Попробуйте изменить параметры поиска</p>
        </div>
        @endforelse
    </div>
    
    <!-- Пагинация -->
    <div class="mt-8">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
// Фильтры
document.getElementById('category-filter').addEventListener('change', function() {
    applyFilters();
});

document.getElementById('sort-filter').addEventListener('change', function() {
    applyFilters();
});

function applyFilters() {
    const categoryValue = document.getElementById('category-filter').value;
    const sortValue = document.getElementById('sort-filter').value;
    const searchValue = '{{ request('search') }}';
    
    let url = '{{ route('catalog.products') }}?';
    
    if (categoryValue) {
        url += 'category=' + categoryValue + '&';
    }
    
    if (sortValue) {
        url += 'sort=' + sortValue + '&';
    }
    
    if (searchValue) {
        url += 'search=' + searchValue + '&';
    }
    
    // Удаляем последний символ & или ?
    url = url.replace(/[&?]$/, '');
    
    window.location.href = url;
}

// Добавление в корзину
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