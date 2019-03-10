<?php

namespace App\Http\Resources;

class MediaGroupResource extends BaseResource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'mediagroup',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'name'              =>  $this->name,
                'collection_name'   =>  $this->collection_name,
                'description'       =>  $this->description,
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
        ];

        return $resource;
    }
}
