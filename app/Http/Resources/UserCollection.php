<?php

namespace App\Http\Resources;

class UserCollection extends BaseCollection
{
    public function toArray($request)
    {
        $this->collection->transform(function ($user) {
            foreach ($user->getRelations() as $relation => $items) {
                foreach ($items as $item) {
                    switch ($relation) {
                        case 'posts':
                            $this->includes[$relation][$item->id] = new MediaResource($item);
                            break;
                        case 'comment':
                            $this->includes[$relation][$item->id] = new CommentResource($item);
                            break;
                    }
                }
            }
            return (new UserResource($user))->additional($this->additional);
        });
        return parent::toArray($request);
    }
}
