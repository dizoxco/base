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
                'verify'            =>  $this->verify,
                $this->mergeWhen($this->dates(), $this->dates())
            ]
        ];
        return $resource;
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
