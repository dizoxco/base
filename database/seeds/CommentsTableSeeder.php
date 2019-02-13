<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $amount = 1000;
        $users = User::count();
        $types = [Post::class, Product::class, Ticket::class];

        while ($amount) {
            $comments[] = factory(Comment::class)->make([
                'commentable_id' => rand(1, 100),
                'commentable_type' => $types[rand(0, 2)],
                'user_id' => rand(1, $users),
            ])->toArray();
            $amount--;
        }
        $comments = array_chunk($comments, 400);
        foreach ($comments as $comment) {
            Comment::insert($comment);
        }
    }
}
