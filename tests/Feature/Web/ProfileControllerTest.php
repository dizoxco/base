<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ProfileControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_must_show_the_profile_index()
    {
        $response = $this->signInFromWeb()->get(route('profile.index'));
        $response->assertSuccessful()->assertViewIs('profile.index')->assertViewHas('user');
    }

    /** @test */
    public function it_must_show_credential_for_logged_in_user()
    {
        $response = $this->signInFromWeb()->get(route('profile.credentials.edit'));
        $response->assertSuccessful()->assertViewIs('profile.credentials')->assertViewHas('user');
    }

    /** @test */
    public function it_must_update_credential_for_logged_in_user()
    {
        $this->signInFromWeb();
        $data = [
            'email' => $this->faker->email,
            'old_password' => 123456,
            'password' => $password = $this->faker->password,
            'password_confirmation' => $password,
        ];

        $response = $this->put(route('profile.credentials.update', $data));
        $response
            ->assertSessionMissing('errors')
            ->assertRedirect(route('profile.credentials.edit'));
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    public function testWishlist()
    {
        $response = $this->signInFromWeb()->get(route('profile.wishlist'));
        $response->assertSuccessful()->assertViewIs('profile.wishlist');
    }

    public function testTickets()
    {
        $response = $this->signInFromWeb()->get(route('profile.tickets'));
        $response->assertSuccessful()->assertViewIs('profile.tickets');
    }

    public function testAddresses()
    {
        $response = $this->signInFromWeb()->get(route('profile.addresses'));
        $response->assertSuccessful()->assertViewIs('profile.addresses');
    }

    public function testChats()
    {
        $response = $this->signInFromWeb()->get(route('profile.chats'));
        $response->assertSuccessful()->assertViewIs('profile.chats');
    }

    public function testCart()
    {
        $response = $this->signInFromWeb()->get(route('profile.cart'));
        $response->assertSuccessful()->assertViewIs('profile.cart');
    }

    public function testInfo()
    {
        $response = $this->signInFromWeb()->get(route('profile.info'));
        $response->assertSuccessful()->assertViewIs('profile.info');
    }
}
