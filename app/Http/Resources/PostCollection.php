<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PostCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($post) {
            foreach ($post->getRelations() as $relation => $items) {
                $resource   =   $this->resource($relation);
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
            return (new PostResource($post))->additional($this->additional);
        });
        return parent::toArray($request);
    }

    public function resource($relation)
    {
        switch ($relation) {
            case 'user':
                return UserResource::class;
                break;
            case 'comments':
                return CommentResource::class;
                break;
        }
    }
}
