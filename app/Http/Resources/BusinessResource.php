<?php

namespace App\Http\Resources;

class BusinessResource extends BaseResource
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
            'type'   =>  'business',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'user_id'      =>  $this->user_id,
                'brand'        =>  $this->brand,
                'province'     =>  $this->province,
                'city'         =>  $this->city,
                'tell'         =>  $this->tell,
            ],
            'relations' =>  [
                $this->whenLoaded('user', function () {
                    return ['user'  =>  $this->user->id];
                }),
            ],
        ];

        return $resource;
    }
}
