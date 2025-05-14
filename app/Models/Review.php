<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'comment',
        'rating',
        'is_approved',
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    /**
     * Получить пользователя, который оставил отзыв.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить элемент (товар или услугу), к которому относится отзыв.
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Область запроса для получения только одобренных отзывов.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Получить строковое представление рейтинга в виде звезд.
     */
    public function getRatingStars(): string
    {
        $fullStar = '<i class="fas fa-star text-yellow-400"></i>';
        $emptyStar = '<i class="far fa-star text-gray-300"></i>';
        
        $stars = str_repeat($fullStar, $this->rating);
        $stars .= str_repeat($emptyStar, 5 - $this->rating);
        
        return $stars;
    }
}
