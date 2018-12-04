<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

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

    public function getMediaGroups()
    {
        return $this->hasManyThrough(
            \Spatie\MediaLibrary\Models\Media::class,
            MediaRelation::class,
            'model_id',
            'id',
            'id',
            'media_id'
        )->getQuery()->where('media_relations.model_type', self::class)->get();
    }
    //  =============================== End Relationships =====================
}
