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
                'name'  =>  $this->name,
                'email' =>  $this->email,
                'mobile'=>  $this->mobile,
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
}
