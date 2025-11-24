<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Process;
use App\Models\Step;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RequestController extends Controller
{
    /**
     * Obtener todos los trámites del worker autenticado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Obtener el worker asociado al usuario
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $query = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id);

        // Filtro por estado
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($req) {
                // Calcular progreso
                $totalSteps = $req->requestSteps->count();
                $completedSteps = $req->requestSteps->where('request_step_status', 'completed')->count();
                $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;

                // Obtener paso actual
                $currentStep = $req->requestSteps->where('request_step_status', 'in_progress')->first()
                    ?? $req->requestSteps->where('request_step_status', 'pending')->first();

                return [
                    'request_id' => $req->request_id,
                    'process' => [
                        'process_id' => $req->process->process_id,
                        'name' => $req->process->name,
                        'description' => $req->process->description,
                        'category' => $req->process->category,
                        'priority' => $req->process->priority,
                    ],
                    'status' => $req->status,
                    'progress' => $progress,
                    'current_step' => $currentStep ? [
                        'step_id' => $currentStep->step->step_id,
                        'title' => $currentStep->step->tittle,
                        'order' => $currentStep->step->order,
                    ] : null,
                    'start_date' => $req->start_date ? $req->start_date->format('Y-m-d') : null,
                    'end_date' => $req->end_date ? $req->end_date->format('Y-m-d') : null,
                    'created_at' => $req->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $requests,
            'count' => $requests->count(),
        ]);
    }

    /**
     * Iniciar un nuevo trámite
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'process_id' => 'required|exists:processes,process_id',
        ]);

        $user = $request->user();

        // Obtener el worker asociado al usuario
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        // Verificar que el proceso existe y está activo
        $process = Process::with('steps')->find($request->process_id);

        if (!$process || !$process->active) {
            return response()->json([
                'success' => false,
                'message' => 'El proceso no está disponible',
            ], 404);
        }

        // Verificar que el proceso tiene pasos
        if ($process->steps->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'El proceso no tiene pasos configurados',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Crear la solicitud
            $workerRequest = WorkerRequest::create([
                'worker_id' => $worker->workers_id,
                'process_id' => $process->process_id,
                'status' => 'in_progress',
                'start_date' => Carbon::now(),
            ]);

            // Obtener el primer paso (order = 1)
            $firstStep = $process->steps->where('order', 1)->first();

            if (!$firstStep) {
                throw new \Exception('No se encontró el primer paso del proceso');
            }

            // Crear el primer paso como "in_progress" o "pending"
            RequestStep::create([
                'request_id' => $workerRequest->request_id,
                'step_id' => $firstStep->step_id,
                'user_id' => $user->users_id,
                'request_step_status' => 'in_progress',
                'step_date' => Carbon::now(),
            ]);

            // Crear los demás pasos como "pending"
            foreach ($process->steps->where('order', '>', 1) as $step) {
                RequestStep::create([
                    'request_id' => $workerRequest->request_id,
                    'step_id' => $step->step_id,
                    'user_id' => null,
                    'request_step_status' => 'pending',
                    'step_date' => null,
                ]);
            }

            DB::commit();

            // Cargar relaciones para la respuesta
            $workerRequest->load(['process', 'requestSteps.step']);

            return response()->json([
                'success' => true,
                'message' => 'Trámite iniciado exitosamente',
                'data' => [
                    'request_id' => $workerRequest->request_id,
                    'process' => [
                        'process_id' => $workerRequest->process->process_id,
                        'name' => $workerRequest->process->name,
                        'description' => $workerRequest->process->description,
                    ],
                    'status' => $workerRequest->status,
                    'start_date' => $workerRequest->start_date->format('Y-m-d'),
                    'created_at' => $workerRequest->created_at->format('Y-m-d H:i:s'),
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar el trámite: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener detalles de un trámite específico con todos sus pasos
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        // Obtener el worker asociado al usuario
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $workerRequest = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id)
            ->find($id);

        if (!$workerRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado',
            ], 404);
        }

        // Calcular progreso
        $totalSteps = $workerRequest->requestSteps->count();
        $completedSteps = $workerRequest->requestSteps->where('request_step_status', 'completed')->count();
        $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'request_id' => $workerRequest->request_id,
                'process' => [
                    'process_id' => $workerRequest->process->process_id,
                    'name' => $workerRequest->process->name,
                    'description' => $workerRequest->process->description,
                    'category' => $workerRequest->process->category,
                    'priority' => $workerRequest->process->priority,
                    'deadline_days' => $workerRequest->process->deadline_days,
                ],
                'status' => $workerRequest->status,
                'progress' => $progress,
                'start_date' => $workerRequest->start_date ? $workerRequest->start_date->format('Y-m-d') : null,
                'end_date' => $workerRequest->end_date ? $workerRequest->end_date->format('Y-m-d') : null,
                'steps' => $workerRequest->requestSteps->map(function ($requestStep) {
                    return [
                        'request_step_id' => $requestStep->request_step_id,
                        'step' => [
                            'step_id' => $requestStep->step->step_id,
                            'order' => $requestStep->step->order,
                            'title' => $requestStep->step->tittle,
                            'description' => $requestStep->step->description,
                            'instructions' => $requestStep->step->instructions,
                            'condition_type' => $requestStep->step->condition_type,
                            'requires_documents' => $requestStep->step->requires_documents,
                            'next_yes' => $requestStep->step->next_yes,
                            'next_no' => $requestStep->step->next_no,
                        ],
                        'status' => $requestStep->request_step_status,
                        'step_date' => $requestStep->step_date ? $requestStep->step_date->format('Y-m-d H:i:s') : null,
                    ];
                }),
                'created_at' => $workerRequest->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $workerRequest->updated_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Avanzar al siguiente paso (para flujos secuenciales)
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Request ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function nextStep(Request $request, $id)
    {
        $user = $request->user();

        // Obtener el worker asociado al usuario
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $workerRequest = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id)
            ->find($id);

        if (!$workerRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado',
            ], 404);
        }

        // Obtener el paso actual
        $currentRequestStep = $workerRequest->requestSteps->where('request_step_status', 'in_progress')->first();

        if (!$currentRequestStep) {
            return response()->json([
                'success' => false,
                'message' => 'No hay un paso activo actualmente',
            ], 400);
        }

        $currentStep = $currentRequestStep->step;

        DB::beginTransaction();
        try {
            // Marcar el paso actual como completado
            $currentRequestStep->update([
                'request_step_status' => 'completed',
                'step_date' => Carbon::now(),
            ]);

            // Para flujo secuencial, buscar el siguiente paso por orden
            if ($currentStep->condition_type === 'sequential' || !$currentStep->condition_type) {
                $nextStep = Step::where('process_id', $workerRequest->process_id)
                    ->where('order', '>', $currentStep->order)
                    ->orderBy('order', 'asc')
                    ->first();

                if ($nextStep) {
                    // Activar el siguiente paso
                    $nextRequestStep = RequestStep::where('request_id', $workerRequest->request_id)
                        ->where('step_id', $nextStep->step_id)
                        ->first();

                    if ($nextRequestStep) {
                        $nextRequestStep->update([
                            'request_step_status' => 'in_progress',
                            'step_date' => Carbon::now(),
                            'user_id' => $user->users_id,
                        ]);
                    }

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Paso completado, avanzando al siguiente',
                        'data' => [
                            'current_step' => [
                                'step_id' => $nextStep->step_id,
                                'order' => $nextStep->order,
                                'title' => $nextStep->tittle,
                                'description' => $nextStep->description,
                            ],
                        ],
                    ]);
                } else {
                    // No hay más pasos, completar el trámite
                    $workerRequest->update([
                        'status' => 'completed',
                        'end_date' => Carbon::now(),
                    ]);

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Trámite completado exitosamente',
                        'data' => [
                            'request_id' => $workerRequest->request_id,
                            'status' => 'completed',
                        ],
                    ]);
                }
            } else {
                DB::commit();

                return response()->json([
                    'success' => false,
                    'message' => 'Este paso requiere una decisión condicional. Use el endpoint /conditional-step',
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al avanzar al siguiente paso: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Avanzar en un paso condicional (Sí/No)
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Request ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function conditionalStep(Request $request, $id)
    {
        $request->validate([
            'decision' => 'required|in:yes,no',
        ]);

        $user = $request->user();

        // Obtener el worker asociado al usuario
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $workerRequest = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id)
            ->find($id);

        if (!$workerRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado',
            ], 404);
        }

        // Obtener el paso actual
        $currentRequestStep = $workerRequest->requestSteps->where('request_step_status', 'in_progress')->first();

        if (!$currentRequestStep) {
            return response()->json([
                'success' => false,
                'message' => 'No hay un paso activo actualmente',
            ], 400);
        }

        $currentStep = $currentRequestStep->step;

        // Verificar que sea un paso condicional
        if ($currentStep->condition_type !== 'conditional') {
            return response()->json([
                'success' => false,
                'message' => 'Este paso no es condicional. Use el endpoint /next-step',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Marcar el paso actual como completado
            $currentRequestStep->update([
                'request_step_status' => 'completed',
                'step_date' => Carbon::now(),
            ]);

            // Determinar el siguiente paso según la decisión
            $nextStepId = $request->decision === 'yes' ? $currentStep->next_yes : $currentStep->next_no;

            if ($nextStepId) {
                $nextStep = Step::find($nextStepId);

                if ($nextStep) {
                    // Buscar o crear el RequestStep para el siguiente paso
                    $nextRequestStep = RequestStep::firstOrCreate(
                        [
                            'request_id' => $workerRequest->request_id,
                            'step_id' => $nextStep->step_id,
                        ],
                        [
                            'user_id' => $user->users_id,
                            'request_step_status' => 'in_progress',
                            'step_date' => Carbon::now(),
                        ]
                    );

                    // Si ya existía, actualizarlo
                    if (!$nextRequestStep->wasRecentlyCreated) {
                        $nextRequestStep->update([
                            'request_step_status' => 'in_progress',
                            'step_date' => Carbon::now(),
                            'user_id' => $user->users_id,
                        ]);
                    }

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Decisión registrada, avanzando al siguiente paso',
                        'data' => [
                            'decision' => $request->decision,
                            'current_step' => [
                                'step_id' => $nextStep->step_id,
                                'order' => $nextStep->order,
                                'title' => $nextStep->tittle,
                                'description' => $nextStep->description,
                            ],
                        ],
                    ]);
                }
            }

            // No hay siguiente paso, completar el trámite
            $workerRequest->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Trámite completado exitosamente',
                'data' => [
                    'request_id' => $workerRequest->request_id,
                    'status' => 'completed',
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la decisión: ' . $e->getMessage(),
            ], 500);
        }
    }
}
