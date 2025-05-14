@extends('layouts.app')

@section('title', 'Оставить отзыв')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Оставить отзыв о {{ $type === 'product' ? 'товаре' : 'услуге' }}: {{ $item->name }}</h1>
    
    @if(session('error'))
    <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 p-4 mb-6 rounded">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="reviewable_type" value="{{ $type }}">
            <input type="hidden" name="reviewable_id" value="{{ $item->id }}">
            
            <!-- Блок с товаром -->
            <div class="flex items-center mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="w-16 h-16 flex-shrink-0">
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded">
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($item->description, 100) }}</p>
                </div>
            </div>
            
            <!-- Рейтинг -->
            <div class="mb-6">
                <label for="rating" class="block text-lg font-medium text-gray-900 dark:text-white mb-2">Ваша оценка</label>
                <div class="flex items-center space-x-1" id="rating-container">
                    <input type="hidden" name="rating" id="rating" value="5">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="text-2xl focus:outline-none star-btn" data-value="{{ $i }}">
                            <i class="fas fa-star text-yellow-400"></i>
                        </button>
                    @endfor
                </div>
                @error('rating')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Комментарий -->
            <div class="mb-6">
                <label for="comment" class="block text-lg font-medium text-gray-900 dark:text-white mb-2">Ваш отзыв</label>
                <textarea id="comment" name="comment" rows="5" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Расскажите о вашем опыте использования товара/услуги...">{{ old('comment') }}</textarea>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Минимальная длина отзыва - 10 символов</p>
                @error('comment')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Кнопка отправки -->
            <div class="flex justify-end">
                <button type="submit" class="bg-primary-500 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-primary-600">Отправить отзыв</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('rating');
    
    // Функция для обновления звезд
    function updateStars(value) {
        stars.forEach(star => {
            const starValue = parseInt(star.dataset.value);
            if (starValue <= value) {
                star.innerHTML = '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                star.innerHTML = '<i class="far fa-star text-gray-300"></i>';
            }
        });
        ratingInput.value = value;
    }
    
    // Обработчики клика по звездам
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            updateStars(value);
        });
    });
});
</script>
@endsection 