<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topping extends Model
{
    protected $fillable = ['name', 'price', 'is_available'];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function orderItemToppings(): HasMany
    {
        return $this->hasMany(OrderItemTopping::class);
    }
}