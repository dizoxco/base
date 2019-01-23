<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Business extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'brand', 'province', 'city', 'tell', 'phone_code', 'address', 'postal_code', 'mobile', 'storage_address',
    ];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'businesses_users', 'business_id', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'businesses_products', 'business_id', 'product_id', 'id', 'id');
    }
}
