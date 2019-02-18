<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TaxonomyResource extends Resource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'taxonomy',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'group_name'        =>  $this->group_name,
                'label'             =>  $this->label,
                'slug'              =>  $this->slug,
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
            'relations' =>  [
                $this->mergeWhen($this->whenLoaded('tags'), [
                    'tags' =>$this->tags
                ]),
            ],
        ];

        return $resource;
    }
}
