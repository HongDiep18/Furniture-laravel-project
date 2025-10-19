<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'username',
        'email',
        'phone_number',
        'avatar',
        'password',
        'role',
        'google_id',
        'facebook_id'
    ];

    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    /**
     * Return a fully-qualified URL for the user's avatar.
     * - If avatar is empty, return default icon asset
     * - If avatar is an absolute URL (http/https) return as-is
     * - If avatar already starts with storage/ or images/ or a leading slash, return asset(...)
     * - Otherwise assume it's stored in storage (storage/app/public) and return asset('storage/..')
     *
     * Usage in Blade: $user->avatar_url
     */
    public function getAvatarUrlAttribute()
    {
        $avatar = trim($this->avatar ?? '');

        if ($avatar === '') {
            return '/images/icon-user.png';
        }

        if (preg_match('/^https?:\/\//i', $avatar)) {
            return $avatar;
        }

        if (Str::startsWith($avatar, ['storage/', '/storage/'])) {
            return '/' . ltrim($avatar, '/');
        }

        if (file_exists(public_path($avatar))) {
            return '/' . ltrim($avatar, '/');
        }

        if (Storage::disk('public')->exists($avatar)) {
            return '/storage/' . ltrim($avatar, '/');
        }

        return '/storage/' . ltrim($avatar, '/');
    }
}
