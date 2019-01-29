<?php

namespace App\Models;

use App\Repositories\Facades\BusinessRepo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Business extends Model
{
    use SoftDeletes, HasSlug;

    protected $fillable = [
        'brand', 'province', 'city', 'tell', 'phone_code', 'address', 'postal_code', 'mobile', 'storage_address',
    ];

    //  =============================== Relationships =========================
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'businesses_users', 'business_id', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'businesses_products', 'business_id', 'product_id', 'id', 'id');
    }

    public function logo(): MorphToMany
    {
        return $this->mediagroups()->where('media_relations.collection_name', enum('media.business.logo'));
    }

    private function mediagroups(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model', 'media_relations');
    }
    //  =============================== End Relationships =====================

    //  =============================== Complementary Methods =================
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->usingLanguage('fa')
            ->generateSlugsFrom('brand')
            ->saveSlugsTo('slug');
    }

    public function resolveRouteBinding($business)
    {
        if (request()->isXmlHttpRequest()) {
            parent::resolveRouteBinding($business);
        } else {
            $business = BusinessRepo::findBySlug($business);
            abort_if($business === null, 404);
            return $business;
        }
    }
    //  =============================== End Complementary Methods =============
}
