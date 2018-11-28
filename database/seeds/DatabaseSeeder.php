<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{

    protected $seeds = [
        'migrate',
        'users',
        'posts',
        'comments',
        'passport'
    ];
    /** @var Collection $users */
    private $users;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds as $seed) {
            $this->command->line("Processing: {$seed}");
            call_user_func([$this, $seed]);
        }
    }

    /**
     * (Re)Migrate tables.
     *
     * @return void
     */
    public function migrate()
    {
        $this->command->call('migrate:fresh');
        $this->command->line('Migrated tables.');
    }


    /**
     * Seed users.
     *
     * @return void
     */
    public function users()
    {
        $numbers        =   $this->command->ask('How Many Users Do You Want?', 10);
        $this->users    =   factory(User::class, $numbers)->create();
        $this->command->line("Seeded {$numbers} users");
    }

    /**
     * Seed users.
     *
     * @return void
     */
    public function posts()
    {
        $numbers        =   $this->command->ask('How many articles can be created per user?', 2);
        $this->users->each(
            function (User $user) use ($numbers) {
                for ($i = 1; $i <= $numbers; $i++) {
                    $user->posts()->create(factory(Post::class)->make()->toArray());
                }
            }
        );
        $this->command->line("Seeded {$numbers} posts for each users");
    }

    public function comments()
    {
        $numbers        =   $this->command->ask('How many comments can be created per post?', 2);
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


    /**
     * install passport
     */
    public function passport()
    {
        $this->command->line('Installing Passport.');
        $this->command->call('passport:install');
        $this->command->line('Installing Passport complete.');
    }
}
