<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        if (! file_exists(base_path('seeder.json'))) {
            touch('seeder.json');
        }

        define('CONFIG', json_decode(file_get_contents(base_path('seeder.json')), true));

        $this->call(PermissionTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PassportTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(TicketTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(BusinessesTableSeeder::class);
        $this->call(MediaTableSeeder::class);
    }
}
