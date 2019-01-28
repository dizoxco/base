<?php

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\MediaGroup;
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
        $media = MediaGroup::find(1)->media;
        $faker = Factory::create();
        Post::all()->each(function (Post $post) use ($faker, $media) {
            // $image = $faker->image(storage_path('app/tmp'), 400, 300, 'nightlife', false);
            $post->banner()->sync([$media->random()->id => ['collection_name' => enum('media.post.banner')]]);
            // $post->addMediaFromUrl(storage_path("app/tmp/$image"))->toMediaCollection('banner');
            // $post->addMediaFromUrl(base_path('resources/seed/blog-images/'.rand(1, 20).'.jpg'))->toMediaCollection('banner');
        });
    }
}
