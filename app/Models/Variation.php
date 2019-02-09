<?php

namespace App\Models;

use Faker\Test\Provider\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Variation extends Model
{
    protected $fillable = [
      'business_id', 'product_id', 'quantity', 'price', 'options',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function customers() : BelongsToMany
    {
        return $this->belongsToMany(
            User::class, 'carts', 'variation_id', 'user_id', 'id', 'id'
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function orders() : BelongsToMany
    {
        return $this->belongsToMany(
            Order::class, 'orders_products', 'variation_id', 'order_id', 'id', 'id'
        )->withPivot(['count', 'price']);
    }

    public function buyers() : Collection
    {
        $ids = $this->orders->pluck('user_id')->toArray();

        return User::whereIn('id', $ids)->get();
    }

    public function resolveRouteBinding($variation)
    {
        $product = request()->route()->parameter('product');

        if ($product instanceof Product) {
            return $this->whereId($variation)->whereProductId($product->id)->first();
        }

        return $this->whereId($variation)->first();
    }
}
