<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderedVariations extends Model
{
    protected $table = 'orders_products';

    protected $fillable = [
        'order_id', 'variation_id', 'price', 'options',
    ];
}
