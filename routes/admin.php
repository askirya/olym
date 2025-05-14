<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/

// Группа маршрутов с префиксом имени "admin."
// Note: Эта группа уже имеет префикс "admin." из RouteServiceProvider
// но для большей ясности мы используем отдельную группу

// Главная страница админ-панели
Route::get('/', function () {
    return redirect()->route('admin.products.index');
})->name('dashboard');

// Управление товарами
Route::resource('products', ProductController::class);
Route::post('products/{product}/toggle-stock', [ProductController::class, 'toggleStock'])->name('products.toggle-stock');

// Управление услугами
Route::resource('services', ServiceController::class);
Route::post('services/{service}/toggle-availability', [ServiceController::class, 'toggleAvailability'])->name('services.toggle-availability');

// Управление заказами
Route::resource('orders', OrderController::class, ['except' => ['create', 'store', 'destroy']]);
Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
