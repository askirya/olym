<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Админ-панель - @yield('title', 'Главная')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        },
                        admin: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .content-auto {
                content-visibility: auto;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Стили -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Определение функции переключения темы перед загрузкой скриптов -->
    <script>
        // Глобальная функция для переключения темы
        function toggleAdminTheme(event) {
            if (event) {
                event.preventDefault();
            }
            console.log('%c[toggleAdminTheme] Вызван через onclick', 'color: blue; font-weight: bold');
            
            // Получаем актуальное состояние темы напрямую из HTML
            const htmlElement = document.documentElement;
            const currentTheme = htmlElement.getAttribute('data-theme') || 'light';
            const hasDarkClass = htmlElement.classList.contains('dark');
            
            console.log(`%c[toggleAdminTheme] Текущее состояние: data-theme="${currentTheme}", класс dark: ${hasDarkClass}`, 'color: blue');
            
            // Принудительно определяем новую тему на основе класса dark
            // Это защита от несоответствия между классом и атрибутом
            let newTheme;
            if (hasDarkClass) {
                // Если класс dark есть - переключаемся на светлую тему
                newTheme = 'light';
                console.log(`%c[toggleAdminTheme] Переключаем с тёмной на светлую тему`, 'color: blue');
            } else {
                // Если класса dark нет - переключаемся на тёмную тему
                newTheme = 'dark';
                console.log(`%c[toggleAdminTheme] Переключаем со светлой на тёмную тему`, 'color: blue');
            }
            
            // Сначала обновляем классы
            if (newTheme === 'dark') {
                if (!htmlElement.classList.contains('dark')) {
                    htmlElement.classList.add('dark');
                    console.log('%c[toggleAdminTheme] Добавлен класс dark к HTML', 'color: blue');
                }
            } else {
                htmlElement.classList.remove('dark');
                console.log('%c[toggleAdminTheme] Удален класс dark из HTML', 'color: blue');
            }
            
            // Затем принудительно обновляем data-theme атрибут
            htmlElement.setAttribute('data-theme', newTheme);
            console.log(`%c[toggleAdminTheme] Установлен атрибут data-theme="${newTheme}"`, 'color: blue');
            
            // Сохраняем выбор пользователя
            localStorage.setItem('admin-theme', newTheme);
            console.log(`%c[toggleAdminTheme] Сохранена тема в localStorage: ${newTheme}`, 'color: blue');
            
            // Обновляем иконки
            const lightIcon = document.getElementById('theme-toggle-light-icon');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            
            if (lightIcon && darkIcon) {
                if (newTheme === 'dark') {
                    lightIcon.classList.remove('hidden');
                    darkIcon.classList.add('hidden');
                } else {
                    lightIcon.classList.add('hidden');
                    darkIcon.classList.remove('hidden');
                }
                console.log('%c[toggleAdminTheme] Обновлены иконки переключателя', 'color: blue');
            }
            
            // Проверка, что тема действительно изменилась
            const updatedTheme = htmlElement.getAttribute('data-theme');
            const updatedHasDarkClass = htmlElement.classList.contains('dark');
            console.log(`%c[toggleAdminTheme] Проверка применения: data-theme="${updatedTheme}", класс dark: ${updatedHasDarkClass}`, 'color: green');
            
            // Сообщаем о результате
            console.log(`%c[toggleAdminTheme] Тема успешно изменена на: ${newTheme}`, 'color: green; font-weight: bold');
            
            return false; // Предотвращаем действие по умолчанию
        }
        
        // При загрузке страницы проверяем и применяем сохраненную тему
        document.addEventListener('DOMContentLoaded', function() {
            console.log('%c[DOMContentLoaded] Настройка темы при загрузке страницы', 'color: purple');
            
            const htmlElement = document.documentElement;
            
            // Получаем сохраненную тему
            const savedTheme = localStorage.getItem('admin-theme');
            const hasDarkClass = htmlElement.classList.contains('dark');
            const currentTheme = htmlElement.getAttribute('data-theme') || 'light';
            
            console.log(`%c[DOMContentLoaded] Текущее состояние: data-theme="${currentTheme}", класс dark: ${hasDarkClass}`, 'color: purple');
            console.log(`%c[DOMContentLoaded] Сохраненная тема в localStorage: ${savedTheme || 'не задана'}`, 'color: purple');
            
            // Проверяем системные настройки, если нет сохраненной темы
            const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // Определяем, какую тему применить
            let themeToApply;
            if (savedTheme) {
                console.log(`%c[DOMContentLoaded] Применяем сохраненную тему: ${savedTheme}`, 'color: purple');
                themeToApply = savedTheme;
            } else if (systemPrefersDark) {
                console.log('%c[DOMContentLoaded] Применяем системную тему: dark', 'color: purple');
                themeToApply = 'dark';
            } else {
                console.log('%c[DOMContentLoaded] Применяем стандартную тему: light', 'color: purple');
                themeToApply = 'light';
            }
            
            // Принудительно обновляем класс и атрибут
            if (themeToApply === 'dark') {
                if (!htmlElement.classList.contains('dark')) {
                    htmlElement.classList.add('dark');
                    console.log('%c[DOMContentLoaded] Добавлен класс dark к HTML', 'color: purple');
                }
            } else {
                htmlElement.classList.remove('dark');
                console.log('%c[DOMContentLoaded] Удален класс dark из HTML', 'color: purple');
            }
            
            // Устанавливаем атрибут data-theme
            htmlElement.setAttribute('data-theme', themeToApply);
            console.log(`%c[DOMContentLoaded] Установлен атрибут data-theme="${themeToApply}"`, 'color: purple');
            
            // Обновляем иконки
            const lightIcon = document.getElementById('theme-toggle-light-icon');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            
            if (lightIcon && darkIcon) {
                if (themeToApply === 'dark') {
                    lightIcon.classList.remove('hidden');
                    darkIcon.classList.add('hidden');
                } else {
                    lightIcon.classList.add('hidden');
                    darkIcon.classList.remove('hidden');
                }
                console.log('%c[DOMContentLoaded] Обновлены иконки переключателя', 'color: purple');
            }
            
            // Проверка, что тема действительно применена
            const finalTheme = htmlElement.getAttribute('data-theme');
            const finalHasDarkClass = htmlElement.classList.contains('dark');
            console.log(`%c[DOMContentLoaded] Финальное состояние: data-theme="${finalTheme}", класс dark: ${finalHasDarkClass}`, 'color: purple');
            
            console.log(`%c[DOMContentLoaded] Тема успешно инициализирована: ${themeToApply}`, 'color: purple; font-weight: bold');
        });
    </script>
    
    <!-- Скрипты -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin-theme.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <!-- Боковая панель -->
        <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-admin-800 dark:bg-admin-900 text-white overflow-y-auto transition-all duration-300 z-20 transform md:translate-x-0 -translate-x-full md:translate-x-0">
            <div class="p-6">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-white flex items-center space-x-2">
                    <span>Olympecs</span>
                </a>
                <p class="text-admin-200 text-sm mt-1">Панель администратора</p>
            </div>
            
            <nav class="mt-5 px-2">
                <div class="space-y-1">
                    <div class="px-3 py-2 text-xs uppercase tracking-wider text-admin-200">
                        Управление контентом
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="group flex items-center px-3 py-2 text-base leading-5 font-medium rounded-md transition-colors duration-150 {{ request()->routeIs('admin.products.*') ? 'bg-admin-700 text-white' : 'text-admin-100 hover:bg-admin-700 hover:text-white' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-admin-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Товары
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="group flex items-center px-3 py-2 text-base leading-5 font-medium rounded-md transition-colors duration-150 {{ request()->routeIs('admin.services.*') ? 'bg-admin-700 text-white' : 'text-admin-100 hover:bg-admin-700 hover:text-white' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.services.*') ? 'text-white' : 'text-admin-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Услуги
                    </a>
                </div>
                
                <div class="mt-8 space-y-1">
                    <div class="px-3 py-2 text-xs uppercase tracking-wider text-admin-200">
                        Управление заказами
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="group flex items-center px-3 py-2 text-base leading-5 font-medium rounded-md transition-colors duration-150 {{ request()->routeIs('admin.orders.*') ? 'bg-admin-700 text-white' : 'text-admin-100 hover:bg-admin-700 hover:text-white' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-admin-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Заказы
                    </a>
                </div>
                
                <div class="mt-8 space-y-1">
                    <div class="px-3 py-2 text-xs uppercase tracking-wider text-admin-200">
                        Настройки
                    </div>
                    <a href="{{ route('home') }}" class="group flex items-center px-3 py-2 text-base leading-5 font-medium rounded-md text-admin-100 hover:bg-admin-700 hover:text-white transition-colors duration-150">
                        <svg class="mr-3 h-5 w-5 text-admin-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Вернуться на сайт
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full group flex items-center px-3 py-2 text-base leading-5 font-medium rounded-md text-admin-100 hover:bg-admin-700 hover:text-white transition-colors duration-150">
                            <svg class="mr-3 h-5 w-5 text-admin-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Выйти
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Мобильный переключатель меню -->
        <div class="md:hidden fixed inset-y-0 flex z-40">
            <button id="sidebar-toggle" type="button" class="px-4 border-r border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 focus:text-gray-600 dark:focus:text-gray-500 transition-colors duration-300">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
            </button>
        </div>

        <!-- Основной контент -->
        <div id="content" class="md:pl-64 flex flex-col flex-1 transition-all duration-300">
            <div class="sticky top-0 z-10 flex-shrink-0 h-16 bg-white dark:bg-gray-800 shadow-sm transition-colors duration-300">
                <div class="flex justify-between items-center h-full px-4 md:px-6">
                    <div class="flex items-center">
                        <button id="mobile-sidebar-toggle" class="md:hidden mr-3 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                        </button>
                        <h1 class="text-lg font-medium text-gray-900 dark:text-white transition-colors duration-300">@yield('header', 'Панель администратора')</h1>
                    </div>
                    
                    <div class="flex items-center ml-auto">
                        <!-- Переключатель темы -->
                        <button id="theme-toggle" type="button" onclick="toggleAdminTheme(event)" class="w-10 h-10 p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300 flex items-center justify-center">
                            <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                            </svg>
                            <svg id="theme-toggle-dark-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </button>
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:shadow-solid transition-colors duration-150">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-600">
                                        <span class="text-sm font-medium leading-none text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </span>
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg" style="display: none;">
                                <div class="py-1 rounded-md bg-white dark:bg-gray-800 shadow-xs transition-colors duration-300">
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                                        Профиль
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                                            Выйти
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <main class="flex-1 relative overflow-y-auto py-6 px-4 md:px-6 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
                @if (session('success'))
                    <div class="mb-6">
                        <div class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 rounded-md transition-colors duration-300" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6">
                        <div class="bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-4 rounded-md transition-colors duration-300" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html> 