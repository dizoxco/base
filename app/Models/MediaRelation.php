<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaRelation extends Model
{
    protected $guarded = [];

    public function morphable()
    {
        return $this->morphTo();
    }
}
