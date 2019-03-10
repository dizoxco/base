<?php

namespace App\Http\Resources;

class TagResource extends BaseResource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'tag',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'parent_id' => $this->parent_id,
                'taxonomy_id' => $this->taxonomy_id,
                'label' => $this->label,
                'slug' => $this->slug,
                'metadata' => $this->metadata,
                // additional
                'taxonomy_group_name' => $this->taxonomy->group_name,
                'fullname' => "{$this->taxonomy->label} - {$this->label}",
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
        ];

        return $resource;
    }
}
