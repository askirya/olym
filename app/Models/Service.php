<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'available',
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean',
    ];

    /**
     * Получить элементы заказа, связанные с этой услугой.
     */
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'itemable');
    }

    /**
     * Получить элементы корзины, связанные с этой услугой.
     */
    public function cartItems(): MorphMany
    {
        return $this->morphMany(CartItem::class, 'itemable');
    }

    /**
     * Получить отзывы к услуге.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
    
    /**
     * Получить средний рейтинг услуги.
     */
    public function getAverageRating(): float
    {
        if ($this->reviews()->approved()->count() === 0) {
            return 0;
        }
        
        return round($this->reviews()->approved()->avg('rating'), 1);
    }

    /**
     * Получить категорию услуги.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}