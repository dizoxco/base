<?php

namespace App\Providers;

namespace App\Utility\PasswordBroker;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PasswordBrokerServiceProvider extends BaseServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->registerPasswordBrokerManager();
    }

    protected function registerPasswordBrokerManager()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManager($app);
        });
    }

    public function provides()
    {
        return ['auth.password'];
    }
}
