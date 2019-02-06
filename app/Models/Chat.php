<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chat extends Model
{
    protected $fillable = ['type', 'attribute'];

    protected $casts = [
        'attribute' => 'array',
    ];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_users', 'chat_id');
    }

    public function comments() : MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function __get($key)
    {
        $attr = array_wrap($this->getAttribute('attribute'));
        if (array_key_exists($key, $attr)) {
            return $attr[$key];
        }

        return parent::__get($key);
    }

    public function resolveRouteBinding($value)
    {
        $route = request()->route();

        if ($route->hasParameters()) {
            if ($route->hasParameter('chat')) {
                $result = $this->whereId($value)->whereType(enum('chat.type.chat'))->first();
            }

            if ($route->hasParameter('ticket')) {
                $result = $this->whereId($value)->whereType(enum('chat.type.ticket'))->first();
            }

            if ($result !== null) {
                return $result;
            }
        }
    }
}
