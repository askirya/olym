@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Баннер -->
    <section class="bg-primary-500 text-white p-8 mb-12 rounded-lg text-center">
        <h1 class="text-4xl font-bold mb-4 text-white">Добро пожаловать в ОЛИМПЕКС</h1>
        <p class="text-xl mb-8">Ведущий поставщик резинотехнических изделий и конвейерного оборудования</p>
        <div class="flex justify-center space-x-4 flex-wrap">
            <a href="{{ route('catalog.products') }}" class="bg-white text-primary-500 font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-gray-100 mb-2 transition-all duration-300">Посмотреть товары</a>
            <a href="{{ route('catalog.services') }}" class="bg-white text-primary-500 font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-gray-100 mb-2 transition-all duration-300">Наши услуги</a>
        </div>
    </section>

    <!-- Преимущества -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-primary-500 mb-8">Почему выбирают нас</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center transition-transform hover:transform hover:scale-105 duration-300">
                <div class="text-4xl text-primary-500 mb-4"><i class="fa fa-check-circle"></i></div>
                <h3 class="text-xl font-semibold mb-2">Качество</h3>
                <p class="text-gray-700 dark:text-gray-300">Высочайшее качество поставляемой продукции и предоставляемых услуг</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center transition-transform hover:transform hover:scale-105 duration-300">
                <div class="text-4xl text-primary-500 mb-4"><i class="fa fa-truck"></i></div>
                <h3 class="text-xl font-semibold mb-2">Доставка</h3>
                <p class="text-gray-700 dark:text-gray-300">Круглосуточная доставка в любую точку России любого объёма</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center transition-transform hover:transform hover:scale-105 duration-300">
                <div class="text-4xl text-primary-500 mb-4"><i class="fa fa-bolt"></i></div>
                <h3 class="text-xl font-semibold mb-2">Скорость</h3>
                <p class="text-gray-700 dark:text-gray-300">Быстрая обработка и доставка заказа без перебоев с поставками</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center transition-transform hover:transform hover:scale-105 duration-300">
                <div class="text-4xl text-primary-500 mb-4"><i class="fa fa-headset"></i></div>
                <h3 class="text-xl font-semibold mb-2">Поддержка</h3>
                <p class="text-gray-700 dark:text-gray-300">Высококвалифицированная техническая поддержка на всех этапах</p>
            </div>
        </div>
    </section>

    <!-- Товары -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-primary-500 mb-8">Популярные товары</h2>
        
        @if($popularProducts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                @foreach($popularProducts as $product)
                <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <a href="{{ route('catalog.products.show', $product) }}" class="block">
                        <div class="product-image-container h-48 overflow-hidden">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        </div>
                    </a>
                    <div class="p-4">
                        <a href="{{ route('catalog.products.show', $product) }}" class="block">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 hover:text-primary-500 dark:hover:text-primary-400">{{ $product->name }}</h3>
                        </a>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 h-12 overflow-hidden">{{ Str::limit($product->description, 80) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-primary-500 dark:text-primary-400">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                            <button class="btn btn-primary" onclick="addToCart('product', {{ $product->id }})">
                                В корзину
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md text-center mb-8">
                <p class="text-xl text-gray-700 dark:text-gray-300">Скоро здесь появятся товары</p>
            </div>
        @endif
        
        <div class="text-center">
            <a href="{{ route('catalog.products') }}" class="bg-primary-500 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-primary-600 transition-all duration-300">Все товары</a>
        </div>
    </section>

    <!-- Популярные услуги с карточками -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-primary-500 mb-8">Популярные услуги</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Услуга 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform hover:transform hover:scale-105 duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://i.ibb.co/h1xc1449/image-20.png" alt="Стыковка лент методом горячей вулканизации" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">Стыковка лент методом горячей вулканизации</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">Профессиональная стыковка конвейерных лент с гарантией надежности соединения</p>
                    <a href="#" class="text-primary-500 hover:text-primary-600 font-medium transition duration-300">Подробнее →</a>
                </div>
            </div>
            
            <!-- Услуга 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform hover:transform hover:scale-105 duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://i.ibb.co/cK1sWyrw/image-25.png" alt="Футеровка барабанов ленточных конвейеров" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">Футеровка барабанов ленточных конвейеров</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">Качественная футеровка приводных и неприводных барабанов конвейерных систем</p>
                    <a href="#" class="text-primary-500 hover:text-primary-600 font-medium transition duration-300">Подробнее →</a>
                </div>
            </div>
            
            <!-- Услуга 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform hover:transform hover:scale-105 duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://i.ibb.co/LBqzFv6/image-23.png" alt="Обрезинивание роликов и валов" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">Обрезинивание роликов и валов</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">Профессиональное обрезинивание валов и роликов различного назначения для конвейерного оборудования</p>
                    <a href="#" class="text-primary-500 hover:text-primary-600 font-medium transition duration-300">Подробнее →</a>
                </div>
            </div>
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('catalog.services') }}" class="bg-primary-500 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-primary-600 transition-all duration-300">Все услуги</a>
        </div>
    </section>

    <!-- Блок контактов -->
    <section class="mb-16 bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h2 class="text-3xl font-bold text-center text-primary-500 mb-8">Наши контакты</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Адрес -->
            <div class="text-center">
                <div class="rounded-full bg-primary-500 bg-opacity-10 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map-marker-alt text-2xl text-primary-500"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Адреса</h3>
                <p class="text-gray-700 dark:text-gray-300">г. Сергиев Посад, Новоугличское ш., д. 74В</p>
                <p class="text-gray-700 dark:text-gray-300">г. Москва, ул. Проспект Мира, д. 202а</p>
            </div>
            
            <!-- Телефон -->
            <div class="text-center">
                <div class="rounded-full bg-primary-500 bg-opacity-10 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone-alt text-2xl text-primary-500"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Телефон</h3>
                <p class="text-gray-700 dark:text-gray-300">+7 (985) 568-40-68</p>
                <p class="text-gray-700 dark:text-gray-300">+7 (925) 152-55-91</p>
                <p class="text-gray-700 dark:text-gray-300">Звонок по России бесплатный: 8-800-201-61-35</p>
            </div>
            
            <!-- Email -->
            <div class="text-center">
                <div class="rounded-full bg-primary-500 bg-opacity-10 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-2xl text-primary-500"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">E-mails</h3>
                <p class="text-gray-700 dark:text-gray-300">info@olimpeks.ru</p>
                <p class="text-gray-700 dark:text-gray-300">olimpeks@bk.ru</p>
            </div>
        </div>
        
        <!-- Карта -->
        <div class="mt-10 flex justify-center">
            <div id="map" class="w-full max-w-5xl h-64 rounded-lg shadow-md"></div>
        </div>
    </section>

    <!-- Форма обратной связи -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-primary-500 mb-4">Остались вопросы?</h2>
        <p class="text-center text-lg mb-8 max-w-2xl mx-auto">Заполните форму, и мы свяжемся с вами в ближайшее время</p>
        
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md max-w-3xl mx-auto">
            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="name" class="block font-medium mb-2">Ваше имя</label>
                    <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white" required>
                </div>
                <div class="mb-6">
                    <label for="email" class="block font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white" required>
                </div>
                <div class="mb-6">
                    <label for="message" class="block font-medium mb-2">Сообщение</label>
                    <textarea id="message" name="message" rows="5" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-primary-500 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-primary-600 transition-all duration-300">Отправить</button>
                </div>
            </form>
        </div>
    </section>
    
    <!-- Подписка на рассылку -->
    <section class="mb-16 bg-primary-500 p-10 rounded-lg text-center">
        <h2 class="text-3xl font-bold mb-4 text-white">Подпишитесь на нашу рассылку</h2>
        <p class="text-lg mb-8 max-w-2xl mx-auto text-white">Будьте в курсе новых поступлений, акций и специальных предложений</p>
        
        <form class="max-w-xl mx-auto flex flex-col sm:flex-row gap-4">
            <input type="email" placeholder="Ваш email" class="flex-grow p-3 rounded-lg focus:outline-none text-gray-800" required>
            <button type="submit" class="bg-white text-primary-500 font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-gray-100 transition-all duration-300">Подписаться</button>
        </form>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://api-maps.yandex.ru/2.1/?apikey=d12d901d-a2a4-489a-8e5e-9ea75a5809bb&lang=ru_RU"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapElement = document.getElementById('map');
        
        ymaps.ready(init);
        
        function init() {
            // Координаты офисов
            var sergievPosadCoords = [56.3282, 38.1532];
            var moscowCoords = [55.8348, 37.6750];
            
            // Создаем карту
            var myMap = new ymaps.Map("map", {
                center: [56.0, 37.5],
                zoom: 8,
                controls: ['zoomControl', 'fullscreenControl']
            });
            
            // Создаем метку для Сергиева Посада
            var sergievPosadMark = new ymaps.Placemark(sergievPosadCoords, {
                balloonContent: '<strong>ОЛИМПЕКС (Сергиев Посад)</strong><br>г. Сергиев Посад, Новоугличское ш., д. 74В'
            }, {
                preset: 'islands#redDotIcon'
            });
            
            // Создаем метку для Москвы
            var moscowMark = new ymaps.Placemark(moscowCoords, {
                balloonContent: '<strong>ОЛИМПЕКС (Москва)</strong><br>г. Москва, ул. Проспект Мира, д. 202а'
            }, {
                preset: 'islands#blueDotIcon'
            });
            
            // Добавляем метки на карту
            myMap.geoObjects.add(sergievPosadMark);
            myMap.geoObjects.add(moscowMark);
            
            // Настраиваем карту так, чтобы были видны обе метки
            var bounds = myMap.geoObjects.getBounds();
            if (bounds) {
                myMap.setBounds(bounds, {
                    checkZoomRange: true,
                    zoomMargin: 30
                });
            }
            
            // Отключаем прокрутку колесом мыши
            myMap.behaviors.disable('scrollZoom');
            
            // Включаем прокрутку при клике
            myMap.events.add('click', function() {
                myMap.behaviors.enable('scrollZoom');
            });
            
            // Отключаем прокрутку при уходе мыши с карты
            mapElement.addEventListener('mouseleave', function() {
                myMap.behaviors.disable('scrollZoom');
            });
        }
    });

    // Функция добавления товара в корзину
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
                // Показываем уведомление
                alert(data.message);
                
                // Обновляем счетчик корзины
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cartCount;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при добавлении товара в корзину');
        });
    }
</script>
@endsection
