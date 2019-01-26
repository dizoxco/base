<?php

namespace App\Http\Resources;

class ProductResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'type'   =>  'product',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'user_id'      =>  $this->user_id,
                'title'        =>  $this->title,
                'slug'         =>  $this->slug,
                'abstract'     =>  $this->abstract,
                'body'         =>  $this->body,
            ],
            'relations' =>  [
                $this->whenLoaded('user', function () {
                    return ['user'  =>  $this->user->id];
                })
            ],
        ];

        return $resource;
    }
}
