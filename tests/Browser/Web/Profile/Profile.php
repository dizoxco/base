<?php

namespace Tests\Browser\Web\Profile;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class Profile extends DuskTestCase
{
    use WithFaker, CreatesApplication, DatabaseMigrations;

    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($user = factory(User::class)->create())
                ->visit(route('profile.credentials.edit'))
                ->type('email', $this->faker->email)
                ->type('old_password', 123456)
                ->type('password', $password = $this->faker->password)
                ->type('password_confirmation', $password)
                ->press('به روزرسانی')
                ->assertPathIs(route('profile.credentials.edit', [], false));
        });
    }
}
