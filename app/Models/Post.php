<?php

namespace App\Models;

use App\Utility\Rate\Methods\Stars;
use App\Utility\Rate\Rateable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, HasMediaRelation, Rateable;


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
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function banner(): HasManyThrough
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

    public function attaches(): HasManyThrough
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

    public function tags(): MorphToMany
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

    /**
     * each model must have it's own implementation
     */
    public function getRateFormat(): RateFormat
    {
        return RateFormat::make([
            'name' => 'laptop',
            'slug' => 'laptop',
            'collection_name' => Post::class,
            'description' => 'لپ تاپ ها',
            'values' => ['key' => 'star'],
            'type' => Stars::class,
        ]);
    }
}
