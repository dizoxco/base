<?php

namespace App\Models;

use App\Utility\Payment\Traits\Payable;
use Illuminate\Database\Eloquent\Model;
use App\Utility\Payment\Contracts\IsPayable;

class Order extends Model implements IsPayable
{
    use Payable;

    protected $fillable = [
        'user_id', 'receiver', 'mobile', 'province', 'city', 'address', 'postal_code',
    ];

    public function variations()
    {
        return $this->belongsToMany(
            Variation::class, 'orders_products', 'order_id', 'variation_id', 'id', 'id'
        )->withPivot(['count', 'price']);
    }

    public function paid()
    {
        $total_cost = $this->variations()->get()->sum(function ($order) {
            return $order->count * $order->price;
        });

        return $this->isPaid($total_cost);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
