<?php

namespace App\Models;

use App\Utility\Payment\Traits\Payable;
use Illuminate\Database\Eloquent\Model;
use App\Utility\Payment\Contracts\IsPayable;

class Order extends Model implements IsPayable
{
    use Payable;

    protected $fillable = [
        'user_id', 'receiver', 'mobile', 'province', 'city_id', 'address', 'postal_code',
    ];

    protected $casts = [
        'done' => 'boolean',
    ];

    //  =============================== Accessor ==============================
    public function getCostAttribute()
    {
        return $this->variations->reduce(function ($carry, $variation) {
            return $carry + ($variation->pivot->quantity * $variation->pivot->price);
        });
    }

    public function getPaidAttribute()
    {
        $successful_payments = $this->pays()
            ->whereRaw("JSON_EXTRACT(options,'$.Status') = 'success'")
            ->sum('amount');

        return $successful_payments === $this->cost ?: $this->cost - $successful_payments;
    }
    //  =============================== End Accessor ==========================

    //  =============================== Relationships =========================
    public function variations()
    {
        return $this->belongsToMany(
            Variation::class, 'orders_products', 'order_id', 'variation_id', 'id', 'id'
        )->withPivot(['quantity', 'price']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    
    //  =============================== End Relationships =====================

    //  =============================== Complementary Methods =================
    
    //  =============================== End Complementary Methods =============
}
