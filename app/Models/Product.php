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
        'title', 'slug', 'abstract', 'body', 'attributes', 'options', 'single',
        'price', 'status', 'temp', 'available_at', 'created_at', 'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'single'        =>  'boolean',
        'attributes'    =>  'array',
        'options'       =>  'array',
        'created_at'    =>  'datetime',
        'updated_at'    =>  'datetime',
        'deleted_at'    =>  'datetime',
        'available_at'  =>  'datetime',
    ];

    //  =============================== Accessor ==============================
    public function getCombinedVariationsAttribute()
    {
        $variations = [[]];
        foreach ($this->options as $option_index => $option) {
            $append = [];
            foreach ($variations as $variation) {
                foreach ($option['values'] as $option_value) {
                    $variation['options'][$option['name']] = $option_value;
                    $variation['variation'] = null;
                    $append[] = $variation;
                }
            }
            $variations = $append;
        }

        if (isset(request()->route()->parameters()['business'])) {
            $saved_variations = $this->variations()
                ->where('business_id', request()->route()->parameters()['business']->id)
                ->get();
            foreach ($variations as $variation_index => $variation) {
                foreach ($saved_variations as $saved_variation) {
                    $same = true;
                    foreach ($variation['options'] as $variation_option_name => $variation_option) {
                        if ($saved_variation->options[$variation_option_name] != $variation_option['value']) {
                            $same = false;
                        }
                    }
                    if ($same) {
                        $variations[$variation_index]['variation'] = $saved_variation;
                    }
                }
            }
        }

        return $variations;
    }

    //  =============================== End Accessor ==========================

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

    /**
     * @deprecated No longer used by internal code and not recommended.
     * @return BelongsToMany
     */
    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'businesses_products', 'product_id', 'business_id', 'id', 'id');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class, 'product_id', 'id');
    }

    //  =============================== End Relationships =====================

    //  =============================== Media =================================
    public function registerMediaCollections()
    {
        $this->addMediaCollection('product-banner')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->crop(Manipulations::CROP_CENTER, 150, 150);
            });

        $this->addMediaCollection('product-gallery');
    }

    //  =============================== End Media =============================

    //  =============================== Complementary Methods =================
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

    public function related($number = 5)
    {
        return ProductRepo::getRelated($this, $number);
    }

    //  =============================== End Complementary Methods =============
}
