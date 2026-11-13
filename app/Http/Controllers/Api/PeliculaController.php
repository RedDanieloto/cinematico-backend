<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    /**
     * Enriquecer película con datos de su relación y simulación de sala de cine.
     */
    public static function formatPelicula(Pelicula $pelicula): array
    {
        $id = (int) $pelicula->Identificador;

        $posters = [
            1 => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=900&q=80',
            2 => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=900&q=80',
            3 => 'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?auto=format&fit=crop&w=900&q=80',
            4 => 'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?auto=format&fit=crop&w=900&q=80',
            5 => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=900&q=80',
            6 => 'https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?auto=format&fit=crop&w=900&q=80',
        ];

        $defaultPosters = [
            'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1536440136628-849c177e76a1?auto=format&fit=crop&w=900&q=80',
        ];

        $formatos = ['IMAX Laser 3D', 'Sala VIP Dolby Atmos', 'Macro XE Digital', 'Sala Tradicional 4K', 'Sala 4DX Motion', 'Sala IMAX 70mm'];
        $colores = ['#E50914', '#8B5CF6', '#F59E0B', '#EF4444', '#10B981', '#3B82F6'];
        $horariosBase = [
            ['14:30', '17:45', '21:00'],
            ['15:00', '18:15', '21:30'],
            ['16:00', '19:30', '22:45'],
            ['13:45', '17:30', '21:15'],
            ['14:00', '16:45', '19:45'],
            ['15:30', '18:00', '20:30'],
        ];

        // Generar asientos ocupados determinísticos por sala para la simulación
        $ocupadosPorSala = [
            1 => ['A3', 'A4', 'B4', 'B5', 'C2', 'C3', 'C6', 'D4', 'D5', 'E1', 'E2', 'F7'],
            2 => ['A2', 'B3', 'B4', 'C4', 'C5', 'D2', 'D3', 'E5', 'E6'],
            3 => ['A4', 'A5', 'B2', 'B3', 'B6', 'C3', 'C4', 'C5', 'D4', 'D5', 'D6', 'E3', 'E4', 'F4', 'F5'],
            4 => ['A1', 'A2', 'B4', 'B5', 'C1', 'C2', 'C5', 'C6', 'D3', 'D4', 'E4', 'E5', 'F2', 'F3'],
            5 => ['B3', 'B4', 'C4', 'C5', 'D3', 'D4', 'E6', 'E7'],
            6 => ['A5', 'B4', 'B5', 'C3', 'C4', 'D5', 'D6', 'E2', 'E3', 'F6'],
        ];

        $idx = ($id - 1) % 6;
        $asientosOcupados = $ocupadosPorSala[$id] ?? ['B4', 'B5', 'C3', 'C4', 'D4', 'D5'];
        $capacidadTotal = 48; // 6 filas (A-F) x 8 asientos (1-8)

        return [
            'Identificador' => $id,
            'Titulo' => $pelicula->Titulo,
            'IDDirector' => (int) $pelicula->IDDirector,
            'Director' => $pelicula->director?->Director ?? 'Sin director',
            'Duracion' => $pelicula->Duracion,
            'Duración' => $pelicula->Duracion,
            'IDCategoria' => (int) $pelicula->IDCategoria,
            'Categoria' => $pelicula->categoria?->Categoria ?? 'Sin categoría',
            'Categoría' => $pelicula->categoria?->Categoria ?? 'Sin categoría',
            'Sinopsis' => $pelicula->Sinopsis,
            'director_rel' => $pelicula->director,
            'categoria_rel' => $pelicula->categoria,
            'SimulacionSala' => [
                'NumeroSala' => $id,
                'NombreSala' => 'Sala ' . $id . ' · ' . $formatos[$idx],
                'Formato' => $formatos[$idx],
                'ColorTema' => $colores[$idx],
                'PosterUrl' => $posters[$id] ?? $defaultPosters[$id % count($defaultPosters)],
                'Horarios' => $horariosBase[$idx],
                'Filas' => ['A', 'B', 'C', 'D', 'E', 'F'],
                'AsientosPorFila' => 8,
                'CapacidadTotal' => $capacidadTotal,
                'AsientosOcupados' => $asientosOcupados,
                'AsientosDisponibles' => $capacidadTotal - count($asientosOcupados),
                'PrecioBoleto' => 95 + ($idx * 15),
                'EstadoProyeccion' => 'En Cartelera - Proyección Activa',
            ],
        ];
    }

    /**
     * GET /api/peliculas
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pelicula::with(['director', 'categoria']);

        if ($request->filled('IDCategoria')) {
            $query->where('IDCategoria', $request->input('IDCategoria'));
        }

        if ($request->filled('IDDirector')) {
            $query->where('IDDirector', $request->input('IDDirector'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('Titulo', 'like', "%{$search}%")
                  ->orWhere('Sinopsis', 'like', "%{$search}%");
            });
        }

        $peliculas = $query->orderBy('Identificador', 'asc')->get();

        return response()->json([
            'ok' => true,
            'total' => $peliculas->count(),
            'data' => $peliculas->map(fn (Pelicula $p) => self::formatPelicula($p)),
        ]);
    }

    /**
     * GET /api/peliculas/{id}
     */
    public function show(int $id): JsonResponse
    {
        $pelicula = Pelicula::with(['director', 'categoria'])->find($id);

        if (!$pelicula) {
            return response()->json([
                'ok' => false,
                'message' => 'Película no encontrada',
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'data' => self::formatPelicula($pelicula),
        ]);
    }

    /**
     * POST /api/peliculas
     */
    public function store(Request $request): JsonResponse
    {
        $duracion = $request->input('Duracion', $request->input('Duración'));
        $request->merge(['Duracion' => $duracion]);

        $validated = $request->validate([
            'Titulo' => 'required|string|max:200',
            'IDDirector' => 'required|integer|exists:Directores,IDDirector',
            'Duracion' => 'required|string|max:50',
            'IDCategoria' => 'required|integer|exists:Categorias,Identificador',
            'Sinopsis' => 'required|string',
        ]);

        $pelicula = Pelicula::create($validated);
        $pelicula->load(['director', 'categoria']);

        return response()->json([
            'ok' => true,
            'message' => 'Película creada exitosamente en la sala de cine',
            'data' => self::formatPelicula($pelicula),
        ], 201);
    }

    /**
     * PUT /api/peliculas/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $pelicula = Pelicula::find($id);

        if (!$pelicula) {
            return response()->json([
                'ok' => false,
                'message' => 'Película no encontrada',
            ], 404);
        }

        if ($request->has('Duración') && !$request->has('Duracion')) {
            $request->merge(['Duracion' => $request->input('Duración')]);
        }

        $validated = $request->validate([
            'Titulo' => 'sometimes|required|string|max:200',
            'IDDirector' => 'sometimes|required|integer|exists:Directores,IDDirector',
            'Duracion' => 'sometimes|required|string|max:50',
            'IDCategoria' => 'sometimes|required|integer|exists:Categorias,Identificador',
            'Sinopsis' => 'sometimes|required|string',
        ]);

        $pelicula->update($validated);
        $pelicula->load(['director', 'categoria']);

        return response()->json([
            'ok' => true,
            'message' => 'Película actualizada correctamente',
            'data' => self::formatPelicula($pelicula),
        ]);
    }

    /**
     * DELETE /api/peliculas/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $pelicula = Pelicula::find($id);

        if (!$pelicula) {
            return response()->json([
                'ok' => false,
                'message' => 'Película no encontrada',
            ], 404);
        }

        $pelicula->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Película eliminada correctamente',
        ]);
    }
}
