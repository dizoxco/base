<?php

namespace App\Http\Resources;

class CommentCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($post) {
            foreach ($post->getRelations() as $relation => $items) {
                foreach ($items as $item) {
                    switch ($relation) {
                        case 'user':
                            $this->includes[$relation][$item->id] = new UserResource($item);
                            break;
                    }
                }
            }
            return (new CommentResource($post))->additional($this->additional);
        });
        return parent::toArray($request);
    }
}
