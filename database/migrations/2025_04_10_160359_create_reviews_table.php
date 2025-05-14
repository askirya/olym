<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('reviewable'); // Полиморфная связь для товаров и услуг
            $table->text('comment');
            $table->integer('rating')->unsigned()->default(5); // Рейтинг от 1 до 5
            $table->boolean('is_approved')->default(false); // Флаг модерации отзыва
            $table->timestamps();
            
            // Индексы для быстрого поиска
            $table->index('rating');
            $table->index('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
