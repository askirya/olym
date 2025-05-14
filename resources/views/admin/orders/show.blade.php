@extends('layouts.admin')

@section('title', 'Просмотр заказа #' . $order->id)
@section('header', 'Просмотр заказа #' . $order->id)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2"></i>Вернуться к списку заказов
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 p-4 mb-6 rounded-md">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Информация о заказе -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Информация о заказе</h2>
        </div>
        <div class="p-6">
            <div class="mb-4 flex justify-between">
                <span class="text-gray-700 dark:text-gray-300 font-medium">ID заказа:</span>
                <span class="text-gray-900 dark:text-white">{{ $order->id }}</span>
            </div>
            <div class="mb-4 flex justify-between">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Дата создания:</span>
                <span class="text-gray-900 dark:text-white">{{ $order->created_at->format('d.m.Y H:i') }}</span>
            </div>
            <div class="mb-4 flex justify-between">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Сумма заказа:</span>
                <span class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
            </div>
            <div class="mb-4 flex justify-between">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Статус:</span>
                <div>
                    @if($order->status == 'new')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            Новый
                        </span>
                    @elseif($order->status == 'processing')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            В обработке
                        </span>
                    @elseif($order->status == 'completed')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Завершен
                        </span>
                    @elseif($order->status == 'cancelled')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Отменен
                        </span>
                    @endif
                </div>
            </div>
            <div class="mb-4 flex justify-between">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Способ оплаты:</span>
                <span class="text-gray-900 dark:text-white">
                    {{ $order->payment_method == 'cash' ? 'Наличные при получении' : 'Карта при получении' }}
                </span>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('admin.orders.edit', $order) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-300">
                    <i class="fas fa-edit mr-2"></i>Редактировать заказ
                </a>
            </div>
        </div>
    </div>
    
    <!-- Информация о клиенте -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Информация о клиенте</h2>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <span class="text-gray-700 dark:text-gray-300 font-medium">ID клиента:</span>
                <span class="text-gray-900 dark:text-white">{{ $order->user->id }}</span>
            </div>
            <div class="mb-4">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Имя:</span>
                <span class="text-gray-900 dark:text-white">{{ $order->user->name }}</span>
            </div>
            <div class="mb-4">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Email:</span>
                <span class="text-gray-900 dark:text-white">{{ $order->user->email }}</span>
            </div>
            <div class="mb-4">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Дата регистрации:</span>
                <span class="text-gray-900 dark:text-white">{{ $order->user->created_at->format('d.m.Y') }}</span>
            </div>
            <div class="mt-6">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Данные получателя:</span>
                <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                    <div class="mb-2">
                        <span class="text-gray-600 dark:text-gray-400 text-sm">ФИО:</span>
                        <span class="text-gray-900 dark:text-white ml-2">{{ $order->recipient_name }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-gray-600 dark:text-gray-400 text-sm">Телефон:</span>
                        <span class="text-gray-900 dark:text-white ml-2">{{ $order->recipient_phone }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400 text-sm">Email:</span>
                        <span class="text-gray-900 dark:text-white ml-2">{{ $order->recipient_email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Информация о доставке -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Информация о доставке</h2>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Адрес доставки:</span>
                <p class="text-gray-900 dark:text-white mt-1">{{ $order->delivery_address }}</p>
            </div>
            
            @if($order->delivery_comment)
            <div class="mb-4">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Комментарий к заказу:</span>
                <p class="text-gray-900 dark:text-white mt-1">{{ $order->delivery_comment }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Элементы заказа -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
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

<!-- Быстрое изменение статуса заказа -->
<div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Управление статусом</h2>
    </div>
    <div class="p-6">
        <div class="mb-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Текущий статус:</p>
            <p class="text-lg font-medium">
                @if($order->status == 'pending')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        Новый
                    </span>
                @elseif($order->status == 'processing')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                        В обработке
                    </span>
                @elseif($order->status == 'completed')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        Завершен
                    </span>
                @elseif($order->status == 'canceled')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                        Отменен
                    </span>
                @endif
            </p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <button 
                data-status="pending" 
                data-order-id="{{ $order->id }}" 
                class="status-change-btn px-4 py-2 text-sm font-medium rounded-md {{ $order->status == 'pending' ? 'bg-blue-100 text-blue-800 cursor-default' : 'bg-blue-600 text-white hover:bg-blue-700' }}"
                {{ $order->status == 'pending' ? 'disabled' : '' }}
            >
                Новый
            </button>
            
            <button 
                data-status="processing" 
                data-order-id="{{ $order->id }}" 
                class="status-change-btn px-4 py-2 text-sm font-medium rounded-md {{ $order->status == 'processing' ? 'bg-yellow-100 text-yellow-800 cursor-default' : 'bg-yellow-600 text-white hover:bg-yellow-700' }}"
                {{ $order->status == 'processing' ? 'disabled' : '' }}
            >
                В обработке
            </button>
            
            <button 
                data-status="completed" 
                data-order-id="{{ $order->id }}" 
                class="status-change-btn px-4 py-2 text-sm font-medium rounded-md {{ $order->status == 'completed' ? 'bg-green-100 text-green-800 cursor-default' : 'bg-green-600 text-white hover:bg-green-700' }}"
                {{ $order->status == 'completed' ? 'disabled' : '' }}
            >
                Завершен
            </button>
            
            <button 
                data-status="canceled" 
                data-order-id="{{ $order->id }}" 
                class="status-change-btn px-4 py-2 text-sm font-medium rounded-md {{ $order->status == 'canceled' ? 'bg-red-100 text-red-800 cursor-default' : 'bg-red-600 text-white hover:bg-red-700' }}"
                {{ $order->status == 'canceled' ? 'disabled' : '' }}
            >
                Отменен
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusButtons = document.querySelectorAll('.status-change-btn');
        
        statusButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (this.disabled) return;
                
                const status = this.dataset.status;
                const orderId = this.dataset.orderId;
                
                if (confirm('Вы уверены, что хотите изменить статус заказа?')) {
                    const url = `/admin/orders/${orderId}/status`;
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: status })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Ошибка при изменении статуса заказа');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Произошла ошибка при изменении статуса заказа');
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection 