@extends('layouts.admin')

@section('title', 'Редактирование заказа #' . $order->id)
@section('header', 'Редактирование заказа #' . $order->id)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2"></i>Вернуться к просмотру заказа
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
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Информация о заказе</h2>
    </div>
    
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Левая колонка -->
            <div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Статус заказа</label>
                    <select id="status" name="status" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Новый</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В обработке</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершен</option>
                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Отменен</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="recipient_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ФИО получателя</label>
                    <input type="text" id="recipient_name" name="recipient_name" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300" value="{{ old('recipient_name', $order->recipient_name) }}">
                </div>
                
                <div class="mb-4">
                    <label for="recipient_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Телефон получателя</label>
                    <input type="text" id="recipient_phone" name="recipient_phone" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300" value="{{ old('recipient_phone', $order->recipient_phone) }}">
                </div>
                
                <div class="mb-4">
                    <label for="recipient_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email получателя</label>
                    <input type="email" id="recipient_email" name="recipient_email" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300" value="{{ old('recipient_email', $order->recipient_email) }}">
                </div>
                
                <div class="mb-4">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Способ оплаты</label>
                    <select id="payment_method" name="payment_method" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300">
                        <option value="cash" {{ $order->payment_method == 'cash' ? 'selected' : '' }}>Наличными при получении</option>
                        <option value="card" {{ $order->payment_method == 'card' ? 'selected' : '' }}>Картой при получении</option>
                    </select>
                </div>
            </div>
            
            <!-- Правая колонка -->
            <div>
                <div class="mb-4">
                    <label for="delivery_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Адрес доставки</label>
                    <textarea id="delivery_address" name="delivery_address" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300">{{ old('delivery_address', $order->delivery_address) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="delivery_comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Комментарий к заказу</label>
                    <textarea id="delivery_comment" name="delivery_comment" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-300">{{ old('delivery_comment', $order->delivery_comment) }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-300">
                Сохранить изменения
            </button>
        </div>
    </form>
</div>

<!-- Элементы заказа (только для просмотра) -->
<div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Элементы заказа</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Товар/Услуга
                    </th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Цена
                    </th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Количество
                    </th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Сумма
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-md object-cover" src="{{ asset($item->itemable->image) }}" alt="{{ $item->itemable->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $item->itemable->name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ class_basename($item->itemable_type) == 'Product' ? 'Товар' : 'Услуга' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">
                        {{ number_format($item->price, 0, ',', ' ') }} ₽
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">
                        {{ $item->quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-indigo-600 dark:text-indigo-400">
                        {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">
                        Итого:
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-indigo-600 dark:text-indigo-400">
                        {{ number_format($order->total_amount, 0, ',', ' ') }} ₽
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection 