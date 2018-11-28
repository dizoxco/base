<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 * @package App
 * @property int user_id
 * @property string title
 * @property string slug
 * @property string image
 * @property string abstract
 * @property string body
 * @property string published_at
 */

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
        return $this->morphToMany(Tag::class, 'taggables');
    }
    //  =============================== End Relationships =====================
}
