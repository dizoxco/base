<?php

use App\Models\Post;
use App\Models\User;
use Spatie\Permission\Models\Role;

class PostsTableSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('posts');
    }

    protected function createFromConfigFile($posts)
    {
        $this->create($posts);
    }

    protected function createAndSaveToConfigFile()
    {
        $amount = (int) $this->command->ask('Do you want how many posts?', 2);
        $roles = Role::pluck('name')->toArray();

        $writers = [];
        $want_more_writers = true;
        while ($want_more_writers) {
            $writers[] = $this->command->anticipate('Which role can have posts?', array_diff($roles, $writers));
            $want_more_writers = $this->yesOrNo('more roles?');
        }

        $config_posts = ['amount'=> $amount, 'roles' => $writers];
        $this->create($config_posts);
        $this->saveToFile($config_posts);
    }

    protected function create($config)
    {
        $writers = User::role($config['roles'])->get();
        while ($config['amount']) {
            $posts[] = factory(Post::class)->make(['user_id' => $writers->random()->id])->toArray();
            $config['amount']--;
        }
        Post::insert($posts);
    }
}
