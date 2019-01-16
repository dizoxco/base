<?php

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Taxonomy;
use App\Models\Variation;
use App\Models\SearchPanel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    protected $seeds = [
//        'migrate',
        'permissions',
        'roles',
        'passport',
        'tags',
        'users',
        'posts',
        'comments',
//        'productPages'
    ];

    /** @var Collection $users */
    private $users;

    /** @var Collection $brands */
    private $brands;

    /** @var Collection $colors */
    private $colors;

    /** @var Collection $types */
    private $types;

    /** @var Tag $cloth */
    private $cloth;

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
            ['name' =>  'manage_users',],

            //  posts permissions
            ['name' =>  'manage_posts',],

            //  tickets permissions
            ['name' =>  'manage_tickets',],

            //  search panels permissions
            ['name' =>  'manage_search_panels',],

            //  businesses permissions
            ['name' =>  'manage_businesses',],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    public function roles()
    {
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'user']);
    }

    public function passport()
    {
        $this->command->call('passport:install');
    }

    public function tags()
    {
        $this->brands = Taxonomy::create(['group_name' => 'brands', 'slug' => 'brands', 'label' => 'برندها'])
            ->tags()->createMany([
                ['label' => 'اپل', 'slug' => 'apple'],
                ['label' => 'نوکیا', 'slug' => 'nokia'],
                ['label' => 'کلمبیا', 'slug' => 'colombia'],
            ]);

        $this->colors = Taxonomy::create(['group_name' => 'colors', 'slug' => 'colors', 'label' => 'رنگ ها'])
            ->tags()->createMany([
                ['label' => 'قرمز', 'slug' => 'red'],
                ['label' => 'سبز', 'slug' => 'green'],
                ['label' => 'ابی', 'slug' => 'blue'],
            ]);

        $this->types = Taxonomy::create(['group_name' => 'types', 'slug' => 'types', 'label' => 'دستگاه ها'])
            ->tags()->createMany([
                ['label' => 'موبایل', 'slug' => 'mobile'],
                ['label' => 'لپ تاپ', 'slug' => 'laptop'],
            ]);

        $this->cloth = Taxonomy::create(['group_name' => 'clothes', 'slug' => 'clothes', 'label' => 'البسه'])
            ->tags()->create(['label' => 'پیراهن', 'slug' => 'shirt']);
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

    public function productPages()
    {
        $faker = Faker\Factory::create('fa_IR');

        $titles = ['آیفون 32', 'ایفون 64', 'ایفون 128', 'مک بوک 13', 'مک بوک 15', 'مک بوک ایر'];
        $slugs = ['iphone32', 'iphone64', 'iphone128', 'macbook13', 'macbook15', 'macbookair'];

        foreach ($titles as $index => $title) {
            /** @var User $user */
            $user = $this->users->random();
            /** @var Variation $product_page */
            $product_page = $user->productsPages()->create([
                'title' =>  $title,
                'slug'  =>  $slugs[$index],
                'abstract' => $faker->sentence,
                'body' => $faker->sentences(3, true),
                'attributes' => json_encode([
                        'CPU' => $faker->macProcessor,
                        'RAM' => mt_rand(3, 16).' GB',
                        'LCD' => mt_rand(5, 15).' Inch',
                    ]),
            ]);

            $selected_colors = $this->colors->random(mt_rand(1, 3))->pluck('slug', 'id')->toArray();
            $selected_warranties = array_random(['Nic', 'PG', 'without'], mt_rand(1, 3));
            $variations = [];
            foreach ($selected_colors as $color) {
                foreach ($selected_warranties as $warranty) {
                    if ($faker->boolean(35)) {
                        continue;
                    }
                    $product = $product_page->products()->create([
                        'options' => json_encode([
                            'color' =>  $color,
                            'warranty' =>  $warranty,
                        ]),
                        'price' => mt_rand(1000000, 10000000),
                        'quantity' => mt_rand(0, 5),
                    ]);
                    $variations[] = [
                        'pid' => $product->id,
                        'color' =>  $color,
                        'warranty' =>  $warranty,
                    ];
                }
            }
            $product_page->update(['variations' => json_encode($variations)]);
            $product_page->tags()->syncWithoutDetaching(array_keys($selected_colors));
            $product_page->tags()->syncWithoutDetaching($this->brands->firstWhere('slug', 'apple')->id);
            if ($index <= 2) {
                $product_page->tags()->syncWithoutDetaching($this->types->firstWhere('slug', 'mobile')->id);
            } else {
                $product_page->tags()->syncWithoutDetaching($this->types->firstWhere('slug', 'laptop')->id);
            }
        }

        SearchPanel::create([
            'title' => 'محصولات اپل',
            'slug' => 'apple',
            'description' => $faker->sentences(3, true),
            'model' => Variation::class,
            'options' => json_encode([
                'color' => [
                    'label' =>  'Rang',
                    'query' =>  'tag',
                    'tag'  =>  $this->colors->map(function ($tag) {
                        return ['id' => $tag->id, 'label' => $tag->label];
                    })->toArray(),
                ],
            ]),
            'filters' => json_encode([
                'brand' => [
                    'label' =>  'Rang',
                    'query' =>  'tag',
                    'tag'  =>  $this->brands->map(function ($tag) {
                        if ($tag->slug === 'apple') {
                            return ['id' => $tag->id, 'label' => $tag->label];
                        }
                    })->filter()->toArray(),
                ],
            ]),
        ]);

        SearchPanel::create([
            'title' => 'محصولات اپل - آیفون',
            'slug' => 'iphone',
            'description' => $faker->sentences(3, true),
            'model' => Variation::class,
            'options' => json_encode([
                'color' => [
                    'label' =>  'Rang',
                    'query' =>  'tag',
                    'tag'  =>  $this->colors->map(function ($tag) {
                        return ['id' => $tag->id, 'label' => $tag->label];
                    })->toArray(),
                ],
            ]),
            'filters' => json_encode([
                'brand' => [
                    'label' =>  'Rang',
                    'query' =>  'tag',
                    'tag'  =>  $this->types->map(function ($tag) {
                        if ($tag->slug == 'mobile') {
                            return ['id' => $tag->id, 'label' => $tag->label];
                        }
                    })->filter()->toArray(),
                ],
            ]),
        ]);

        SearchPanel::create([
            'title' => 'محصولات اپل - مکبوک',
            'slug' => 'macbook',
            'description' => $faker->sentences(3, true),
            'model' => Variation::class,
            'options' => json_encode([
                'color' => [
                    'label' =>  'Rang',
                    'query' =>  'tag',
                    'tag'  =>  $this->colors->map(function ($tag) {
                        return ['id' => $tag->id, 'label' => $tag->label];
                    })->toArray(),
                ],
            ]),
            'filters' => json_encode([
                'brand' => [
                    'label' =>  'Rang',
                    'query' =>  'tag',
                    'tag'  =>  $this->types->map(function ($tag) {
                        if ($tag->slug == 'laptop') {
                            return ['id' => $tag->id, 'label' => $tag->label];
                        }
                    })->filter()->toArray(),
                ],
            ]),
        ]);
    }
}
