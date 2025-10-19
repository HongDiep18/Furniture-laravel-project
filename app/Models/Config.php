<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $fillable = [
        'key',
        'value'
    ];
    public $timestamps = false;

    public static function get($key, $default = null){
        return static::where('key', $key)->value('value') ?? $default;
    }
}
