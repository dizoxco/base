<?php

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Taxonomy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    protected $seeds = [
        'migrate',
        'permissions',
        'roles',
        'passport',
        'tags',
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
        $permissions = [
            //  users permissions
            ['name' =>  'manage_users', 'guard_name'    =>  'api'],

            //  posts permissions
            ['name' =>  'manage_posts', 'guard_name'    =>  'api'],

            //  tickets permissions
            ['name' =>  'manage_tickets', 'guard_name'  =>  'api'],

            //  search panels permissions
            ['name' =>  'manage_search_panels', 'guard_name'  =>  'api'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    public function roles()
    {
        Role::create(['name' => 'admin', 'guard_name' => 'api'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'user', 'guard_name' => 'api']);
    }

    public function passport()
    {
        $this->command->call('passport:install');
    }

    public function tags()
    {
        Taxonomy::create(['group_name' => 'brand', 'label' => 'برند']);
        Taxonomy::create(['group_name' => 'color', 'label' => 'رنگ']);
        Taxonomy::create(['group_name' => 'mobile', 'label' => 'موبایل']);
        Taxonomy::create(['group_name' => 'shirt', 'label' => 'پیراهن']);

        Tag::create(['group_id' => 1, 'label' => 'سونی', 'slug' => 'sony']);
        Tag::create(['group_id' => 1, 'label' => 'نوکیا', 'slug' => 'nokia']);
        Tag::create(['group_id' => 1, 'label' => 'هواوی', 'slug' => 'huawei']);

        Tag::create(['group_id' => 2, 'label' => 'قرمز', 'slug' => 'red']);
        Tag::create(['group_id' => 2, 'label' => 'ابی', 'slug' => 'blue']);
        Tag::create(['group_id' => 2, 'label' => 'سبز', 'slug' => 'green']);
        Tag::create(['group_id' => 2, 'label' => 'زرد', 'slug' => 'yellow']);

        Tag::create(['group_id' => 3, 'label' => 'موبایل', 'slug' => 'mobile']);
        Tag::create(['group_id' => 4, 'label' => 'پیراهن', 'slug' => 'shirt']);
    }

    public function users()
    {
        $numbers = (int) $this->command->ask('How Many Users Do You Want?', 10);
        $this->users = factory(User::class, $numbers)->create();
        $this->users->each(
            function (User $user) {
                $user->assignRole(Role::inRandomOrder()->first());
            }
        );
        $this->command->line("Seeded {$numbers} users");
    }

    public function posts()
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

    public function comments()
    {
        $numbers = (int) $this->command->ask('How many comments can be created per post?', 2);
        Post::all()->each(function (Post $post) use ($numbers) {
            for ($i = 1; $i <= $numbers; $i++) {
                $post->comments()->create(factory(Comment::class)->make(
                    [
                        'user_id'   =>  User::inRandomOrder()->first()->id,
                    ]
                )->toArray());
            }
        });
        $this->command->line("Seeded {$numbers} comments for each posts");
    }
}
