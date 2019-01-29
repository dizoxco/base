<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Facades\ProductRepo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    use SoftDeletes, HasSlug;

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

    public function banner(): MorphToMany
    {
        return $this->mediagroups()->where('media_relations.collection_name', enum('media.product.banner'));
    }

    public function mediagroups(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model', 'media_relations');
    }

    //  =============================== End Relationships =====================
    public function belongsToOneBusiness() : bool
    {
        return (bool) $this->getAttribute('single');
    }

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
            parent::resolveRouteBinding($product);
        } else {
            $product = ProductRepo::findBySlug($product);
            abort_if($product === null, 404);

            return $product;
        }
    }
}
