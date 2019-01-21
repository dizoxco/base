<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('admins');
    }

    protected function createFromConfigFile($admins)
    {
        $this->create($admins);
    }

    protected function createAndSaveToConfigFile(): void
    {
        $amount = (int) $this->command->ask('How many admins do you want? ', 1);
        $roles = Role::all()->pluck('name')->toArray();

        $admin_roles = [];
        $more_roles = true;
        while ($more_roles) {
            $admin_roles[] = $this->command->anticipate('with which roles?', array_diff($roles, $admin_roles));
            $more_roles = $this->yesOrNo('more roles?');
        }

        $admins = User::take($amount)->inRandomOrder()->get();
        foreach ($admins as $admin) {
            $admin->assignRole($admin_roles);
        }

        $config_users['admins'] = [
            'amount' => $amount,
            'roles' => $admin_roles,
        ];

        $this->saveToFile($config_users);
    }

    protected function create($admins)
    {
        $users = User::take($admins['amount'])->inRandomOrder()->get();
        foreach ($users as $user) {
            $user->assignRole($admins['roles']);
        }
    }
}
