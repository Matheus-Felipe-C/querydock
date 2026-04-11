<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        //Appends Inertia to web middleware to render SPA pages
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        // LTI launches POST from the LMS without Laravel’s CSRF token; the web stack uses
        // PreventRequestForgery (not App\Http\Middleware\VerifyCsrfToken), so exclusions must be registered here.
        $middleware->preventRequestForgery(except: [
            'lti',
            'lti/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
