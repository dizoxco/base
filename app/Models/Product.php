<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'abstract', 'body', 'attributes', 'variations',
        'single', 'available_at',
    ];

    protected $casts = [
        'single' => 'boolean',
    ];

    //  =============================== Relationships =========================
    public function tags() : MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function businesses()
    {
        $relation = $this->belongsToMany(Business::class, 'businesses_products', 'product_id', 'business_id', 'id', 'id');
        if ($this->belongsToOneBusiness()) {
            return $relation->first();
        }

        return $relation;
    }

    public function relatedVariations() : HasMany
    {
        return $this->hasMany(Variation::class, 'product_id', 'id');
    }

    //  =============================== End Relationships =====================
    public function belongsToOneBusiness() : bool
    {
        return (bool) $this->getAttribute('single');
    }
}
