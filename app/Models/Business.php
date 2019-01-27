<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Business extends Model
{
    use SoftDeletes, HasSlug;

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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->usingLanguage('fa')
            ->generateSlugsFrom('brand')
            ->saveSlugsTo('slug');
    }
}
