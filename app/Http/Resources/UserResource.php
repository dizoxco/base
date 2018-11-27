<?php

namespace App\Http\Resources;

use App\Models\User;
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
            ])
            // 'relations' => [
            //   'posts'             =>  $this->whenLoaded('posts', $this->posts->pluck('id'))
            // ]
        ];
        // if (isset($relations['posts']) && count($relations['posts'])) {
        //     $resource['relations']['posts'] = $relations['posts']->pluck('id');
        // }
        return $resource;
    }
}
