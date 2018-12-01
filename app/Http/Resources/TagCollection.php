<?php

namespace App\Http\Resources;

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
                foreach ($items as $item) {
                    switch ($relation) {
                        case 'user':
                            $this->includes[$relation][$item->id] = new UserResource($item);
                            break;
                    }
                }
            }
            return (new TagResource($post))->additional($this->additional);
        });
        return parent::toArray($request);
    }
}
