<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Process;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    /**
     * Obtener todos los trámites/procesos disponibles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Process::with('steps')
            ->where('active', 1);

        // Filtro por búsqueda
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro por categoría
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $procesos = $query->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($proceso) {
                return [
                    'process_id' => $proceso->process_id,
                    'name' => $proceso->name,
                    'description' => $proceso->description,
                    'process_code' => $proceso->process_code,
                    'category' => $proceso->category,
                    'priority' => $proceso->priority,
                    'deadline_days' => $proceso->deadline_days,
                    'department' => $proceso->department,
                    'steps_count' => $proceso->steps->count(),
                    'created_at' => $proceso->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $procesos,
            'count' => $procesos->count(),
        ]);
    }

    /**
     * Obtener un proceso específico con sus pasos
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $proceso = Process::with(['steps' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->find($id);

        if (!$proceso) {
            return response()->json([
                'success' => false,
                'message' => 'Proceso no encontrado',
            ], 404);
        }

        if (!$proceso->active) {
            return response()->json([
                'success' => false,
                'message' => 'Este proceso no está disponible',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'process_id' => $proceso->process_id,
                'name' => $proceso->name,
                'description' => $proceso->description,
                'process_code' => $proceso->process_code,
                'category' => $proceso->category,
                'priority' => $proceso->priority,
                'deadline_days' => $proceso->deadline_days,
                'department' => $proceso->department,
                'steps' => $proceso->steps->map(function ($step) {
                    return [
                        'step_id' => $step->step_id,
                        'order' => $step->order,
                        'title' => $step->tittle, // Nota: tiene typo en el modelo (tittle en lugar de title)
                        'description' => $step->description,
                        'condition_type' => $step->condition_type,
                    ];
                }),
                'created_at' => $proceso->created_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
