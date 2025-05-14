@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Корзина</h1>
    
    @if(session('success'))
    <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 mb-6 rounded">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 p-4 mb-6 rounded">
        {{ session('error') }}
    </div>
    @endif
    
    @if(count($cartItems) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
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
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($cartItems as $item)
                        <tr data-item-id="{{ $item->id }}" data-price="{{ $item->itemable->price }}">
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
                                    {{ number_format($item->itemable->price, 0, ',', ' ') }} ₽
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <button type="button" class="decrement-btn bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded-l"
                                        onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">
                                        -
                                    </button>
                                    <input type="number" min="1" max="99" value="{{ $item->quantity }}" 
                                        class="quantity-input w-12 text-center border-gray-200 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white"
                                        onchange="updateQuantity({{ $item->id }}, this.value)">
                                    <button type="button" class="increment-btn bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded-r"
                                        onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-red-600 dark:text-red-400 item-total">
                                    {{ number_format($item->itemable->price * $item->quantity, 0, ',', ' ') }} ₽
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                    onclick="removeItem({{ $item->id }})">
                                    Удалить
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium text-gray-900 dark:text-white">
                                Итого:
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-red-600 dark:text-red-400" id="cart-total">
                                {{ number_format($totalPrice, 0, ',', ' ') }} ₽
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-between items-center">
                <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                    onclick="clearCart()">
                    Очистить корзину
                </button>
                
                <button type="button" id="checkout-button" class="btn btn-primary">
                    Перейти к оформлению
                </button>
            </div>
        </div>
        
        <!-- Форма оформления заказа (скрыта по умолчанию) -->
        <div id="checkout-form" class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hidden">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Оформление заказа</h2>
            
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Данные получателя -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Данные получателя</h3>
                        
                        <div class="mb-4">
                            <label for="recipient_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ФИО получателя*</label>
                            <input type="text" id="recipient_name" name="recipient_name" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500" 
                                value="{{ old('recipient_name', Auth::user()->name) }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="recipient_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Телефон*</label>
                            <input type="text" id="recipient_phone" name="recipient_phone" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500" 
                                value="{{ old('recipient_phone', Auth::user()->phone) }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="recipient_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email*</label>
                            <input type="email" id="recipient_email" name="recipient_email" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500" 
                                value="{{ old('recipient_email', Auth::user()->email) }}" required>
                        </div>
                    </div>
                    
                    <!-- Информация о доставке -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Информация о доставке</h3>
                        
                        <div class="mb-4">
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Адрес доставки*</label>
                            <textarea id="delivery_address" name="delivery_address" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500" required>{{ old('delivery_address', Auth::user()->delivery_address) }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="delivery_comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Комментарий к заказу</label>
                            <textarea id="delivery_comment" name="delivery_comment" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('delivery_comment') }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Способ оплаты*</label>
                            <div class="mt-1 space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" id="payment_cash" name="payment_method" value="cash" class="h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500" 
                                        {{ old('payment_method') == 'cash' ? 'checked' : '' }} checked>
                                    <label for="payment_cash" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Наличными при получении</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="payment_card" name="payment_method" value="card" class="h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500" 
                                        {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                    <label for="payment_card" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Картой при получении</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex items-center justify-between">
                    <button type="button" id="back-to-cart-button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                        Вернуться к корзине
                    </button>
                    
                    <button type="submit" class="btn btn-primary">
                        Оформить заказ
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-500 dark:text-gray-400 text-lg mb-4">
                Ваша корзина пуста
            </p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                Перейти в каталог
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Переключение между корзиной и формой оформления заказа
document.addEventListener('DOMContentLoaded', function() {
    const checkoutButton = document.getElementById('checkout-button');
    const backToCartButton = document.getElementById('back-to-cart-button');
    const cartTable = document.querySelector('.bg-white.dark\\:bg-gray-800.rounded-lg.shadow-md.overflow-hidden');
    const checkoutForm = document.getElementById('checkout-form');
    
    if (checkoutButton && backToCartButton && cartTable && checkoutForm) {
        checkoutButton.addEventListener('click', function() {
            cartTable.classList.add('hidden');
            checkoutForm.classList.remove('hidden');
        });
        
        backToCartButton.addEventListener('click', function() {
            checkoutForm.classList.add('hidden');
            cartTable.classList.remove('hidden');
        });
    }
});

function updateQuantity(itemId, quantity) {
    if (quantity < 1) quantity = 1;
    if (quantity > 99) quantity = 99;
    
    fetch('{{ route("cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id: itemId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Обновляем количество в поле ввода
            const row = document.querySelector(`tr[data-item-id="${itemId}"]`);
            const quantityInput = row.querySelector('.quantity-input');
            quantityInput.value = quantity;
            
            // Обновляем цену товара
            const price = parseFloat(row.dataset.price);
            const totalElement = row.querySelector('.item-total');
            totalElement.textContent = formatPrice(price * quantity);
            
            // Обновляем общую сумму
            document.getElementById('cart-total').textContent = formatPrice(data.total);
            
            // Обновляем счетчик корзины в шапке
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.cartCount;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при обновлении количества товара');
    });
}

function removeItem(itemId) {
    if (!confirm('Вы уверены, что хотите удалить этот товар из корзины?')) {
        return;
    }
    
    fetch(`{{ url('cart/remove') }}/${itemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Удаляем строку из таблицы
            const row = document.querySelector(`tr[data-item-id="${itemId}"]`);
            row.remove();
            
            // Обновляем общую сумму
            document.getElementById('cart-total').textContent = formatPrice(data.total);
            
            // Обновляем счетчик корзины в шапке
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.cartCount;
            }
            
            // Если корзина пуста, перезагружаем страницу
            if (data.cartCount === 0) {
                window.location.reload();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при удалении товара из корзины');
    });
}

function clearCart() {
    if (!confirm('Вы уверены, что хотите очистить корзину?')) {
        return;
    }
    
    fetch('{{ route("cart.clear") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при очистке корзины');
    });
}

function formatPrice(price) {
    return new Intl.NumberFormat('ru-RU', { 
        style: 'decimal',
        maximumFractionDigits: 0
    }).format(price) + ' ₽';
}
</script>
@endsection 