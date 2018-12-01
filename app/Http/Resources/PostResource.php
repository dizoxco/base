<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
{
    public function toArray($request)
    {
        $relations = $this->getRelations();
        $resource = [
            'type'   =>  'post',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'user_id'       =>  $this->user_id,
                'title'         =>  $this->title,
                'slug'          =>  $this->slug,
                'abstract'      =>  $this->abstract,
                'body'          =>  $this->body,
                'published_at'  =>  $this->when($this->published_at, $this->published_at->timestamp),
                'deletd_at'     =>  $this->when($this->deletd_at, $this->deletd_at->timestamp),
                'created_at'    =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'    =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
            $this->mergeWhen(isset($relations['user']) && count($relations['user']), [
                'relations' => [
                    'user'  =>  $this->user->pluck('id')
                ]
            ]),
            $this->mergeWhen(isset($relations['comments']) && count($relations['comments']), [
                'relations' => [
                    'comments'             =>  $this->comments->pluck('id')
                ]
            ]),
            $this->mergeWhen(isset($relations['tags']) && count($relations['tags']), [
                'relations' => [
                    'comments'             =>  $this->tags->pluck('id')
                ]
            ]),
        ];
        return $resource;
    }
}
