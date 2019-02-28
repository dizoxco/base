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
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
        ];

        return $resource;
    }

    private function dates()
    {
        $dates = [];
        $dateColumns = ['created_at', 'updated_at'];
        foreach ($dateColumns as $column) {
            if ($this->{$column} !== null) {
                $dates[$column] = $this->{$column}->timestamp;
            }
        }

        return empty($dates) ? false : $dates;
    }
}
