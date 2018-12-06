<?php

namespace App\Models;

use Spatie\MediaLibrary\Models\Media;

trait HasGroupedMedia
{
    public function getMediaGroups(string $collection = null)
    {
        $relation = $this->hasManyThrough(
            Media::class,
            MediaRelation::class,
            'model_id',
            'id',
            'id',
            'media_id'
        )->getQuery();
        if ($collection === null) {
            return $relation->where('media_relations.model_type', self::class)->get();
        } else {
            return $relation
                ->where('media_relations.model_type', self::class)
                ->where('media_relations.collection_name', $collection)
                ->get();
        }
    }

    public function mediaRelation()
    {
        return $this->morphToMany(
            Media::class,
            'model',
            'media_relations'
        );
    }

}
