<?php

namespace App\Http\Resources;

class UserResource extends BaseResource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'user',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'name'              =>  $this->name,
                'email'             =>  $this->email,
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
            'relations' =>  [
                $this->mergeWhen($this->whenLoaded('posts'), [
                    'posts' => $this->posts->pluck('id'),
                ]),
                $this->mergeWhen($this->whenLoaded('chats'), [
                    'chats' => $this->chats->pluck('id'),
                ]),
                $this->mergeWhen($this->whenLoaded('tickets'), [
                    'tickets' => $this->tickets->pluck('id'),
                ]),
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
