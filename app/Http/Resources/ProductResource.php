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
                'title'         =>  $this->title,
                'slug'          =>  $this->slug,
                'abstract'      =>  $this->abstract,
                'body'          =>  $this->body,
                'attributes'    =>  $this->attributes,
                'options'       =>  $this->options,
                'single'        =>  $this->single,
                'price'         =>  $this->price,
                'status'        =>  $this->status,
                'temp'          =>  $this->temp,
                $this->mergeWhen($this->dates(), $this->dates()),
            ],
            'relations' =>  [
                $this->mergeWhen($this->whenLoaded('tags'), [
                    'tags' => $this->tags->pluck('id'),
                ]),
                $this->mergeWhen($this->whenLoaded('users'), [
                    'users' => $this->users->pluck('id'),
                ]),
                $this->mergeWhen($this->whenLoaded('businesses'), [
                    'businesses' => $this->businesses->pluck('id'),
                ]),
                $this->mergeWhen($this->whenLoaded('variations'), [
                    'variations' => $this->variations->pluck('id'),
                ]),
            ],
        ];

        return $resource;
    }
}
