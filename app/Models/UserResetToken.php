<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResetToken extends Model
{
    use HasFactory;

    protected $table = 'user_reset_tokens';

    protected $fillable = [
        'email',
        'token'
    ];

    public function user() {
        return $this->hasOne(User::class, 'email', 'email');
    }
}
