<?php
/*
|-------------------------------------------------------------------------- 
| File: backend/app/Http/Controllers/HomeController.php
|-------------------------------------------------------------------------- 
| Controlador encargado de proveer:
| - Comics para el Home
| - Autores para el Home
| - Datos dinámicos para filtros (estados y años)
|
| Nota:
| Los filtros ahora se manejan principalmente en el FRONTEND (Angular),
| por lo tanto aquí solo devolvemos data base y listas de opciones únicas
| para selects dinámicos.
|-------------------------------------------------------------------------- 
*/

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Autor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Obtener todos los comics con relaciones
    |----------------------------------------------------------------------
    | Devuelve todos los comics con:
    | - Autor
    | - Géneros
    | - Temáticas
    |
    | El random ya NO se hace aquí.
    | Se hará en el frontend para mantener consistencia visual.
    |----------------------------------------------------------------------
    */
    public function comics()
    {
        return Comic::with(['autor', 'generos', 'tematicas'])
            ->latest() // ordenados por más recientes
            ->get();
    }

    /*
    |----------------------------------------------------------------------
    | Obtener autores para el Home
    |----------------------------------------------------------------------
    | Devuelve solo usuarios con rol 'author'
    | Incluye sus comics y relaciones necesarias
    |----------------------------------------------------------------------
    */
    public function autores()
    {
        return Autor::with(['comics.generos', 'comics.tematicas'])
            ->get();
    }

    /*
    |----------------------------------------------------------------------
    | Obtener lista única de estados
    |----------------------------------------------------------------------
    | Se usa para llenar el <select> de Estado en el frontend
    | Devuelve solo estados distintos de autores
    |----------------------------------------------------------------------
    */
    public function estados()
    {
        return Autor::whereNotNull('estado')
            ->distinct()
            ->pluck('estado');
    }

    /*
    |----------------------------------------------------------------------
    | Obtener lista única de años de publicación
    |----------------------------------------------------------------------
    | Se usa para llenar el <select> de Año en el frontend
    | Devuelve años únicos ordenados de más reciente a más antiguo
    |----------------------------------------------------------------------
    */
    public function anios()
    {
        return Comic::whereNotNull('anio')
            ->distinct()
            ->orderBy('anio', 'desc')
            ->pluck('anio'); // devuelve array de números
    }

    /*
    |----------------------------------------------------------------------
    | Opcional: Endpoint combinando filtros dependientes
    |----------------------------------------------------------------------
    | Este endpoint puede devolver todos los valores posibles de filtros
    | según los comics actualmente disponibles para que los selects sean
    | reactivos y dependientes entre sí.
    |----------------------------------------------------------------------
    */
    public function filtrosDisponibles()
    {
        $generos = Comic::with('generos')->get()
            ->pluck('generos.*.nombre')
            ->flatten()
            ->unique()
            ->values();

        $tematicas = Comic::with('tematicas')->get()
            ->pluck('tematicas.*.nombre')
            ->flatten()
            ->unique()
            ->values();

        $estados = User::where('role', 'author')
            ->whereNotNull('estado')
            ->pluck('estado')
            ->unique()
            ->values();

        $anios = Comic::whereNotNull('anio')
            ->pluck('anio')
            ->unique()
            ->sortDesc()
            ->values();

        return response()->json([
            'generos' => $generos,
            'tematicas' => $tematicas,
            'estados' => $estados,
            'anios' => $anios
        ]);
    }
}