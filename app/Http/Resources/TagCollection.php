<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TagCollection extends BaseCollection
{
    /**
     * TagCollection constructor.
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function ($post) {
            foreach ($post->getRelations() as $relation => $items) {
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

            return (new TagResource($post))->additional($this->additional);
        });

        return parent::toArray($request);
    }

    public function resource($relation)
    {
        switch ($relation) {
            case 'taxonomy':
                return TaxonomyResource::class;
                break;
            case 'posts':
                return PostResource::class;
                break;
            case 'products':
                return ProductResource::class;
                break;
        }
    }
}
