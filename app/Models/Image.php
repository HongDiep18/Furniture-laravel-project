<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'title',
        'alt',
        'image',
        'description',
        'link',
        'type',
        'order',
        'status'
    ];

    public function getImageUrlAttribute()
    {
        $path = trim($this->image ?? '');

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
