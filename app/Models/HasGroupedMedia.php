<?php

namespace App\Models;

use Spatie\MediaLibrary\Models\Media;

trait HasGroupedMedia
{
    public function getMediaGroups()
    {
        return $this->hasManyThrough(
            Media::class,
            MediaRelation::class,
            'model_id',
            'id',
            'id',
            'media_id'
        )->getQuery()->where('media_relations.model_type', self::class)->get();
    }

    public function mediaGroup()
    {
        return $this->morphToMany(
            Media::class,
            'model',
            'media_relations'
        );
    }
}
