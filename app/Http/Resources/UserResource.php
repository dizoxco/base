<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{

    public function toArray($request)
    {
        $relations = $this->getRelations();
        $resource = [
            'type'   =>  'user',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'name'              =>  $this->name,
                'email'             =>  $this->email,
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
            $this->mergeWhen(isset($relations['posts']) && count($relations['posts']), [
                'relations' => [
                    'posts'             =>  $this->posts->pluck('id')
                ]
            ]),
            $this->mergeWhen(isset($relations['comments']) && count($relations['comments']), [
                'relations' => [
                    'comments'             =>  $this->posts->pluck('id')
                ]
            ])
        ];
        return $resource;
    }
}
