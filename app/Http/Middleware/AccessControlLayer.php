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
     * @param $route_parameter
     * @param $permission
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $route_parameter, $permission = null)
    {
        $user   =   Auth::user() ?? $request->user('api');
        $resource   =  $request->route()->parameter($route_parameter);

        if (!$resource instanceof Model) {
            return $this->forbidden();
        }


        if ($permission !== null) {
            $permission =   $route_parameter;
            if ($user->id !== $resource->user_id && !$user->hasPermissionTo($permission, 'api')) {
                return $this->forbidden();
            }
        } else {
            if ($user->id !== $resource->user_id ) {
                return $this->forbidden();
            }
        }

        return $this->forbidden();
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
