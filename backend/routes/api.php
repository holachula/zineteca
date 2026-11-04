<?php
// backend/routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\TematicaController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAutorController;
use App\Http\Controllers\AuthorProfileController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| AUTHOR PROFILE ROUTES
|--------------------------------------------------------------------------
|
| Estas rutas permiten que el autor autenticado
| consulte y actualice su perfil.
|
| Se protegen con:
|
| auth:sanctum → verifica que el usuario tenga token válido
| author       → verifica que el usuario tenga rol de autor
|
*/
/*
|-------------------------------------------------------------------------- 
| API INFO
|-------------------------------------------------------------------------- 
| Endpoint base para verificar que la API está funcionando
| Devuelve información básica del sistema
|-------------------------------------------------------------------------- 
*/
Route::get('/', function () {
    return response()->json([
        'api' => 'Zineteca Nacional',
        'version' => '1.0',
        'status' => 'OK'
    ]);
});

/*
|-------------------------------------------------------------------------- 
| HOME (Endpoints públicos para el Home dinámico)
|-------------------------------------------------------------------------- 
| Aquí centralizamos todo lo necesario para:
| - Comics del home
| - Autores del home
| - Filtros dinámicos (para selects)
|-------------------------------------------------------------------------- 
*/
Route::prefix('home')->group(function () {

    // Todos los comics con relaciones: autor, géneros, temáticas
    Route::get('/comics', [HomeController::class, 'comics']);

    // Todos los autores con sus comics y relaciones
    Route::get('/autores', [HomeController::class, 'autores']);

    // =============================
    // ENDPOINTS PARA FILTROS DINÁMICOS
    // =============================

    // Lista de géneros disponibles (para select)
    Route::get('/generos', [GeneroController::class, 'index']);

    // Lista de temáticas disponibles (para select)
    Route::get('/tematicas', [TematicaController::class, 'index']);

    // Lista de estados únicos de autores (distinct)
    Route::get('/estados', [HomeController::class, 'estados']);

    // Lista de años de publicación únicos (distinct)
    Route::get('/anios', [HomeController::class, 'anios']);

    // Opcional: endpoint que devuelve todos los filtros disponibles juntos
    // Útil para selects dependientes y reactivos en Angular
    Route::get('/filtros-disponibles', [HomeController::class, 'filtrosDisponibles']);
});

/*
|-------------------------------------------------------------------------- 
| PUBLICO (EndPoints generales fuera del home)
|-------------------------------------------------------------------------- 
*/

// AUTORES
Route::get('/autores', [AutorController::class, 'index']);
Route::get('/autores/{slug}', [AutorController::class, 'show']);

// GENEROS
Route::get('/generos', [GeneroController::class, 'index']);
Route::get('/generos/{id}', [GeneroController::class, 'show']);

// TEMATICAS
Route::get('/tematicas', [TematicaController::class, 'index']);
Route::get('/tematicas/{id}', [TematicaController::class, 'show']);

// COMICS
Route::get('/comics', [ComicController::class, 'index']);
Route::get('/comics/{slug}', [ComicController::class, 'show']);

/*
|-------------------------------------------------------------------------- 
| AUTENTICACION
|-------------------------------------------------------------------------- 
*/
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

/*
|-------------------------------------------------------------------------- 
| AUTHOR (Panel de autor autenticado)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth:sanctum', 'author'])->group(function () {

    // Perfil del autor
    Route::get('/author/profile', [AuthorProfileController::class, 'show']);
    Route::put('/author/profile', [AuthorProfileController::class, 'update']);

    // Gestión de comics del autor
    Route::get('/author/comics', [ComicController::class, 'myComics']);
    Route::post('/author/comics', [ComicController::class, 'storeForAuthor']);
    Route::put('/author/comics/{id}', [ComicController::class, 'updateForAuthor']);
});

/*
|-------------------------------------------------------------------------- 
| ADMIN (Panel de administrador)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // Gestión de autores
    Route::post('/autores', [AutorController::class, 'store']);
    Route::put('/autores/{id}', [AutorController::class, 'update']);
    Route::delete('/autores/{id}', [AutorController::class, 'destroy']);

    // Admin crea autores (User + Autor)
    Route::post('/admin/autores', [AdminAutorController::class, 'store']);

    // Gestión de comics
    Route::post('/comics', [ComicController::class, 'store']);
    Route::put('/comics/{id}', [ComicController::class, 'update']);
    Route::delete('/comics/{id}', [ComicController::class, 'destroy']);

    // Gestión de géneros
    Route::post('/generos', [GeneroController::class, 'store']);
    Route::put('/generos/{id}', [GeneroController::class, 'update']);
    Route::delete('/generos/{id}', [GeneroController::class, 'destroy']);

    // Gestión de temáticas
    Route::post('/tematicas', [TematicaController::class, 'store']);
    Route::put('/tematicas/{id}', [TematicaController::class, 'update']);
    Route::delete('/tematicas/{id}', [TematicaController::class, 'destroy']);
});

/*
|-------------------------------------------------------------------------- 
| HEALTHCHECK
|-------------------------------------------------------------------------- 
| Endpoint para verificar que la API está activa
|-------------------------------------------------------------------------- 
*/
Route::get('/ping', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API funcionando'
    ]);
});