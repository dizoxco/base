<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions    =   [
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
}
