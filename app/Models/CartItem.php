<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CartItem extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'itemable_id',
        'itemable_type',
        'quantity',
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Получить пользователя, которому принадлежит элемент корзины.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить элемент (продукт или услугу), связанный с корзиной.
     */
    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Получить общую стоимость элемента корзины.
     */
    public function getTotalPrice(): float
    {
        return $this->itemable->price * $this->quantity;
    }
}
