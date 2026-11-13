<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'resi',
        'customer_name',
        'customer_phone',
        'customer_address',
        'payment_method',
        'payment_status',
        'delivery_status',
        'total_amount',
        'courier_name',
        'courier_phone',
        'courier_plate',
        'last_lat',
        'last_lng',
        'is_paperless_scanned'
    ];
}

