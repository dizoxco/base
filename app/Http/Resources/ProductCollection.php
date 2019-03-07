<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

class ProductCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function ($product) {
            foreach ($product->getRelations() as $relation => $items) {
                $resource = $this->resource($relation);
                if ($items instanceof Model) {
                    $this->includes[$relation][$items->id] = new $resource($items);
                    break;
                }

                if ($items instanceof Collection) {
                    foreach ($items as $item) {
                        $this->includes[$relation][$item->id] = new $resource($item);
                    }
                }
            }

            return (new ProductResource($product))->additional($this->additional);
        });

        return parent::toArray($request);
    }

    public function resource($relation)
    {
        switch ($relation) {
            case 'tags':
                return TagResource::class;
                break;
            case 'users':
                return UserResource::class;
                break;
            case 'comments':
                return CommentResource::class;
                break;
            case 'businesses':
                return BusinessResource::class;
                break;
            case 'variations':
                return VariationResource::class;
                break;
        }
    }
}
