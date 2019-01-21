<?php

namespace App\Models;

use App\Utility\Rate\Methods\Multiple;
use App\Utility\Rate\Rateable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Comment extends Model implements HasMedia
{
    use HasMediaTrait, Rateable;

    protected $fillable = [
        'user_id', 'parent_id', 'body', 'commentable_id', 'commentable_type',
        'stat', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $perPage = 10;

    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * each model must have it's own implementation
     *
     * @return array
     */
    public function getRateFormat(): RateFormat
    {
        if ($this->commentable instanceof Post) {
            return RateFormat::make([
                'name' => 'post',
                'slug' => 'post',
                'values' => ['key' => 'like'],
                'type' => Stars::class,
            ]);
        }

        if ($this->commentable instanceof Product) {
            return RateFormat::make([
                'name' => 'product',
                'slug' => 'product',
                'values' => ['RAM','CPU','HDD',],
                'type' => Multiple::class,
            ]);
        }
    }
}
