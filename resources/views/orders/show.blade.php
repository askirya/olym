@extends('layouts.app')

@section('title', 'Заказ №' . $order->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
            <i class="fas fa-arrow-left mr-2"></i>Вернуться к списку заказов
        </a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-wrap items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Заказ #{{ $order->id }}</h1>
                <div class="mt-2 sm:mt-0">
                    @if($order->status == 'new')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            Новый
                        </span>
                    @elseif($order->status == 'processing')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            В обработке
                        </span>
                    @elseif($order->status == 'completed')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Завершен
                        </span>
                    @elseif($order->status == 'cancelled')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Отменен
                        </span>
                    @endif
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Дата создания: {{ $order->created_at->format('d.m.Y H:i') }}</p>
        </div>
        
        <!-- Информация о заказе -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Информация о получателе -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Информация о получателе</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-700 dark:text-gray-300 mb-2">
                            <span class="font-semibold">ФИО:</span> {{ $order->recipient_name }}
                        </p>
                        <p class="text-gray-700 dark:text-gray-300 mb-2">
                            <span class="font-semibold">Телефон:</span> {{ $order->recipient_phone }}
                        </p>
                        <p class="text-gray-700 dark:text-gray-300">
                            <span class="font-semibold">Email:</span> {{ $order->recipient_email }}
                        </p>
                    </div>
                </div>
                
                <!-- Информация о доставке -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Информация о доставке</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-700 dark:text-gray-300 mb-2">
                            <span class="font-semibold">Адрес:</span> {{ $order->delivery_address }}
                        </p>
                        @if($order->delivery_comment)
                        <p class="text-gray-700 dark:text-gray-300 mb-2">
                            <span class="font-semibold">Комментарий:</span> {{ $order->delivery_comment }}
                        </p>
                        @endif
                        <p class="text-gray-700 dark:text-gray-300">
                            <span class="font-semibold">Способ оплаты:</span> 
                            {{ $order->payment_method == 'cash' ? 'Наличными при получении' : 'Картой при получении' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Товары заказа -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Товар/Услуга
                        </th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Цена
                        </th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Количество
                        </th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
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
                                    <img class="h-10 w-10 rounded object-cover" src="{{ asset($item->itemable->image) }}" alt="{{ $item->itemable->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $item->itemable->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ class_basename($item->itemable_type) == 'Product' ? 'Товар' : 'Услуга' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">
                                {{ number_format($item->price, 0, ',', ' ') }} ₽
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">
                                {{ $item->quantity }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-red-600 dark:text-red-400">
                                {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-medium text-gray-900 dark:text-white">
                            Итого:
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-red-600 dark:text-red-400">
                            {{ number_format($order->total_amount, 0, ',', ' ') }} ₽
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection 