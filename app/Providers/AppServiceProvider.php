<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Variation;
use App\Observers\VariationObserver;
use Auth;
use Blade;
use Cookie;
use Illuminate\Support\ServiceProvider;
use Response;
use Throwable;
use View;

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

        View::composer([
            'components.nav.simple',
        ], function ($view) {
            if (Auth::check()) {
                $cart = auth()->user()->cart()->with('variation.product')->get()->pluck('variation');
                $cart = $cart->isEmpty() ? null : $cart;

                $wishlist = auth()->user()->wishlist()->with('users')->get();
                $wishlist = $wishlist->isEmpty() ? null : $wishlist;
            } else {
                if ($cart = json_decode(Cookie::get('cart'), true)) {
                    $cart = Variation::whereIn('id', array_keys($cart))->get();
                }

                if ($wishlist = json_decode(Cookie::get('wishlist'), true)) {
                    $wishlist = Product::whereHas('relatedVariations', function ($query) use ($wishlist) {
                        return $query->whereIn('id', array_keys($wishlist));
                    })->get();
                }
            }

            return $view->with('cart', $cart)->with('wishlist', $wishlist);
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
