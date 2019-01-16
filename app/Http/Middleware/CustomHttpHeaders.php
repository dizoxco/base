<?php

namespace App\Http\Middleware;

use Closure;

class CustomHttpHeaders
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
        if ($request->isXmlHttpRequest()) {
            $response = $next($request);
            $response->header('Content-Type', enum('system.response.json'));

            return $response;
        } else {
            return $next($request);
        }
    }
}
