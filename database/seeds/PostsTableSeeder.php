<?php

use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $editors = User::take(10)->inRandomOrder()->get();

        $posts = [];
        $editors->each(function (User $editor) use (&$posts) {
            $posts[] = factory(Post::class, 10)->make(['user_id' => $editor->id])->toArray();
        });
        Post::insert(array_collapse($posts));

        $faker = Factory::create();
        Post::take(25)->inRandomOrder()->each(function (Post $post) use ($faker) {
            $image = $faker->image(storage_path('app/tmp'), 400, 300, 'nightlife', false);
            $post->addMediaFromUrl(storage_path("app/tmp/$image"))->toMediaCollection('banner');
        });
    }
}
