<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Image\Manipulations;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Facades\ProductRepo;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model implements HasMedia
{
    use SoftDeletes, HasSlug, HasMediaTrait;

    protected $fillable = [
        'title', 'slug', 'abstract', 'body', 'attributes', 'options',
        'single', 'available_at',
    ];

    protected $casts = [
        'single'    => 'boolean',
        'options'   => 'array',
    ];

    //  =============================== Relationships =========================
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists', 'product_id', 'user_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'businesses_products', 'product_id', 'business_id', 'id', 'id');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class, 'product_id', 'id');
    }

    //  =============================== End Relationships =====================

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->usingLanguage('fa')
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function resolveRouteBinding($product)
    {
        if (request()->isXmlHttpRequest()) {
            return parent::resolveRouteBinding($product);
        } else {
            $product = ProductRepo::findBySlug($product);
            abort_if($product === null, 404);

            return $product;
        }
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('product-banner')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->crop(Manipulations::CROP_CENTER, 150, 150);
                // $this->addMediaConversion('teaser')
                //     ->crop(Manipulations::CROP_CENTER, 450, 450);
            });

        $this->addMediaCollection('product-gallery');
    }

    public function related($number = 5)
    {
        return ProductRepo::getRelated($this, $number);
    }
}
