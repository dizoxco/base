<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $amount = 100;
        $posts = Post::inRandomOrder()->get(['id'])->pluck('id')->toArray();
        $users = User::inRandomOrder()->get(['id'])->pluck('id')->toArray();
        while ($amount) {
            $comments[] = factory(Comment::class)->make([
                'commentable_id' => array_shift($posts),
                'commentable_type' => Post::class,
                'user_id' => array_shift($users),
            ])->toArray();
            $amount--;
        }
        Comment::insert($comments);
    }
}
