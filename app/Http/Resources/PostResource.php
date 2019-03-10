<?php

namespace App\Http\Resources;

class PostResource extends BaseResource
{
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'post',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'user_id'       =>  $this->user_id,
                'title'         =>  $this->title,
                'slug'          =>  $this->slug,
                'abstract'      =>  $this->abstract,
                'body'          =>  $this->body,
                'created_at'    =>  $this->created_at ? $this->created_at->toDateTimeString() : $this->created_at,
                'published_at'  =>  $this->published_at ? $this->published_at->toDateTimeString() : $this->published_at,
                'updated_at'    =>  $this->updated_at ? $this->updated_at->toDateTimeString() : $this->updated_at,
                'deleted_at'    =>  $this->deleted_at ? $this->deleted_at->toDateTimeString() : $this->deleted_at,
                // 'banner'        =>  $this->banner,
                // 'attachments'   =>  $this->attachments,
            ],
            'relations' =>  [
                $this->mergeWhen($this->whenLoaded('user'), [
                    'user' => $this->user->id,
                ]),
                $this->mergeWhen($this->whenLoaded('banner'), [
                    'banner' => $this->banner[0]->id ?? null,
                ]),
                $this->mergeWhen($this->whenLoaded('tags'), [
                    'tags' => $this->tags->pluck('id'),
                ]),
                $this->mergeWhen($this->whenLoaded('comments'), [
                    'comments' => $this->comments->pluck('id'),
                ]),
            ],
        ];

        return $resource;
    }
}
