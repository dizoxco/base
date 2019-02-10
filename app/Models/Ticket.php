<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id', 'business_id', 'attributes',
    ];

    protected $casts = [
        'attributes' => 'array',
    ];

    protected $table = 'tickets';

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
