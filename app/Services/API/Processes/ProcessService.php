<?php

namespace App\Services\API\Processes;

use App\Models\Process;
use Illuminate\Http\Request;

class ProcessService
{
    public function index(Request $request)
    {
        $query = Process::with('steps')
            ->where('active', 1);

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $procesos = $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($proceso) {
                return [
                    'process_id' => $proceso->process_id,
                    'name' => $proceso->name,
                    'description' => $proceso->description,
                    'process_code' => $proceso->process_code,
                    'category' => $proceso->category,
                    'department' => $proceso->department,
                    'steps' => $proceso->steps->map(function ($step) {
                        return [
                            'step_id' => $step->step_id,
                            'order' => $step->order,
                            'title' => $step->tittle,
                            'description' => $step->description,
                            'condition_type' => $step->condition_type,
                        ];
                    }),
                    'created_at' => $proceso->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $procesos,
            'count' => $procesos->count(),
        ]);
    }

    public function show($id)
    {
        $proceso = Process::with('steps')->find($id);

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
                'department' => $proceso->department,
                'steps' => $proceso->steps->map(function ($step) {
                    return [
                        'step_id' => $step->step_id,
                        'order' => $step->order,
                        'title' => $step->tittle,
                        'description' => $step->description,
                        'condition_type' => $step->condition_type,
                    ];
                }),
                'created_at' => $proceso->created_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
