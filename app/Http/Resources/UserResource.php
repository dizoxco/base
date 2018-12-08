<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{

    public function toArray($request)
    {
        $resource = [
            'type'   =>  'user',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'name'              =>  $this->name,
                'email'             =>  $this->email,
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
            'relations' =>  [
                $this->whenLoaded('avatar', function () {
                    return ['avatar'    =>  $this->avatar];
                }),
                $this->whenLoaded('posts', function () {
                    return ['posts'     =>  $this->posts->pluck('id')];
                }),
                $this->whenLoaded('comments', function () {
                    return ['comments'  =>  $this->posts->pluck('id')];
                }),
            ],
        ];
        return $resource;
    }
}
