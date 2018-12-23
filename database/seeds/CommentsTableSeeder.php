<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numbers        =   (int) $this->command->ask('How many comments can be created per post?', 2);
        Post::all()->each(function (Post $post) use ($numbers) {
            for ($i = 1; $i <= $numbers; $i++) {
                $post->comments()->create(factory(Comment::class)->make(
                    [
                        'user_id'   =>  User::inRandomOrder()->first()->id
                    ]
                )->toArray());
            }
        });
        $this->command->line("Seeded {$numbers} comments for each posts");
    }
}
