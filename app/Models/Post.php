<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    const   TYPE        =   'posts';

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

    public function tags()
    {
//        return $this->morphToMany(Tag::class, 'taggables');
    }
    //  =============================== End Relationships =====================
}
