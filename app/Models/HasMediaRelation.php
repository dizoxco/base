<?php

namespace App\Models;

use Spatie\MediaLibrary\Models\Media;

trait HasMediaRelation
{
    public function mediaRelation()
    {
        return $this->morphToMany(
            Media::class,
            'model',
            'media_relations'
        );
    }
}
