<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'id',
        'product_code',
        'name',
        'alias',
        'stock_status',
        'price',
        'price_sale',
        'title_seo',
        'home_image',
        'description',
        'keywords',
        'inhome',
        'is_featured',
        'is_new',
        'is_bestseller',
        'hitstotal',
        'status',
        'order',
        'category_id',
        'type_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    public function getTotalSoldAttribute()
    {
        return $this->order()->sum('quantity');
    }

    public function getTotalPriceSoldAttribute()
    {
        return $this->order()
            ->selectRaw('SUM(price * quantity) as total')
            ->value('total');
    }

    /**
     * Return a fully-qualified URL for the product's home image.
     */
    public function getHomeImageUrlAttribute()
    {
        $path = trim($this->home_image ?? '');

        if ($path === '') {
            return '/images/empty-product.png';
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        // already a storage path exposed to public
        if (Str::startsWith($path, ['storage/', '/storage/'])) {
            return '/' . ltrim($path, '/');
        }

        // if file exists directly under public (like 'images/...')
        if (file_exists(public_path($path))) {
            return '/' . ltrim($path, '/');
        }

        // if file exists in storage/app/public
        if (Storage::disk('public')->exists($path)) {
            return '/storage/' . ltrim($path, '/');
        }

        // fallback: if starts with images/
        if (Str::startsWith($path, ['images/', '/images/'])) {
            return '/' . ltrim($path, '/');
        }

        return '/storage/' . ltrim($path, '/');
    }
}
