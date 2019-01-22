<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRoleSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('assign_roles');
    }

    protected function createFromConfigFile($admins)
    {
        $this->create($admins);
    }

    protected function createAndSaveToConfigFile(): void
    {
        $roles = Role::pluck('name')->toArray();
        foreach ($roles as $role) {
            $amount = (int) $this->command->ask('How many <comment>'.strtoupper($role).'</comment> do you want? ', 1);

            $this->create(['name' => $role, 'amount' => $amount,]);

            $config_assign_roles[] = ['name' => $role, 'amount' => $amount,];
        }
        $this->saveToFile(['assign_roles' => $config_assign_roles]);
    }

    protected function create($admins)
    {
        $users = User::take($admins['amount'])->inRandomOrder()->get();
        foreach ($users as $user) {
            $user->assignRole($admins['name']);
        }
    }
}
