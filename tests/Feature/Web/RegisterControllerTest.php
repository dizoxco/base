<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_must_return_the_register_view()
    {
        $response = $this->get(route('web.authregister'));
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function it_register_user_with_correct_data()
    {
        $user = array_merge(
            factory(User::class)->make()->toArray(),
            [
                'password' => '123456789',
                'password_confirmation' => '123456789',
            ]
        );

        $this->post(route('web.authregister'), $user)
            ->assertSessionMissing(array_keys($user))
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
            'name' => $user['name'],
        ]);
    }

    /** @test */
    public function it_must_not_register_user_with_wrong_data()
    {
        $names = [
            '',
            str_random(256),
        ];

        $emails = [
            '',
            str_random(256),
            factory(User::class)->create()->email,
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

                    $this->post(route('web.authregister'), $user)
                        ->assertSessionHasErrors()
                        ->assertRedirect(route('home'));

                    $this->assertFalse($this->isAuthenticated());

                    $this->assertDatabaseMissing('users', [
                        'email' => $user['email'],
                        'name' => $user['name'],
                    ]);
                }
            }
        }
    }
}
