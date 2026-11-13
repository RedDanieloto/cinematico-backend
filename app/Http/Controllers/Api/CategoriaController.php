<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * GET /api/categorias
     */
    public function index(): JsonResponse
    {
        $categorias = Categoria::withCount('peliculas')
            ->orderBy('Identificador', 'asc')
            ->get()
            ->map(fn (Categoria $c) => [
                'Identificador' => (int) $c->Identificador,
                'Categoria' => $c->Categoria,
                'Categoría' => $c->Categoria,
                'TotalPeliculas' => (int) $c->peliculas_count,
            ]);

        return response()->json([
            'ok' => true,
            'total' => $categorias->count(),
            'data' => $categorias,
        ]);
    }

    /**
     * GET /api/categorias/{id}
     */
    public function show(int $id): JsonResponse
    {
        $categoria = Categoria::with(['peliculas.director', 'peliculas.categoria'])->find($id);

        if (!$categoria) {
            return response()->json([
                'ok' => false,
                'message' => 'Categoría no encontrada',
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'Identificador' => (int) $categoria->Identificador,
                'Categoria' => $categoria->Categoria,
                'Categoría' => $categoria->Categoria,
                'Peliculas' => $categoria->peliculas->map(fn ($p) => PeliculaController::formatPelicula($p)),
            ],
        ]);
    }

    /**
     * POST /api/categorias
     */
    public function store(Request $request): JsonResponse
    {
        $nombreCategoria = $request->input('Categoria', $request->input('Categoría'));
        $request->merge(['Categoria' => $nombreCategoria]);

        $validated = $request->validate([
            'Categoria' => 'required|string|max:100',
        ]);

        $categoria = Categoria::create($validated);

        return response()->json([
            'ok' => true,
            'message' => 'Categoría registrada correctamente',
            'data' => [
                'Identificador' => (int) $categoria->Identificador,
                'Categoria' => $categoria->Categoria,
                'Categoría' => $categoria->Categoria,
                'TotalPeliculas' => 0,
            ],
        ], 201);
    }

    /**
     * PUT /api/categorias/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'ok' => false,
                'message' => 'Categoría no encontrada',
            ], 404);
        }

        $nombreCategoria = $request->input('Categoria', $request->input('Categoría'));
        $request->merge(['Categoria' => $nombreCategoria]);

        $validated = $request->validate([
            'Categoria' => 'required|string|max:100',
        ]);

        $categoria->update($validated);

        return response()->json([
            'ok' => true,
            'message' => 'Categoría actualizada correctamente',
            'data' => [
                'Identificador' => (int) $categoria->Identificador,
                'Categoria' => $categoria->Categoria,
                'Categoría' => $categoria->Categoria,
            ],
        ]);
    }

    /**
     * DELETE /api/categorias/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'ok' => false,
                'message' => 'Categoría no encontrada',
            ], 404);
        }

        $categoria->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Categoría eliminada correctamente',
        ]);
    }
}
