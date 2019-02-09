<?php


/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
Artisan::command('purge', function () {
    $this->call('clear-compiled');
    $this->call('auth:clear-resets');
    $this->call('cache:clear');
    $this->call('config:clear');
    $this->call('debugbar:clear');
    $this->call('route:clear');
    $this->call('view:clear');
    if ($this->confirm('Do you wish to clear media?')) {
        $this->call('medialibrary:clear');
    }
})->describe('Clears the framework from temporary files');

Artisan::command('session:flush', function () {
    Session::flush();
    Storage::disk('root')->deleteDirectory('framework/sessions');
    Storage::disk('root')->makeDirectory('framework/sessions');
    Storage::disk('root')->put('framework/sessions/.gitignore', '*'.PHP_EOL.'!.gitignore');
});
