<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    // Lista de excepciones que no queremos reportar
    protected $dontReport = [];

    // Lista de entradas que no queremos que sean "flash" en la sesión
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        // Aquí puedes registrar callbacks para excepciones
    }

    // Método para manejar autenticaciones fallidas
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        // Para rutas web
        return redirect()->guest(route('login'));
    }

    // Manejo general de excepciones
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}