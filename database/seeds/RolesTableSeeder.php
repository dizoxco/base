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

    // public function createFromConfigFile($roles)
    // {
    //     foreach ($roles as $role) {
    //         Role::create(['name' => $role['name']])->givePermissionTo($role['permissions']);
    //     }
    // }

    // protected function createAndSaveToConfigFile()
    // {
    //     $config_role = [];
    //     $want_more_roles = true;
    //     while ($want_more_roles) {
    //         $name = $this->command->ask('Enter the role name');
    //         $role = Role::create(['name' => $name, 'guard_name' => 'web']);

    //         $available_permissions = array_pluck(config('permission.default'), 'name');

    //         $role_permissions = [];
    //         $want_more_permission = true;
    //         while ($want_more_permission) {
    //             $available_permissions = array_diff($available_permissions, $role_permissions);
    //             $selected_permission = $this->command->anticipate('with which permission?', $available_permissions, '*');
    //             if ($selected_permission === '*') {
    //                 $role_permissions = $available_permissions;
    //                 break;
    //             } else {
    //                 $role_permissions[] = $selected_permission;
    //             }
    //             $want_more_permission = $this->yesOrNo('more permissions?');
    //         }
    //         $role->givePermissionTo($role_permissions);

    //         $config_role['roles'][] = [
    //             'name' => $name,
    //             'permissions' => $role_permissions,
    //         ];

    //         $role_permissions = null;
    //         $want_more_roles = $this->yesOrNo('more roles?');
    //     }

    //     $this->saveToFile($config_role);
    // }

    // protected function create($config)
    // {
    //     // TODO: Implement create() method.
    // }
}
