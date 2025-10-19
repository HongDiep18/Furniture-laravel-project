<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    use HasFactory;

    protected $table = 'status_order';

    protected $fillable = [
        'id',
        'name',
        'color'
    ];
}
