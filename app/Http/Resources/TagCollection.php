<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class TagCollection extends BaseCollection
{
    /**
     * TagCollection constructor.
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function ($tag) {
            foreach ($tag->getRelations() as $relation => $items) {
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

            return (new TagResource($tag))->additional($this->additional);
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
