<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'itemable_id',
        'itemable_type',
        'quantity',
        'price',
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Получить заказ, которому принадлежит элемент.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Получить элемент (продукт или услугу), связанный с заказом.
     */
    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Получить общую стоимость элемента заказа.
     */
    public function getTotalPrice(): float
    {
        return $this->price * $this->quantity;
    }
}
