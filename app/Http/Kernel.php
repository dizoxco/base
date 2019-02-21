<?php

namespace App\Http;

use Illuminate\Auth\Middleware\Authorize;
use App\Http\Middleware\CustomHttpHeaders;
use App\Http\Middleware\AccessControlLayer;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        Middleware\TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            Middleware\EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            Middleware\VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            //  Add content-type : application/vnd.api+json to every response
            CustomHttpHeaders::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                  =>  Authenticate::class,
        'auth.basic'            =>  AuthenticateWithBasicAuth::class,
        'bindings'              =>  SubstituteBindings::class,
        'guest'                 =>  Middleware\RedirectIfAuthenticated::class,
        'throttle'              =>  ThrottleRequests::class,
        'can'                   =>  Authorize::class,
        'acl'                   =>  AccessControlLayer::class,
        'role'                  =>  \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission'            =>  \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission'    =>  \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
    ];
}
