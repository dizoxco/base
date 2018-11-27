<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DBResource extends Resource
{
    public function toArray($request)
    {
        return [
            'row-effected' => (int) $this->resource
        ];
    }
}
