<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
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
                'banner'        =>  $this->banner,
                'attachments'   =>  $this->attachments,
                $this->mergeWhen($this->dates(), $this->dates())
            ],
            'relations' =>  [
                $this->whenLoaded('user', function () {
                    return ['user'  =>  $this->user->id];
                }),
                $this->whenLoaded('comments', function () {
                    return ['comments'  =>  $this->comments->pluck('id')];
                }),
                $this->whenLoaded('tags', function () {
                    return ['tags'  =>  $this->tags->pluck('id')];
                }),
            ]
        ];
        return $resource;
    }

    private function dates()
    {
        $dates = [];
        $dateColumns = ['published_at', 'deleted_at', 'created_at', 'updated_at'];
        foreach ($dateColumns as $column) {
            if ($this->{$column} !== null) {
                $dates[$column] = $this->{$column}->timestamp;
            }
        }
        return empty($dates) ? false : $dates;
    }
}
