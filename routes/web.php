<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Перенаправление с /home на главную страницу
Route::get('/home', function () {
    return redirect()->route('home');
});

// Контактная форма
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Аутентификация
Auth::routes();

// Маршруты, требующие аутентификации
Route::middleware(['auth'])->group(function () {
    // Профиль пользователя
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Заказы
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/create', [OrderController::class, 'store'])->name('orders.store');
    
    // Админ панель
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Управление товарами
        Route::resource('products', ProductController::class);
        
        // Управление услугами
        Route::resource('services', ServiceController::class);
        
        // Управление заказами
        Route::resource('orders', AdminOrderController::class);
    });

    // Маршруты для отзывов
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Маршруты для админки отзывов
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [ReviewController::class, 'reject'])->name('reviews.reject');
});

// Маршруты без проверки аутентификации
Route::group([], function () {
    // Каталог
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/search', [CatalogController::class, 'search'])->name('catalog.search');
    Route::get('/catalog/products', [CatalogController::class, 'products'])->name('catalog.products');
    Route::get('/catalog/services', [CatalogController::class, 'services'])->name('catalog.services');
    Route::get('/catalog/products/{product}', [CatalogController::class, 'showProduct'])->name('catalog.products.show');
    Route::get('/catalog/services/{service}', [CatalogController::class, 'showService'])->name('catalog.services.show');
    
    // Корзина
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Статические страницы
    Route::get('/privacy', function () {
        return view('static.privacy');
    })->name('privacy');
    
    Route::get('/terms', function () {
        return view('static.terms');
    })->name('terms');
});

// Прямая регистрация маршрутов админ-панели для обхода проблем с именами маршрутов
Route::middleware(['web', 'auth', 'admin'])->group(function () {
    Route::post('/admin/products/{product}/toggle-stock', [App\Http\Controllers\Admin\ProductController::class, 'toggleStock'])->name('admin.products.toggle-stock');
    Route::post('/admin/services/{service}/toggle-availability', [App\Http\Controllers\Admin\ServiceController::class, 'toggleAvailability'])->name('admin.services.toggle-availability');
});
