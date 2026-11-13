<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'proyecto' => 'Cinemático - Backend Laravel + MySQL',
        'base_de_datos' => 'cinematico (MySQL)',
        'tablas' => [
            'Peliculas' => ['Identificador', 'Titulo', 'IDDirector', 'Duracion', 'IDCategoria', 'Sinopsis'],
            'Directores' => ['IDDirector', 'Director'],
            'Categorias' => ['Identificador', 'Categoria'],
        ],
        'endpoints_api' => [
            'GET /api/status' => 'Estado de la base de datos y conteo de registros',
            'GET /api/salas' => 'Simulación del complejo de salas de cine de todas las películas',
            'GET /api/peliculas' => 'Listado de todas las películas con Director, Categoría y Sala',
            'GET /api/peliculas/{id}' => 'Detalle de una película por Identificador y simulación de su sala',
            'POST /api/peliculas' => 'Crear una nueva película',
            'PUT /api/peliculas/{id}' => 'Actualizar una película',
            'DELETE /api/peliculas/{id}' => 'Eliminar una película',
            'GET /api/directores' => 'Listado de todos los directores',
            'POST /api/directores' => 'Crear un nuevo director',
            'GET /api/categorias' => 'Listado de todas las categorías',
            'POST /api/categorias' => 'Crear una nueva categoría',
        ],
    ]);
});
