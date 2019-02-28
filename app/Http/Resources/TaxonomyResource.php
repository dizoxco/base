<?php

namespace App\Http\Resources;

class TaxonomyResource extends BaseResource
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
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
            'relations' =>  [
                $this->whenLoaded('tags', function () {
                    return ['tags'    =>  $this->tags->pluck('id')];
                }),
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
