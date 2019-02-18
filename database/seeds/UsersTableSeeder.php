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
        $users = array_chunk($users, 500);
        foreach ($users as $user) {
            User::insert($user);
        }

        User::inRandomOrder()->take(200)->get()->each(function (User $user) {
            $user->addMediaFromUrl(
                resource_path('seed/avatar-images/'.rand(1, 20).'.jpg')
            )->toMediaCollection(enum('media.user.avatar'));
        });

        User::find(1)->assignRole('admin')->update(['email'=> 'admin@base.com']);
        User::find(2)->assignRole('editor')->update(['email'=> 'editor@base.com']);
        User::find(3)->assignRole('salesman')->update(['email'=> 'salesman@base.com']);
    }
}
