<?php

namespace App\Services\API\Requests;

use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Process;
use App\Models\Step;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\ActivityLogger;

class RequestService
{
    public function index(Request $request)
    {
        $user = $request->user();

        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $query = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('request_code', 'like', '%' . $search . '%')
                    ->orWhereHas('process', function ($processQuery) use ($search) {
                        $processQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($req) {
                return [
                    'request_id' => $req->request_id,
                    'request_code' => $req->request_code,
                    'status' => $req->status,
                    'process' => [
                        'id' => $req->process->process_id,
                        'name' => $req->process->name,
                    ],
                    'steps' => $req->requestSteps->map(function ($reqStep) {
                        return [
                            'request_step_id' => $reqStep->request_step_id,
                            'step_id' => $reqStep->step_id,
                            'status' => $reqStep->status,
                            'order' => $reqStep->step?->order,
                        ];
                    }),
                    'created_at' => $req->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $requests,
            'count' => $requests->count(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'process_id' => 'required|integer|exists:processes,process_id',
            'details' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        $worker = Worker::where('user_id', $user->users_id)->first();
        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $process = Process::with('steps')->find($validated['process_id']);
        if (!$process || !$process->active) {
            return response()->json([
                'success' => false,
                'message' => 'El proceso no está disponible',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $requestCode = 'REQ-' . strtoupper(uniqid());

            $newRequest = WorkerRequest::create([
                'request_code' => $requestCode,
                'worker_id' => $worker->workers_id,
                'process_id' => $process->process_id,
                'status' => 'pendiente',
                'details' => $validated['details'] ?? null,
                'deadline_at' => $process->deadline_days
                    ? Carbon::now()->addDays($process->deadline_days)
                    : null,
            ]);

            foreach ($process->steps as $step) {
                RequestStep::create([
                    'request_id' => $newRequest->request_id,
                    'step_id' => $step->step_id,
                    'status' => $step->order === 1 ? 'en_progreso' : 'pendiente',
                ]);
            }


                'success' => true,
                'message' => 'Trámite creado exitosamente',
                'data' => [
                    'request_id' => $newRequest->request_id,
                    'request_code' => $newRequest->request_code,
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el trámite',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $req = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id)
            ->find($id);

        if (!$req) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'request_id' => $req->request_id,
                'request_code' => $req->request_code,
                'status' => $req->status,
                'process' => [
                    'id' => $req->process->process_id,
                    'name' => $req->process->name,
                    'description' => $req->process->description,
                ],
                'steps' => $req->requestSteps->map(function ($reqStep) {
                    return [
                        'request_step_id' => $reqStep->request_step_id,
                        'step_id' => $reqStep->step_id,
                        'title' => $reqStep->step?->tittle,
                        'description' => $reqStep->step?->description,
                        'status' => $reqStep->status,
                        'order' => $reqStep->step?->order,
                    ];
                }),
                'created_at' => $req->created_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function nextStep(Request $request, $id)
    {
        $user = $request->user();
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $req = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id)
            ->find($id);

        if (!$req) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado',
            ], 404);
        }

        $currentStep = $req->requestSteps()->where('status', 'en_progreso')->first();
        if (!$currentStep) {
            return response()->json([
                'success' => false,
                'message' => 'No hay pasos en progreso para este trámite',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $currentStep->status = 'completado';
            $currentStep->completed_at = Carbon::now();
            $currentStep->save();

            $nextStep = $req->requestSteps()
                ->where('status', 'pendiente')
                ->orderBy('step_id')
                ->first();

            if ($nextStep) {
                $nextStep->status = 'en_progreso';
                $nextStep->save();
            } else {
                $req->status = 'completado';
                $req->completed_at = Carbon::now();
                $req->save();
            }

            DB::commit();

            $stepName = $currentStep->step?->tittle ?? 'Paso';
            ActivityLogger::log(
                'tramite.paso.completado',
                "Worker {$user->name} completó el paso {$stepName} del trámite {$req->request_id} desde app móvil.",
                $user->users_id
            );
            if (!$nextStep) {
                ActivityLogger::log(
                    'tramite.completado',
                    "Worker {$user->name} completó el trámite {$req->request_id} ({$req->process->name}) desde app móvil.",
                    $user->users_id
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Paso completado exitosamente',
                'data' => [
                    'request_id' => $req->request_id,
                    'current_step_id' => $currentStep->request_step_id,
                    'next_step_id' => $nextStep?->request_step_id,
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al completar el paso',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function conditionalStep(Request $request, $id)
    {
        $validated = $request->validate([
            'condition_type' => 'required|in:aprobado,rechazado',
            'comments' => 'nullable|string|max:500',
        ]);

        $user = $request->user();
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $req = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id)
            ->find($id);

        if (!$req) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado',
            ], 404);
        }

        $currentStep = $req->requestSteps()->where('status', 'en_progreso')->first();
        if (!$currentStep) {
            return response()->json([
                'success' => false,
                'message' => 'No hay pasos en progreso para este trámite',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $currentStep->status = $validated['condition_type'] === 'aprobado' ? 'completado' : 'rechazado';
            $currentStep->completed_at = Carbon::now();
            $currentStep->comments = $validated['comments'] ?? null;
            $currentStep->save();

            if ($validated['condition_type'] === 'aprobado') {
                $nextStep = $req->requestSteps()
                    ->where('status', 'pendiente')
                    ->orderBy('step_id')
                    ->first();

                if ($nextStep) {
                    $nextStep->status = 'en_progreso';
                    $nextStep->save();
                } else {
                    $req->status = 'completado';
                    $req->completed_at = Carbon::now();
                    $req->save();
                }
            } else {
                $req->status = 'rechazado';
                $req->save();
            }


                'success' => true,
                'message' => 'Acción realizada exitosamente',
                'data' => [
                    'request_id' => $req->request_id,
                    'current_step_id' => $currentStep->request_step_id,
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el paso condicional',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

