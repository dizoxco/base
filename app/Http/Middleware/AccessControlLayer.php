<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class AccessControlLayer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $routeParameter
     * @param $permission
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $routeParameter, $permission = null)
    {
        $user       =   Auth::user() ?? $request->user('api');

        if ($user === null) {
            return $this->forbidden();
        }

        if ($permission === null) {
            $permission =   $routeParameter;
            if (!$user->hasPermissionTo($permission, 'api')) {
                return $this->forbidden();
            }
        }

        if ($permission !== null) {
            $resource   =   $request->route()->parameter($routeParameter);
            if (!$resource instanceof Model) {
                return $this->forbidden();
            }

            if ($user->id !== $resource->user_id && !$user->hasPermissionTo($permission, 'api')) {
                return $this->forbidden();
            }
        }

        return $next($request);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    private function forbidden()
    {
        return response(
            [
                'errors' => [
                    'forbidden' => trans('http.forbidden')
                ]
            ],
            Response::HTTP_FORBIDDEN,
            [
                'Content-Type' => 'application/vnd.api+json',
            ]
        );
    }
}
