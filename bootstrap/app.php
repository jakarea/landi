<?php

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
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'page.access' => \App\Http\Middleware\PageAccessMiddleware::class,
            'track.session' => \App\Http\Middleware\TrackUserSession::class,
        ]);
        
        // Add session tracking to web middleware group
        $middleware->web(append: [
            \App\Http\Middleware\TrackUserSession::class,
        ]);
        
        // Exclude specific routes from CSRF verification
        $middleware->validateCsrfTokens(except: [
            '/student/courses/complete-lesson',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
