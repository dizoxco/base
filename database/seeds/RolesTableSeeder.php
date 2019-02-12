<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'admin' => [
                'manage_users',
                'manage_posts',
                'manage_tickets',
                'manage_search_panels',
                'manage_businesses',
                'manage_products',
                'manage_comments',
            ],
            'editor' => [
                'manage_posts',
                'manage_tickets',
                'manage_products',
            ],
            'salesman' => [
                'manage_orders',
            ],
        ];
        foreach ($roles as $name => $permissions) {
            Role::create(['name' => $name])->givePermissionTo($permissions);
        }
    }
}
