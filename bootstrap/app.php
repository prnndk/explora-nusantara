<?php

use App\Http\Middleware\EnsureRegistrationIsComplete;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verify-registration' => EnsureRegistrationIsComplete::class,
            'role' => \App\Http\Middleware\Role::class
        ]);
        // $middleware->alias(['role' => \App\Http\Middleware\Role::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();