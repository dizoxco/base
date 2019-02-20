<?php

namespace App\Http\Middleware;

use Cookie;
use Closure;

class ClearCartCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->withCookie(Cookie::get('cart', null));

        return $response;
    }
}
