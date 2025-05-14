<?php

namespace App\Providers;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Регистрация посредника для администратора
        Route::aliasMiddleware('admin', AdminMiddleware::class);

        // Определение гейта для проверки является ли пользователь администратором
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });
    }
}
