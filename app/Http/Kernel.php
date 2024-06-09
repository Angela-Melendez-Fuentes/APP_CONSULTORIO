<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ...

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // Otros middleware
        ],

        'api' => [
            'throttle:api',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Otros middleware

        // Aquí registramos el middleware de admin
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
