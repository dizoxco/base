<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Comment extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable =   [
        'user_id','parent_id','body','commentable_id','commentable_type',
        'stat','deleted_at','created_at','updated_at'
    ];

    protected $perPage  =   10;

    public function commentable()
    {
        return $this->morphTo();
    }
}
