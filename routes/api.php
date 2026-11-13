<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\DirectorController;
use App\Http\Controllers\Api\PeliculaController;
use App\Models\Categoria;
use App\Models\Director;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json([
        'ok' => true,
        'app' => 'Cinematico API (Laravel + MySQL)',
        'database' => config('database.connections.mysql.database'),
        'stats' => [
            'peliculas' => Pelicula::count(),
            'directores' => Director::count(),
            'categorias' => Categoria::count(),
        ],
    ]);
});

// Endpoint general para la simulación del complejo de salas de cine con todas las películas
Route::get('/salas', function () {
    $peliculas = Pelicula::with(['director', 'categoria'])
        ->orderBy('Identificador', 'asc')
        ->get()
        ->map(fn (Pelicula $p) => PeliculaController::formatPelicula($p));

    return response()->json([
        'ok' => true,
        'complejo' => 'Cinemático Multiplex Digital',
        'total_salas' => $peliculas->count(),
        'salas' => $peliculas,
    ]);
});

Route::apiResource('peliculas', PeliculaController::class);
Route::apiResource('directores', DirectorController::class);
Route::apiResource('categorias', CategoriaController::class);
