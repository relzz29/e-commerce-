<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'category',
        'price',
        'original_price',
        'stock',
        'rating',
        'sold_count',
        'image_url',
        'description'
    ];

    public function channelStocks()
    {
        return $this->hasMany(ChannelStock::class);
    }
}

