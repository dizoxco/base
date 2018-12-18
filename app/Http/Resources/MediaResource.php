<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MediaResource extends Resource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'media',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'model_id'          =>  $this->model_id,
                'model_type'        =>  $this->model_type,
                'collection_name'   =>  $this->collection_name,
                'name'              =>  $this->name,
                'file_name'         =>  $this->file_name,
                'mime_type'         =>  $this->mime_type,
                'disk'              =>  $this->disk,
                'size'              =>  $this->size,
                'manipulations'     =>  $this->manipulations,
                'custom_properties' =>  $this->custom_properties,
                'responsive_images' =>  $this->responsive_images,
                'order_column'      =>  $this->order_column,
                $this->mergeWhen($this->dates(), $this->dates())
            ]
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
