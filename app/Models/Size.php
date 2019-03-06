<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['size', 'name'];

    public function size()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
