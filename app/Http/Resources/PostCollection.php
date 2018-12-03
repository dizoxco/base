<?php

namespace App\Http\Resources;

class PostCollection extends BaseCollection
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
                        case 'comments':
                            $this->includes[$relation][$item->id] = new CommentCollection($item);
                            break;
                    }
                }
            }
            return (new PostResource($post))->additional($this->additional);
        });
        return parent::toArray($request);
    }
}
