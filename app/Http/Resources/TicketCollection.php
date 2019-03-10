<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TicketCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($chat) {
            foreach ($chat->getRelations() as $relation => $items) {
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

            return (new TicketResource($chat))->additional($this->additional);
        });

        return parent::toArray($request);
    }

    public function resource($relation)
    {
        switch ($relation) {
            case 'users':
                return UserResource::class;
                break;
            case 'comments':
                return CommentResource::class;
                break;
        }
    }
}
