<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseCollection extends ResourceCollection
{
    protected $includes = [];

    public function with($request)
    {
        return empty($this->includes)?
            []:
            [
                'included' => $this->includes
            ];
    }
}
