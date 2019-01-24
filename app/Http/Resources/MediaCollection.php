<?php

namespace App\Http\Resources;

class MediaCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($media_group) {
            return (new MediaResource($media_group))->additional($this->additional);
        });

        return parent::toArray($request);
    }
}
