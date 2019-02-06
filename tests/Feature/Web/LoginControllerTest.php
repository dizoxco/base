<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_must_return_the_login_view()
    {
        $response = $this->get(route('web.authlogin'));
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function it_login_user_with_correct_data()
    {
        $user = factory(User::class)->create()->toArray();

        $response = $this->post(route('web.authlogin'), [
            'email' => $user['email'],
            'password' => '123456'
        ]);

        $response->assertSessionMissing('errors');

        $this->assertAuthenticated();
    }

    /** @test */
    public function it_must_not_login_user_with_wrong_data()
    {
        $names = [
            '',
            str_random(256)
        ];

        $emails = [
            '',
            str_random(256),
            factory(User::class)->create()->email
        ];

        $passwords = [
            '',
            str_random(5),
            str_random(6),
        ];

        foreach ($names as $name) {
            foreach ($emails as $email) {
                foreach ($passwords as $password) {
                    $user = [
                        'name' => $name,
                        'email' => $email,
                        'password' => $password,
                    ];

                    $this->post(route('web.authlogin'), $user)
                        ->assertSessionHasErrors()
                        ->assertRedirect(route('home'));

                    $this->assertFalse($this->isAuthenticated());
                }
            }
        }
    }
}
