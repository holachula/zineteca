<?php
// backend/app/Http/Controllers/AutorController.php
namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**
     * GET /api/autores
     * Lista todos los autores ordenados por nombre
     */
    public function index()
    {
        return Autor::orderBy('nombre')->get();
    }

    /**
     * GET /api/autores/{slug}
     * Devuelve un autor por slug con sus cómics y relaciones
     */
    public function show($slug)
    {
        $autor = Autor::with([
                'comics.generos',
                'comics.tematicas'
            ])
            ->where('slug', $slug)
            ->first();

        if (!$autor) {
            return response()->json(['error' => 'Autor no encontrado'], 404);
        }

        return response()->json($autor);
    }

    /**
     * POST /api/autores
     * Crear nuevo autor (posiblemente desde admin)
     */
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'crear_usuario' => 'nullable|boolean',
            'email' => 'required_if:crear_usuario,1|email|unique:users,email',
            'password' => 'required_if:crear_usuario,1|string|min:6'
        ]);

        // Crear registro autor
        $autor = Autor::create([
            'nombre' => $validated['nombre'],
            'estado' => $validated['estado'],
        ]);

        // Si se solicita crear usuario vinculado
        if (!empty($validated['crear_usuario']) && $validated['crear_usuario']) {

            $user = \App\Models\User::create([
                'name' => $autor->nombre,
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => 'author',
                'autor_id' => $autor->id,
            ]);

            // Relacionar autor con usuario
            $autor->update(['user_id' => $user->id]);
        }

        return response()->json($autor->load('user'), 201);
    }

    /**
     * PUT /api/autores/{id}
     * Actualiza autor
     */
    public function update(Request $request, $id)
    {
        $autor = Autor::findOrFail($id);

        $autor->update($request->only(['nombre', 'estado']));

        return $autor;
    }

    /**
     * DELETE /api/autores/{id}
     */
    public function destroy($id)
    {
        Autor::findOrFail($id)->delete();
        return response()->json(['message' => 'Autor eliminado']);
    }
}
