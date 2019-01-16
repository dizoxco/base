<?php

namespace App\Providers;

use Response;
use App\Models\Variation;
use App\Observers\VariationObserver;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->customResponse();

        Variation::observe(VariationObserver::class);
    }

    public function customResponse()
    {
        Response::macro('custom', function (string $key, Throwable $throwable, int $status = 404) {
            if (request()->isXmlHttpRequest()) {
                return Response::json([
                        'message' => trans("http.$key"),
                        'errors' => $throwable->getMessage(),
                    ],
                    $status
                );
            } else {
                abort(500, $throwable->getMessage());
            }
        });
    }
}
