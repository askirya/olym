@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Вход в аккаунт</h2>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email
                            </label>

                            <input id="email" type="email" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-800 dark:text-white @error('email') border-red-500 @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Пароль
                            </label>

                            <input id="password" type="password" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-800 dark:text-white @error('password') border-red-500 @enderror" 
                                name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input class="form-checkbox h-4 w-4 text-primary-500 transition duration-150 ease-in-out" 
                                    type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="ml-2 block text-sm text-gray-700 dark:text-gray-300" for="remember">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="px-6 py-2 bg-primary-500 text-white font-semibold rounded-lg shadow-md hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50">
                                Войти
                            </button>

                            @if (Route::has('password.request'))
                                <a class="text-primary-500 dark:text-primary-400 hover:text-primary-600 dark:hover:text-primary-300 text-sm" 
                                    href="{{ route('password.request') }}">
                                    Забыли пароль?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
