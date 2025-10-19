<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kjmtrue\VietnamZone\Models\District;
use Kjmtrue\VietnamZone\Models\Province;
use Kjmtrue\VietnamZone\Models\Ward;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    protected $fillable = [
        'id',
        'code',
        'user_id',
        'name',
        'phone_number',
        'email',
        'note',
        'province_id',
        'district_id',
        'ward_id',
        'address_detail',
        'total_price',
        'shipping',
        'total_amount',
        'status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }
    public function status()
    {
        return $this->belongsTo(StatusOrder::class, 'status_id');
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
