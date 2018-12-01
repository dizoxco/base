<?php

namespace App\Http\Resources;

class CommentResource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'comment',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'user_id'           =>  $this->user_id,
                'parent_id'         =>  $this->parent_id,
                'body'              =>  $this->body,
                'commentable_id'    =>  $this->commentable_id,
                'commentable_type'  =>  $this->commentable_type,
                'verify'            =>  $this->verify,
                'deleted_at'        =>  $this->when($this->deleted_at, $this->deleted_at->timestamp),
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ]
        ];
        return $resource;
    }
}
