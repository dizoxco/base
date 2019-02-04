<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'county_id', 'id');
    }
}
