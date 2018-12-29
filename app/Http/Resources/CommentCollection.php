<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class CommentCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($comment) {
            foreach ($comment->getRelations() as $relation => $items) {
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
                //  fixme: comment collection do not have media included
            }

            return (new CommentResource($comment))->additional($this->additional);
        });

        return parent::toArray($request);
    }

    public function resource($relation)
    {
        switch ($relation) {
            case 'media':
                return MediaResource::class;
                break;
        }
    }
}
