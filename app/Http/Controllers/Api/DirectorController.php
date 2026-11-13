<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Director;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    /**
     * GET /api/directores
     */
    public function index(): JsonResponse
    {
        $directores = Director::withCount('peliculas')
            ->orderBy('IDDirector', 'asc')
            ->get()
            ->map(fn (Director $d) => [
                'IDDirector' => (int) $d->IDDirector,
                'Director' => $d->Director,
                'TotalPeliculas' => (int) $d->peliculas_count,
            ]);

        return response()->json([
            'ok' => true,
            'total' => $directores->count(),
            'data' => $directores,
        ]);
    }

    /**
     * GET /api/directores/{id}
     */
    public function show(int $id): JsonResponse
    {
        $director = Director::with(['peliculas.categoria', 'peliculas.director'])->find($id);

        if (!$director) {
            return response()->json([
                'ok' => false,
                'message' => 'Director no encontrado',
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'IDDirector' => (int) $director->IDDirector,
                'Director' => $director->Director,
                'Peliculas' => $director->peliculas->map(fn ($p) => PeliculaController::formatPelicula($p)),
            ],
        ]);
    }

    /**
     * POST /api/directores
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'Director' => 'required|string|max:150',
        ]);

        $director = Director::create($validated);

        return response()->json([
            'ok' => true,
            'message' => 'Director registrado correctamente',
            'data' => [
                'IDDirector' => (int) $director->IDDirector,
                'Director' => $director->Director,
                'TotalPeliculas' => 0,
            ],
        ], 201);
    }

    /**
     * PUT /api/directores/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $director = Director::find($id);

        if (!$director) {
            return response()->json([
                'ok' => false,
                'message' => 'Director no encontrado',
            ], 404);
        }

        $validated = $request->validate([
            'Director' => 'required|string|max:150',
        ]);

        $director->update($validated);

        return response()->json([
            'ok' => true,
            'message' => 'Director actualizado correctamente',
            'data' => [
                'IDDirector' => (int) $director->IDDirector,
                'Director' => $director->Director,
            ],
        ]);
    }

    /**
     * DELETE /api/directores/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $director = Director::find($id);

        if (!$director) {
            return response()->json([
                'ok' => false,
                'message' => 'Director no encontrado',
            ], 404);
        }

        $director->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Director eliminado correctamente',
        ]);
    }
}
