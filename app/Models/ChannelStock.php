<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'channel_name', // 'Shopee', 'TikTok Shop', 'Web'
        'channel_item_id',
        'stock',
        'last_synced_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

