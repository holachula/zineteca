<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

        ->withMiddleware(function (Middleware $middleware) {

            $middleware->group('api', [
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ]);

            // 🔹 Alias personalizados
            $middleware->alias([
                'author' => \App\Http\Middleware\AuthorMiddleware::class,
                'admin'  => \App\Http\Middleware\AdminMiddleware::class,
            ]);

        })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No autenticado'], 401);
            }
        });
    })

    ->create();