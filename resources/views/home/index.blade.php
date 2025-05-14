@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="container mx-auto px-4">
    <!-- Hero секция -->
    <section class="py-16 md:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-6">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white">
                    Качественные резиновые изделия для вашего бизнеса
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Широкий ассортимент резиновых изделий высокого качества. Доставка по всей России.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                        Перейти в каталог
                    </a>
                    <a href="#contact" class="btn btn-secondary">
                        Связаться с нами
                    </a>
                </div>
            </div>
            <div class="relative">
                <img src="{{ asset('images/hero-image.jpg') }}" alt="Резиновые изделия" class="rounded-lg shadow-xl">
                <div class="absolute -bottom-6 -right-6 bg-indigo-600 text-white p-4 rounded-lg shadow-lg">
                    <p class="text-2xl font-bold">10+</p>
                    <p class="text-sm">лет на рынке</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Преимущества -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800 rounded-xl my-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Почему выбирают нас</h2>
            <p class="text-gray-600 dark:text-gray-300">Мы предлагаем только качественные изделия и отличный сервис</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Качество</h3>
                <p class="text-gray-600 dark:text-gray-300">Все изделия проходят строгий контроль качества</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Быстрая доставка</h3>
                <p class="text-gray-600 dark:text-gray-300">Доставляем заказы в кратчайшие сроки</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Поддержка</h3>
                <p class="text-gray-600 dark:text-gray-300">Профессиональная консультация и поддержка</p>
            </div>
        </div>
    </section>

    <!-- Популярные товары -->
    <section class="py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Популярные товары</h2>
            <p class="text-gray-600 dark:text-gray-300">Наши самые востребованные позиции</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="product-image-container">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image w-full h-48 object-cover">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        <button class="btn btn-primary" onclick="addToCart('product', {{ $product->id }})">
                            В корзину
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('catalog.products') }}" class="btn btn-secondary">
                Смотреть все товары
            </a>
        </div>
    </section>

    <!-- Популярные услуги -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800 rounded-xl my-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Популярные услуги</h2>
            <p class="text-gray-600 dark:text-gray-300">Профессиональные услуги для вашего бизнеса</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredServices as $service)
            <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="product-image-container">
                    <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="product-image w-full h-48 object-cover">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $service->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ Str::limit($service->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
                        <button class="btn btn-primary" onclick="addToCart('service', {{ $service->id }})">
                            Заказать
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('catalog.services') }}" class="btn btn-secondary">
                Смотреть все услуги
            </a>
        </div>
    </section>

    <!-- Контакты -->
    <section id="contact" class="py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Свяжитесь с нами</h2>
            <p class="text-gray-600 dark:text-gray-300">Мы всегда готовы помочь вам</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ваше имя</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Сообщение</label>
                        <textarea name="message" id="message" rows="4" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">
                        Отправить сообщение
                    </button>
                </form>
            </div>
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Телефон</h3>
                        <p class="text-gray-600 dark:text-gray-300">+7 (123) 456-78-90</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email</h3>
                        <p class="text-gray-600 dark:text-gray-300">info@olympecs.ru</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Адрес</h3>
                        <p class="text-gray-600 dark:text-gray-300">г. Москва, ул. Резиновая, д. 1</p>
                    </div>
                </div>
            </div>
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
            // Обновляем счетчик корзины
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = parseInt(cartCount.textContent) + 1;
            }
            
            // Показываем уведомление
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при добавлении товара в корзину');
    });
}
</script>
@endsection 