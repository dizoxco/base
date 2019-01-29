<?php

use Faker\Factory;
use App\Models\Tag;
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
            $post->tags()->sync(Tag::inRandomOrder()->take(3)->pluck('id')->toArray());
            $post->banner()->sync([$media->random()->id => ['collection_name' => enum('media.post.banner')]]);
        });
    }
}
