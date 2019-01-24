<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignRoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'admin' => 10,
            'editor' => 10,
            'salesman' => 10,
        ];

        foreach ($roles as $name => $amount) {
            $role_id = Role::whereName($name)->first(['id'])->id;
            $user_ids = User::take($amount)->inRandomOrder()->pluck('id')->toArray();
            $users = [];
            foreach ($user_ids as $user_id) {
                $users[] = [
                    'role_id' => $role_id,
                    'model_type' => User::class,
                    'model_id' => $user_id,
                ];
            }
            DB::table('model_has_roles')->insert($users);
        }
    }
}
