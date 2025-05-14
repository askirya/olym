@extends('layouts.admin')

@section('title', 'Управление товарами')
@section('header', 'Управление товарами')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-medium text-gray-900 dark:text-white">Список товаров</h2>
    <a href="{{ route('admin.products.create') }}" class="bg-admin-600 hover:bg-admin-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors duration-300">
        <i class="fas fa-plus mr-2"></i>Добавить товар
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 p-4 mb-6 rounded-md">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6 transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
            <thead class="bg-gray-50 dark:bg-gray-700 transition-colors duration-300">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Изображение</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Название</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Цена</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Статус</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Действия</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white transition-colors duration-300">
                        {{ $product->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="h-10 w-10">
                            <img class="h-10 w-10 rounded object-cover" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white transition-colors duration-300">
                        {{ $product->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 transition-colors duration-300">
                        {{ number_format($product->price, 0, ',', ' ') }} ₽
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($product->in_stock)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                В наличии
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                Отсутствует
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-admin-600 hover:text-admin-800 dark:text-admin-400 dark:hover:text-admin-300 transition-colors duration-300" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline delete-form" onsubmit="return confirm('Вы уверены, что хотите удалить этот товар?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-300" title="Удалить">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.products.toggle-stock', $product) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-admin-600 hover:text-admin-800 dark:text-admin-400 dark:hover:text-admin-300 transition-colors duration-300" title="{{ $product->in_stock ? 'Сделать недоступным' : 'Сделать доступным' }}">
                                    <i class="fas {{ $product->in_stock ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                        Товары не найдены. <a href="{{ route('admin.products.create') }}" class="text-admin-600 hover:text-admin-800 dark:text-admin-400 dark:hover:text-admin-300">Добавить товар</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Пагинация -->
    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
        {{ $products->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('Вы уверены, что хотите удалить этот товар? Это действие нельзя отменить.')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection 