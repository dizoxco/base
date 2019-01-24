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
