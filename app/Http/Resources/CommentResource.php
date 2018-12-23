<?php

namespace App\Http\Resources;

class CommentResource extends BaseResource
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
                'stat'              =>  $this->when($this->stat !== null, $this->stat),
                $this->mergeWhen($this->dates(), $this->dates())
            ],
            'relations' =>  [
                $this->whenLoaded('commentable', function () {
                    return ['commentable'     =>  $this->commentable->pluck('id')];
                }),
                $this->whenLoaded('media', function () {
                    return ['media'  =>  $this->media->pluck('id')];
                }),
            ],
            'included'  =>  $this->included()
        ];
        return $resource;
    }

    public function included()
    {
        return [
            $this->whenLoaded('commentable', function () {
                return ['commentable'  =>  new $this->commentable];
            }),
            $this->whenLoaded('media', function () {
                return ['media'     =>  new MediaResource($this->media->first())];
            }),
        ];
    }

    private function dates()
    {
        $dates = [];
        $dateColumns = ['deleted_at', 'created_at', 'updated_at'];
        foreach ($dateColumns as $column) {
            if ($this->{$column} !== null) {
                $dates[$column] = $this->{$column}->timestamp;
            }
        }
        return empty($dates) ? false : $dates;
    }
}
