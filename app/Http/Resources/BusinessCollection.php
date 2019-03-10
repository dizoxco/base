<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BusinessCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($business) {
            foreach ($business->getRelations() as $relation => $items) {
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

            return (new BusinessResource($business))->additional($this->additional);
        });

        return parent::toArray($request);
    }

    public function resource($relation)
    {
        switch ($relation) {
            case 'users':
                return UserResource::class;
                break;
            case 'posts':
                return PostResource::class;
                break;
            case 'avatar':
                return MediaResource::class;
                break;
            case 'chats':
                return ChatResource::class;
                break;
            case 'tickets':
                return ChatResource::class;
                break;
            default:
                throw new Exception("{$relation} not implemented in switch");
        }
    }
}
