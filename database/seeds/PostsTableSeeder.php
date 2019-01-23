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
            factory(Post::class, 10)->create(['user_id' => $editor->id]);
        });

        $faker = Factory::create();
        Post::all()->each(function (Post $post) use ($faker) {
            $image = $faker->image(storage_path('app/tmp'), 400, 300, 'nightlife', false);
            $post->addMediaFromUrl(storage_path("app/tmp/$image"))->toMediaCollection('banner');
        });
    }
}
