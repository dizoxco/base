<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentsTableSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('comments');
    }

    protected function createFromConfigFile($comments)
    {
        $this->create($comments['amount']);
    }

    protected function createAndSaveToConfigFile()
    {
        $amount = (int) $this->command->ask('Do you want how many comments?', 2);

        $this->create($amount);

        $config_comments['comments'] = ['amount'=> $amount];

        $this->saveToFile($config_comments);
    }

    protected function create($amount): void
    {
        $posts = Post::all();
        $users = User::all();
        while ($amount) {
            $comments[] = factory(Comment::class)->make([
                'commentable_id' => $posts->random()->id,
                'commentable_type' => Post::class,
                'user_id' => $users->random()->id,
            ])->toArray();
            $amount--;
        }
        Comment::insert($comments);
    }
}
