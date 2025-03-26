<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
    $app->bind(
        \App\Interfaces\CourseRepositoryInterface::class,
        \App\Repositories\CourseRepository::class
    );

    $app->bind(
        App\Interfaces\TagRepositoryInterface::class,
        App\Repositories\TagRepository::class
    );
    
    $app->bind(
        App\Interfaces\SubcategoryRepositoryInterface::class,
        App\Repositories\SubcategoryRepository::class
    );
    