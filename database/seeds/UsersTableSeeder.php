<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numbers        =   (int) $this->command->ask('How Many Users Do You Want?', 10);
        $this->users    =   factory(User::class, $numbers)->create();
        $this->users->each(
            function (User $user) {
                $user->assignRole(Role::inRandomOrder()->first());
            }
        );
        $this->command->line("Seeded {$numbers} users");
    }
}
