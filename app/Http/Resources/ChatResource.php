<?php

namespace App\Http\Resources;

class ChatResource extends BaseResource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'chat',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'type'      =>  $this->type,
                'attribute' =>  $this->when($this->attribute !== null, json_decode($this->attribute)),
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
            'relations' =>  [
                $this->whenLoaded('users', function () {
                    return ['users'     =>  $this->users->pluck('id')];
                }),
                $this->whenLoaded('comments', function () {
                    return ['comments'  =>  $this->comments->pluck('id')];
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

        return ! empty($dates) ? $dates : false;
    }
}
