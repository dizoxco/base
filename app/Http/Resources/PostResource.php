<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
{
    public function toArray($request)
    {
        return [
            'type'   =>  'post',
            'id'     =>  $this->id,
            'attributes'   =>  [
                'title'             =>  $this->title,
                'slug'              =>  $this->slug,
                'body'              =>  $this->body,
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
            // 'relationships'   =>  new UsersRelationshipResource($this),
        ];
    }
}
