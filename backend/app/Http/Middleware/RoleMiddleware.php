<?php
// RolerMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();

        // No autenticado
        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Rol incorrecto
        if ($user->role !== $role) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        // Si es author, debe tener autor_id válido
        if ($role === 'author' && !$user->autor_id) {
            return response()->json(['error' => 'Autor no vinculado'], 403);
        }

        return $next($request);
    }
}