<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $namespaces =   config('enum.namespaces');
        $classes    =   config('enum.class');

        foreach ($namespaces as $namespace) {
            foreach ($classes as $key => $class) {
                $fullClassName    =   "{$namespace}\\{$class}";
                if (class_exists($fullClassName)) {
                    $this->app->singleton($key, function () use ($fullClassName) {
                        return new $fullClassName;
                    });
                }
            }
        }
    }
}
