<?php

namespace Tests\Browser\Web\Profile;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileDuskTest extends DuskTestCase
{
    use WithFaker, CreatesApplication, DatabaseMigrations;

	/** @test */
    public function it_must_update_the_user_credentials()
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

	/** @test */
	public function it_must_show_the_user_orders()
	{
		$this->browse(function (Browser $browser) {
			$browser->loginAs($user = factory(User::class)->create())
				->visit(route('profile.index'))
				->assertSee('همه سفارش ها')
				->click('#orders_link')
				->assertPathIs(route('profile.orders', [], false));
		});
    }
}
