<?php

use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = factory(User::class, 1000)->make()->toArray();
        $password = bcrypt('123456');
        array_walk($users, function (&$user) use ($password) {
            $user['password'] = $password;
        });
        User::insert($users);

        $faker = Factory::create();
        User::take(10)->get()->each(function (User $user) use ($faker) {
            $image = $faker->image(storage_path('app/tmp'), 400, 300, 'people', false);
            $user->addMediaFromUrl(storage_path("app/tmp/$image"))->toMediaCollection('avatar');
        });
    }
}
