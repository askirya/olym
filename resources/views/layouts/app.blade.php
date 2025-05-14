<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ОЛИМПЕКС') }} - @yield('title', 'Поставщик резинотехнических изделий и конвейерного оборудования')</title>

    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Иконки -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
    <!-- Наши стили -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- JavaScript -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/theme-toggle.js') }}" defer></script>
    
    @yield('styles')

    <style>
        /* Глобальные стили анимаций для всего сайта */
        .transition-colors,
        .transition-all,
        .transition-transform,
        .transition {
            transition-duration: 300ms !important;
        }
        
        /* Быстрый переход для темы */
        .theme-transition * {
            transition-duration: 300ms !important;
        }
    </style>
</head>
<body class="font-sans antialiased theme-transition bg-pattern min-h-screen">
    <div id="app" class="flex flex-col min-h-screen bg-gray-50 dark:bg-black transition-colors duration-300 relative">
        <!-- Шапка сайта -->
        <header class="bg-white dark:bg-black shadow-md transition-colors duration-300">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <!-- Логотип -->
                    <div class="logo">
                        <a href="{{ route('home') }}" class="logo-link">
                            <span class="olympecs-logo">
                                ОЛИМПЕКС
                            </span>
                        </a>
                    </div>
                    
                    <!-- Форма поиска -->
                    <div class="hidden md:block flex-grow mx-8">
                        <form action="{{ route('catalog.search') }}" method="GET" class="flex">
                            <input type="text" name="query" class="flex-grow px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-800 dark:text-white" placeholder="Поиск товаров и услуг...">
                            <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-r-lg hover:bg-primary-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <!-- Переключатель темы -->
                        <button id="theme-toggle" class="w-10 h-10 p-2 rounded-full bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors duration-300 flex items-center justify-center">
                            <i class="fas fa-moon"></i>
                        </button>
                        
                        <!-- Навигация -->
                        <nav class="hidden md:flex items-center space-x-6">
                            <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">Главная</a>
                            @auth
                                <a href="{{ route('catalog.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">Каталог</a>
                                <a href="{{ route('cart.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300 relative">
                                    <span class="inline-block mr-5">Корзина</span>
                                    <span class="absolute top-0 right-0 bg-primary-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ Auth::user()->cartItems()->count() }}
                                    </span>
                                </a>
                                <a href="{{ route('orders.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">Заказы</a>
                            @endauth
                        </nav>
                        
                        <!-- Кнопки авторизации -->
                        <div class="flex items-center space-x-4">
                            @guest
                                <a href="{{ route('login') }}" class="text-primary-500 dark:text-primary-400 hover:text-primary-600 dark:hover:text-primary-300 transition-colors duration-300">Войти</a>
                                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-primary-500 hover:bg-primary-600 text-white font-medium transition-colors duration-300 shadow-md hover:shadow-lg">Регистрация</a>
                            @else
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                        <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-black rounded-md shadow-lg py-1 z-50 transition-colors duration-300">
                                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-300">Мой профиль</a>
                                        
                                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-300">Мои заказы</a>
                                        
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-300">Админ панель</a>
                                        @endif
                                        
                                        <div class="border-t border-gray-100 dark:border-gray-800 my-1"></div>
                                        
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-300">Выйти</button>
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Контент страницы -->
        <main class="py-8 flex-grow z-10 relative">
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                    <div class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 rounded-md transition-colors duration-300" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                    <div class="bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-4 rounded-md transition-colors duration-300" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
        
        <!-- Подвал сайта -->
        <footer class="bg-gray-100 dark:bg-black py-12 transition-colors duration-300 border-t border-gray-200 dark:border-gray-700">
            <div class="container mx-auto px-4">
                <div class="mb-8 text-center">
                    <div class="flex items-center justify-center mb-4">
                        <span class="text-2xl font-extrabold tracking-tight gradient-text mr-2">ОЛИМПЕКС</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 max-w-2xl mx-auto">Ведущий поставщик качественных резинотехнических изделий. Продажа и обслуживание конвейерного и транспортирующего оборудования.</p>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                    <div class="flex flex-col md:flex-row md:justify-between items-center">
                        <p class="text-center md:text-left text-gray-500 dark:text-gray-400 mb-4 md:mb-0">
                            &copy; {{ date('Y') }} ОЛИМПЕКС. Все права защищены.
                        </p>
                        <div class="flex space-x-4">
                            <a href="{{ route('privacy') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">Политика конфиденциальности</a>
                            <a href="{{ route('terms') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors duration-300">Условия использования</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Tailwind CSS через CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#fee2e2',
                            100: '#fecaca',
                            200: '#fca5a5',
                            300: '#f87171',
                            400: '#ef4444',
                            500: '#e50000',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        },
                    },
                },
            },
        }
    </script>
    
    @yield('scripts')
</body>
</html> 