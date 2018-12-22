<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request;
use Symfony\Component\HttpFoundation\Response as HTTP;
use Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->modelNotFound();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function modelNotFound()
    {
        Response::macro('modelNotFound', function () {
            if (request()->isXmlHttpRequest()) {
                return Response::make(
                    [
                        'errors' => ['not_found' => trans('http.not_found')]
                    ],
                    HTTP::HTTP_NOT_FOUND,
                    [
                        'Content-Type'  =>  enum('system.response.json')
                    ]
                );
            } else {
                abort(404);
            }
        });
    }
}
