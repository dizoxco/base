<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function counties()
    {
        return $this->hasMany(County::class, 'province_id', 'id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'province_id', 'id');
    }
}
