<?php

namespace App\Http\Resources;

class CityCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($city) {
            return (new CityResource($city))->additional($this->additional);
        });

        return parent::toArray($request);
    }

    public function resource($relation)
    {
        switch ($relation) {
            case 'county':
                break;
            case 'province':
                break;
        }
    }
}
