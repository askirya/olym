<!-- Отзывы -->
<section class="mb-16">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Отзывы об услуге</h2>
        @auth
            <a href="{{ route('reviews.create', ['type' => 'service', 'id' => $service->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md">
                <i class="fas fa-plus mr-2"></i> Добавить отзыв
            </a>
        @endauth
    </div>
    
    @if($service->reviews()->approved()->count() > 0)
        <div class="space-y-4">
            @foreach($service->reviews()->approved()->with('user')->latest()->get() as $review)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $review->user->name }}</h3>
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $review->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <div class="flex items-center mt-1 mb-3">
                                {!! $review->getRatingStars() !!}
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
            <p class="text-gray-600 dark:text-gray-300">Пока нет отзывов об этой услуге.</p>
            @auth
                <p class="mt-2 text-gray-600 dark:text-gray-300">Будьте первым, кто оставит отзыв!</p>
            @else
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Войдите</a>, чтобы оставить отзыв.
                </p>
            @endauth
        </div>
    @endif
</section> 