<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminAutorController extends Controller
{
    // Solo accesible por admin (lo configuraremos en paso 3)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'bio'    => 'nullable|string',
            'comics' => 'array',
            'comics.*.titulo' => 'required|string|max:255',
            'comics.*.descripcion' => 'nullable|string'
        ]);

        // Crear autor
        $autor = Autor::create([
            'nombre' => $validated['nombre'],
            'estado' => $validated['estado'],
            'bio'    => $validated['bio'] ?? null,
            'slug'   => Str::slug($validated['nombre'])
        ]);

        // Crear comics (si vienen)
        if (!empty($validated['comics'])) {
            foreach ($validated['comics'] as $comicData) {
                Comic::create([
                    'titulo' => $comicData['titulo'],
                    'descripcion' => $comicData['descripcion'] ?? null,
                    'autor_id' => $autor->id,
                    'slug' => Str::slug($comicData['titulo'])
                ]);
            }
        }

        return response()->json([
            'message' => 'Autor creado con éxito',
            'autor' => $autor->load('comics')
        ]);
    }
}
