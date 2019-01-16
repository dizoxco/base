<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numbers = (int) $this->command->ask('How many articles can be created per user?', 2);
        $this->users->each(
            function (User $user) use ($numbers) {
                for ($i = 1; $i <= $numbers; $i++) {
                    $user->posts()->create(factory(Post::class)->make()->toArray());
                }
            }
        );
        $this->command->line("Seeded {$numbers} posts for each users");
    }
}
