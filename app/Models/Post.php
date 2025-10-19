<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'post_category_id',
        'alias',
        'link',
        'description',
        'image',
        'content',
        'is_featured',
        'inhome',
        'title_seo',
        'histotal',
        'order',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

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
