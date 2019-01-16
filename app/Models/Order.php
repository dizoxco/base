<?php

namespace App\Models;

use App\Utility\Payment\Contracts\IsPayable;
use App\Utility\Payment\Traits\Payable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements IsPayable
{
    use Payable;

    protected $fillable = [
        'user_id', 'receiver', 'mobile', 'province', 'city', 'address', 'postal_code',
    ];

    public function variations()
    {
        return $this->hasMany(OrderedVariations::class, 'order_id', 'id');
    }

    public function done()
    {
        $total_cost = $this->variations()->get()->sum(function ($order) {
            return $order->count * $order->price;
        });

        return $this->isPaid($total_cost);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
