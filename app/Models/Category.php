<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'type',
        'parent_id',
        'order',
    ];

    /**
     * Автоматически создает slug при создании категории.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Получить дочерние категории.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    /**
     * Получить товары в этой категории.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Получить услуги в этой категории.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Область запроса для категорий товаров.
     */
    public function scopeProducts($query)
    {
        return $query->where('type', 'product');
    }

    /**
     * Область запроса для категорий услуг.
     */
    public function scopeServices($query)
    {
        return $query->where('type', 'service');
    }

    /**
     * Область запроса для получения только родительских категорий.
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}
