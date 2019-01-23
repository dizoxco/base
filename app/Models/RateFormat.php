<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateFormat extends Model
{
    protected $table = 'rating_formats';

    protected $fillable = [
        'name', 'slug', 'collection_name', 'description', 'values', 'type',
    ];
}
