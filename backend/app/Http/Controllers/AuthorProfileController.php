<?php
// backend/app/Http/Controllers/AuthorProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorProfileController extends Controller
{
    /**
     * GET /api/author/profile
     * Devuelve el perfil del autor autenticado.
     */
    public function show(Request $request)
    {
        // Obtener usuario autenticado vía Sanctum
        $user = $request->user();

        // Verificar que tenga autor asociado
        if (!$user->autor) {
            return response()->json([
                'error' => 'Este usuario no tiene autor asociado'
            ], 404);
        }

        // Retornar modelo autor relacionado
        return response()->json(
            $user->autor
        );
    }

    /**
     * PUT /api/author/profile
     * Permite actualizar datos del autor autenticado.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        if (!$user->autor) {
            return response()->json([
                'error' => 'Este usuario no tiene autor asociado'
            ], 404);
        }

        // Validación parcial (solo campos enviados)
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|string|max:255',
            'bio'    => 'nullable|string',
        ]);

        // Actualiza el modelo autor relacionado al user
        $user->autor->update($validated);

        return response()->json(
            $user->autor
        );
    }
}
