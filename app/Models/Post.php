<?php

namespace App\Models;

use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, HasMediaRelation;

    protected $perPage = 10;

    protected $fillable = [
        'user_id', 'title', 'slug', 'image', 'abstract', 'body',
    ];

    protected $casts = [
        'deleted_at'    =>  'datetime',
        'published_at'  =>  'datetime',
        'created_at'    =>  'datetime',
        'updated_at'    =>  'datetime',
    ];

    //  =============================== Relationships =========================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('id', 1);
    }

    public function banner()
    {
        return $this->hasManyThrough(
            Media::class,
            MediaRelation::class,
            'model_id',
            'id',
            'id',
            'media_id'
        )
            ->where('media_relations.model_type', self::class)
            ->where('media_relations.collection_name', enum('media.post.banner'));
    }

    public function attaches()
    {
        return $this->hasManyThrough(
            Media::class,
            MediaRelation::class,
            'model_id',
            'id',
            'id',
            'media_id'
        )
            ->where('media_relations.model_type', self::class)
            ->where('media_relations.collection_name', enum('media.post.attach'));
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    //  =============================== End Relationships =====================

    public function registerMediaCollections()
    {
        //  Register media collection for avatar that only accepts images
        $this->addMediaCollection(enum('media.post.banner'))
            ->acceptsFile(function (File $file) {
                $allowedMimes = [
                    'image/jpeg', 'image/png', 'image/tiff', 'image/bmp',
                ];

                return in_array($file->mimeType, $allowedMimes);
            })
            ->singleFile();

        $this->addMediaCollection(enum('media.post.attach'));
    }
}
