<?php

namespace App\Providers;

use Blade;
use Response;
use Throwable;
use App\Models\Variation;
use App\Observers\VariationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // \Schema::defaultStringLength(255);
        $this->customResponse();

        Variation::observe(VariationObserver::class);

        Blade::directive('rial', function ($expr = 0) {
            return "<?php echo number_format($expr).' ریال'; ?>";
        });

        Blade::directive('toman', function ($expr = 0) {
            return "<?php echo number_format($expr).' تومان'; ?>";
        });
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
