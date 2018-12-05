<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class MediaGroup extends Model implements HasMedia
{
    use HasMediaTrait;

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'model_relations');
    }
}
