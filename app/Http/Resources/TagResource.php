<?php

namespace App\Http\Resources;

class TagResource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'tag',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'group_name'        =>  $this->group_name,
                'title'             =>  $this->title,
                'slug'              =>  $this->slug,
                'description'       =>  $this->description,
                'custom_properties' =>  $this->custom_properties,
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
        ];
        return $resource;
    }
}
