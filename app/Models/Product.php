<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
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
        'in_stock',
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
    ];

    /**
     * Получить элементы заказа, связанные с этим продуктом.
     */
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'itemable');
    }

    /**
     * Получить элементы корзины, связанные с этим продуктом.
     */
    public function cartItems(): MorphMany
    {
        return $this->morphMany(CartItem::class, 'itemable');
    }

    /**
     * Получить отзывы к товару.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
    
    /**
     * Получить средний рейтинг товара.
     */
    public function getAverageRating(): float
    {
        if ($this->reviews()->approved()->count() === 0) {
            return 0;
        }
        
        return round($this->reviews()->approved()->avg('rating'), 1);
    }

    /**
     * Получить категорию товара.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
