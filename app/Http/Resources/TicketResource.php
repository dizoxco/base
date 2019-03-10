<?php

namespace App\Http\Resources;

class TicketResource extends BaseResource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'ticket',
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
            'included'  =>  $this->included(),
        ];

        return $resource;
    }

    public function included()
    {
        return [
            $this->whenLoaded('comments', function () {
                return ['comments'  =>  new CommentCollection($this->comments)];
            }),
            $this->whenLoaded('users', function () {
                return ['users'     =>  $this->users->pluck('id')];
            }),
        ];
    }
}
