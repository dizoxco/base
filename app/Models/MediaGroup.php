<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class MediaGroup extends Model implements HasMedia
{
    use HasMediaTrait;

    public function getFullNameAttribute()
    {
        return 'media_group_'.$this->name;
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('posts')
             ->registerMediaConversions(function (Media $media) {
                 $this->addMediaConversion('thumb')
                      ->crop('crop-center', 150, 150);
                 $this->addMediaConversion('teaser')
                      ->crop('crop-center', 450, 450);
                 $this->addMediaConversion('banner')
                      ->crop('crop-center', 1350, 700);
             });
    }
}
