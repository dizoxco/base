<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    public function clearConfigurationCache()
    {
        $this->artisan('config:clear');

        //  return $this because we want to method chain a series of action
        return $this;
    }

    public function installPassport()
    {
        $this->artisan('passport:install', ['--force' =>  true]);

        //  return $this because we want to method chain a series of action
        return $this;
    }

    public function setHeaders()
    {
        $headers    =   [
            'Content-Type'      =>  'application/json',
            'X-Requested-With'  =>  'XMLHttpRequest',
        ];
        return $this->withHeaders($headers);
    }

    public function signInFromWeb()
    {
        $this->actingAs(
            factory(User::class)->create()
        );

        //  return $this because we want to method chain a series of action
        return $this;
    }

    public function signInFromApi()
    {
        $user       =   factory(User::class)->create();
        $uri        =   route('api.auth.login');
        $credential =   [
            'email'     =>  $user->email,
            'password'  =>  '123456',
        ];
        $response   =   $this->postJson($uri, $credential);
        $headers    =   [
            'Accept'            =>  'application/vnd.api+json',
            'Content-Type'      =>  'application/json',
            'X-Requested-With'  =>  'XMLHttpRequest',
            'Authorization'     =>  "{$response->json()['token_type']} {$response->json()['access_token']}"
        ];
        $this->withHeaders($headers);
        return $this;
    }

    public function signOutFromApi()
    {
        $uri    =   route('api.auth.logout');
        $this->getJson($uri);

        //  return $this because we want to method chain a series of action
        return $this;
    }
}
