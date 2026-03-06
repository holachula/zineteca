<?php

// backend/app/Http/Controllers/AuthorProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| AUTHOR PROFILE CONTROLLER
|--------------------------------------------------------------------------
|
| Este controlador permite que el autor autenticado:
|
| 1️⃣ Consulte su perfil
| 2️⃣ Actualice su información
|
| La autenticación se maneja con Laravel Sanctum.
|
| El usuario autenticado tiene una relación:
|
| User → Autor
|
| Por lo tanto obtenemos el perfil con:
|
| $user->autor
|
*/

class AuthorProfileController extends Controller
{

    /**
     * ---------------------------------------------------------
     * GET /api/author/profile
     * ---------------------------------------------------------
     *
     * Devuelve el perfil del autor autenticado.
     */

    public function show(Request $request)
    {

        // Obtener el usuario autenticado a través del token Sanctum
        $user = $request->user();

        // Verificar que tenga un autor asociado
        if (!$user->autor) {

            return response()->json([
                'error' => 'Este usuario no tiene autor asociado'
            ], 404);

        }

        // Retornar los datos del autor
        return response()->json($user->autor);

    }



    /**
     * ---------------------------------------------------------
     * PUT /api/author/profile
     * ---------------------------------------------------------
     *
     * Permite actualizar los datos del autor autenticado.
     */

    /**
 * ---------------------------------------------------------
 * PUT /api/author/profile
 * ---------------------------------------------------------
 *
 * Permite actualizar los datos del autor autenticado.
 */

public function update(Request $request)
{
/*
|--------------------------------------------------------------------------
| DEBUG DEL REQUEST
|--------------------------------------------------------------------------
|
| En lugar de usar dd() (que rompe la respuesta HTTP y genera error CORS),
| registramos la información en el archivo de logs de Laravel.
|
| El archivo se encuentra en:
| storage/logs/laravel.log
|
*/

\Log::info('DEBUG AUTHOR PROFILE UPDATE', [

    // Todos los campos enviados desde Angular
    'inputs' => $request->all(),

    // Todos los archivos enviados
    'files' => $request->allFiles(),

    // Verificar si Laravel detecta el archivo llamado 'perfil'
    'has_perfil' => $request->hasFile('perfil'),

    // Verificar si Laravel detecta el archivo llamado 'foto_perfil'
    'has_foto_perfil' => $request->hasFile('foto_perfil'),

]);
    // Obtener usuario autenticado
    $user = $request->user();

    // Verificar que tenga autor asociado
    if (!$user->autor) {

        return response()->json([
            'error' => 'Este usuario no tiene autor asociado'
        ], 404);

    }

    /*
    ---------------------------------------------------------
    VALIDACIÓN DE DATOS
    ---------------------------------------------------------
    */

    $validated = $request->validate([

        'nombre' => 'sometimes|required|string|max:255',

        'bio' => 'nullable|string',

        'estado' => 'sometimes|required|string|max:255',

        // Imagen de perfil opcional
        'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'

    ]);


    /*
    ---------------------------------------------------------
    ACTUALIZAR CAMPOS DEL AUTOR
    ---------------------------------------------------------
    */

    $user->autor->update($validated);


    /*
---------------------------------------------------------
SUBIR IMAGEN DE PERFIL
---------------------------------------------------------
Si el request contiene un archivo llamado "foto_perfil"
se guarda en el storage público de Laravel.

Ruta final:

storage/app/public/autores/{autor_id}/perfil.jpg
*/

if ($request->hasFile('foto_perfil')) {

    $autor = $user->autor;

    /*
    Obtener el archivo enviado desde el formulario.
    Laravel lo maneja como objeto UploadedFile.
    */
    $file = $request->file('foto_perfil');

    /*
    Guardar archivo en:

    storage/app/public/autores/{autor_id}/perfil.jpg
    */
    $path = $file->storeAs(

        'autores/'.$autor->id,

        'perfil.jpg',

        'public'

    );

    /*
    Guardar la ruta en la base de datos
    ejemplo:
    autores/5/perfil.jpg
    */
    $autor->foto_perfil = $path;

    $autor->save();

}


    /*
    ---------------------------------------------------------
    RESPUESTA
    ---------------------------------------------------------
    */

    return response()->json([
        'message' => 'Perfil actualizado correctamente',
        'autor' => $user->autor
    ]);

}

}