<?php
// backend/app/Http/Controllers/ComicController.php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\ComicPagina;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComicController extends Controller
{

    /* =====================================================
    |  LISTADO PÚBLICO CON FILTROS
    |  GET /api/comics
    |  Devuelve todos los cómics con filtros opcionales
    ======================================================*/
    public function index(Request $request)
    {
        // Eager loading para evitar problema N+1
        $query = Comic::with(['autor', 'generos', 'tematicas']);

        // Filtrar por autor específico
        if ($request->autor_id) {
            $query->where('autor_id', $request->autor_id);
        }

        // Filtrar por estado del autor
        if ($request->estado) {
            $query->whereHas('autor', function ($q) use ($request) {
                $q->where('estado', $request->estado);
            });
        }

        // Filtrar por géneros
        if ($request->genero) {
            $generos = is_array($request->genero)
                ? $request->genero
                : [$request->genero];

            $query->whereHas('generos', function ($q) use ($generos) {
                $q->whereIn('genero_id', $generos);
            });
        }

        // Filtrar por temáticas
        if ($request->tematica) {
            $tematicas = is_array($request->tematica)
                ? $request->tematica
                : [$request->tematica];

            $query->whereHas('tematicas', function ($q) use ($tematicas) {
                $q->whereIn('tematica_id', $tematicas);
            });
        }

        // Orden alfabético
        return $query->orderBy('titulo')->get();
    }


    /* =====================================================
    |  DETALLE PÚBLICO COMPLETO
    |  GET /api/comics/{slug}
    |  Devuelve:
    |   - autor
    |   - generos
    |   - tematicas
    |   - paginas ordenadas
    ======================================================*/
    public function show($slug)
    {
        $comic = Comic::with([
                'autor',
                'generos',
                'tematicas',

                // Cargar páginas en orden ascendente
                'paginas' => function ($query) {
                    $query->orderBy('orden', 'asc');
                }
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($comic);
    }
    


    /* =====================================================
    |  DETALLE SIMPLIFICADO (lector vertical)
    |  GET /api/comics/{slug}
    |  Devuelve solo el cómic y sus páginas
    ======================================================*/
    // public function showBySlug($slug)
    // {
    //     $comic = Comic::where('slug', $slug)
    //         ->with('paginas') // 👈 aquí deben cargarse
    //         ->firstOrFail();

    //     return response()->json($comic);
    // }


    /* =====================================================
    |  CREAR (ADMIN)
    ======================================================*/
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'autor_id' => 'required|integer|exists:autores,id',
        ]);

        $validated['slug'] = Str::slug($validated['titulo']);

        return response()->json(
            Comic::create($validated),
            201
        );
    }


    /* =====================================================
    |  CREAR (AUTHOR)
    |  Soporta portada + múltiples páginas
    ======================================================*/
    public function storeForAuthor(Request $request)
    {
        $user = $request->user();

        // Verificación de seguridad
        if (!$user || !$user->autor) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'anio' => 'nullable|integer',
            'portada' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'paginas.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        // Guardar portada
        $portadaPath = null;
        if ($request->hasFile('portada')) {
            $portadaPath = $request->file('portada')
                ->store('comics/portadas', 'public');
        }

        // Crear cómic
        $comic = $user->autor->comics()->create([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'anio' => $validated['anio'] ?? null,
            'slug' => Str::slug($validated['titulo']),
            'portada' => $portadaPath
        ]);

        // Guardar páginas
        if ($request->hasFile('paginas')) {
            foreach ($request->file('paginas') as $index => $file) {

                $path = $file->store('comics/'.$comic->id, 'public');

                ComicPagina::create([
                    'comic_id' => $comic->id,
                    'imagen' => $path,
                    'orden' => $index + 1
                ]);
            }
        }

        return response()->json(
            $comic->load('paginas'),
            201
        );
    }


    /* =====================================================
    |  UPDATE (AUTHOR)
    ======================================================*/
    public function updateForAuthor(Request $request, $id)
    {
        $user = $request->user();

        if (!$user || !$user->autor) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $comic = $user->autor
            ->comics()
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'anio' => 'nullable|integer',
            'portada' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'paginas.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        if (isset($validated['titulo'])) {
            $validated['slug'] = Str::slug($validated['titulo']);
        }

        if ($request->hasFile('portada')) {
            $validated['portada'] = $request->file('portada')
                ->store('comics/portadas', 'public');
        }

        $comic->update($validated);

        if ($request->hasFile('paginas')) {

            $comic->paginas()->delete();

            foreach ($request->file('paginas') as $index => $file) {

                $path = $file->store('comics/'.$comic->id, 'public');

                ComicPagina::create([
                    'comic_id' => $comic->id,
                    'imagen' => $path,
                    'orden' => $index + 1
                ]);
            }
        }

        return response()->json($comic->load('paginas'));
    }
    public function myComics()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'error' => 'Usuario no autenticado'
            ], 401);
        }

        // 🔹 MUY IMPORTANTE:
        // Usamos autor_id del usuario, NO el id del usuario
        $autorId = $user->autor_id;

        if (!$autorId) {
            return response()->json([
                'error' => 'El usuario no tiene autor asociado'
            ], 400);
        }

        $comics = \App\Models\Comic::where('autor_id', $autorId)
            ->with(['autor', 'generos', 'tematicas'])
            ->get();

        return response()->json($comics);
    }
}