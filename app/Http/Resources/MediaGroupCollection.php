<?php

namespace App\Http\Resources;

class MediaGroupCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($media_group) {
            return (new MediaGroupResource($media_group))->additional($this->additional);
        });

        return parent::toArray($request);
    }
}
