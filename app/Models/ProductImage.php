<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'id',
        'url',
        'alt',
        'order',
        'product_id',
    ];

    /**
     * Normalized URL for the product image.
     */
    public function getUrlAttribute($value)
    {
        $path = trim($value ?? '');

        if ($path === '') {
            return '/images/empty-product.png';
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        if (Str::startsWith($path, ['storage/', '/storage/'])) {
            return '/' . ltrim($path, '/');
        }

        if (file_exists(public_path($path))) {
            return '/' . ltrim($path, '/');
        }

        if (Storage::disk('public')->exists($path)) {
            return '/storage/' . ltrim($path, '/');
        }

        return '/storage/' . ltrim($path, '/');
    }
}
