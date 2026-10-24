<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'queue_number',
        'customer_name',
        'customer_phone',
        'spice_level',
        'flavor',
        'total_price',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (! $order->queue_number) {
                $last = static::whereDate('created_at', today())->max('queue_number');
                $order->queue_number = ($last ?? 0) + 1;
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}