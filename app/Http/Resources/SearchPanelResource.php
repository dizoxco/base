<?php

namespace App\Http\Resources;

class SearchPanelResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'type'   =>  'searchpanel',
            'id'     =>  (string) $this->id,
            'attributes' => [
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'model' => $this->model,
                'options' => $this->options,
                'filters' => $this->filters,
                'deleted_at'    =>  $this->deleted_at ? $this->deleted_at->toDateTimeString() : $this->deleted_at,
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
        ];
    }
}
