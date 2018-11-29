<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    protected $seeds = [
        'migrate',
        'permissions',
        'roles',
        'passport',
        'users',
        'posts',
        'comments',
    ];

    /** @var Collection $users */
    private $users;

    public function run()
    {
        foreach ($this->seeds as $seed) {
            $this->command->line("<comment>Processing: </comment> {$seed}");
            call_user_func([$this, $seed]);
            $this->command->info("<comment>Processing: </comment> {$seed} complete");
        }
    }

    public function migrate()
    {
        $this->command->call('migrate:fresh');
    }

    public function permissions()
    {
        $permissions    =   [
            //  user permissions
            ['name' =>  'users',    'guard_name'    =>  'api'],

            //  post permissions
            ['name' =>  'posts',    'guard_name'    =>  'api'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    public function roles()
    {
        Role::create(['name' => 'admin', 'guard_name' => 'api'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'user', 'guard_name' => 'api'])->givePermissionTo(
            Permission::whereName('user.create')->first()
        );
    }

    public function passport()
    {
        $this->command->call('passport:install');
    }

    public function users()
    {
        $numbers        =   $this->command->ask('How Many Users Do You Want?', 10);
        $this->users    =   factory(User::class, $numbers)->create();
        $this->users->each(
            function (User $user) {
                $user->assignRole(Role::inRandomOrder()->first());
            }
        );
        $this->command->line("Seeded {$numbers} users");
    }

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
}
