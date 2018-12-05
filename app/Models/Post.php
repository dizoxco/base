<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, HasGroupedMedia;

    protected $perPage  =   10;

    protected $fillable = [
        'user_id', 'title', 'slug', 'image', 'abstract', 'body'
    ];

    protected $casts    =   [
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
        return $this->morphMany(Comment::class, 'commentable');
    }
    //  =============================== End Relationships =====================

    public function registerMediaCollections()
    {
        //  Register media collection for avatar that only accepts images
        $this->addMediaCollection(enum('media.post.banner'))
            ->acceptsFile(function (File $file) {
                $allowedMimes  =   [
                    'image/jpeg','image/png','image/tiff','image/bmp',
                ];
                return in_array($file->mimeType, $allowedMimes);
            })
            ->singleFile();

        $this->addMediaCollection(enum('media.post.attach'));
    }
}
