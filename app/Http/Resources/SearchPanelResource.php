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
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
        ];
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
