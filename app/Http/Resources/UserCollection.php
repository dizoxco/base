<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray($request)
    {
      // dd($this->collection);
        $includes = [];
        $this->collection->transform(function (User $user) use (&$includes) {
            // if ($user->id == 3)
            //     dd($user);
            $relations = $user->getRelations();
            if (isset($relations['posts']) && count($relations['posts'])) {
                dd($relations['posts']);
            }
            foreach ($user->getRelations() as $model => $items) {
                foreach ($items as $item) {
                    $includes[$model][$item->id] = $item;
                }
            }
            // }
            // if(count($user->posts))
            //   dd($user->posts);
            // $posts[200] = 'fff';
            // foreach ($user->posts as $post) {
            //     $posts[$post->id] = $post;
            // }
            // dd ($user->relationLoaded('posts'));
            //
            // dd($user->relations['posts']);
            return (new UserResource($user))->additional($this->additional);
        });
        dd($includes);
        return parent::toArray($request);
    }
    public function with($request)
    {
        $posts = [];
        foreach ($this->collection as $user) {
            foreach ($user->posts as $post) {
                $posts[$post->id] = $post;
            }
        }
        // $posts  =   $this->collection->flatMap(
        //     function ($user) {
        //         return $user->posts;
        //     }
        // );
        // dd($posts);
        return [
            'included' => [
                'posts' => $posts
            ]
        ];
    }
}
