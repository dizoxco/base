<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use CreatesApplication,DatabaseMigrations;

    public function clearConfigurationCache()
    {
        $this->artisan('config:clear');

        return $this;
    }

    public function installPassport()
    {
        $this->artisan('passport:install', ['--force' =>  true]);

        return $this;
    }

    public function signInFromApi(User $user = null)
    {
        if ($user === null) {
            $user = factory(User::class)->create();
        }

        $credential = [
            'email'     =>  $user->email,
            'password'  =>  '123456',
        ];
        $uri = route('api.auth.login');
        $response = $this->postJson($uri, $credential);
        $headers = [
            'Accept'            =>  enum('system.response.json'),
            'Content-Type'      =>  enum('system.response.json'),
            'X-Requested-With'  =>  enum('system.request.xhr'),
            'Authorization'     =>  "Bearer {$response->json()['access_token']}",
        ];

        return $this->withHeaders($headers);
    }

    public function signOutFromApi()
    {
        $uri = route('api.auth.logout');
        $this->getJson($uri);

        $headers = [
            'Accept'            =>  enum('system.response.json'),
            'Content-Type'      =>  enum('system.response.json'),
            'X-Requested-With'  =>  enum('system.request.xhr'),
        ];

        return $this->withHeaders($headers);
    }

    public function signInFromWeb()
    {
        $this->actingAs(factory(User::class)->create());

        return $this;
    }
}
