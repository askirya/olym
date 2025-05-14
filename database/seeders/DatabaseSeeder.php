<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Создаем администратора
        User::create([
            'name' => 'Admin',
            'email' => 'admin@a.a',
            'password' => Hash::make('alex1981/'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);
    }
}
