<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Image\Manipulations;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Facades\BusinessRepo;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Business extends Model implements HasMedia
{
    use SoftDeletes, HasSlug, HasMediaTrait;

    protected $fillable = [
        'brand', 'slug', 'city_id', 'contact',
    ];

    protected $casts = [
        'contact' => 'array',
    ];

    //  =============================== Relationships =========================
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'businesses_users', 'business_id', 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function products()
    {
        // return $this->belongsToMany(Product::class, 'businesses_products', 'business_id', 'product_id', 'id', 'id');
        return $this->belongsToMany(Product::class, 'variations', 'business_id', 'product_id', 'id', 'id')->distinct();
    }

    public function logo(): MorphToMany
    {
        return $this->mediagroups()->where('media_relations.collection_name', enum('media.business.logo'));
    }

    private function mediagroups(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model', 'media_relations');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function chats()
    {
        return $this->hasMany(Ticket::class, 'business_id', 'id');
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

    //  =============================== End Complementary Methods =============
    public function resolveRouteBinding($business)
    {
        if (request()->isXmlHttpRequest()) {
            return parent::resolveRouteBinding($business);
        } else {
            $business = BusinessRepo::findBySlug($business);
            abort_if($business === null, 404);

            return $business;
        }
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(enum('media.business.logo'))
             ->singleFile();
            //  ->registerMediaConversions(function (Media $media) {
            //      $this->addMediaConversion('thumb')
            //           ->crop(Manipulations::CROP_CENTER, 150, 150);
            //  });

        $this->addMediaCollection('business-gallery');
    }
}
