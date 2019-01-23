<?php

use App\Models\User;

class UsersTableSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('users');
    }

    protected function createFromConfigFile($users)
    {
        $this->create($users['amount']);
    }

    protected function createAndSaveToConfigFile()
    {
        $number = (int) $this->command->ask('How many users do you want?', 10);
        $this->create($number);
        $this->saveToFile(['users' => ['amount' => $number]]);
    }

    protected function create($number)
    {
        $users = factory(User::class, $number)->make()->toArray();
        $password = bcrypt('123456');
        array_walk($users, function (&$user) use ($password) {
            $user['password'] = $password;
        });
        User::insert($users);
    }
}
