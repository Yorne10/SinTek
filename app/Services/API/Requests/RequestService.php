<?php
/**
 * Company: CETAM
 * Project: ST
 * File: RequestService.php
 * Created on: 10/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Services\API\Requests;

use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Process;
use App\Models\Step;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                            'status' => $reqStep->request_step_status,
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
                'message' => 'No se encontr? perfil de trabajador para este usuario',
            ], 404);
        }

        $process = Process::with('steps')->find($validated['process_id']);
        if (!$process || !$process->active) {
            return response()->json([
                'success' => false,
                'message' => 'El proceso no est? disponible',
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
                'deadline_at' => null,
            ]);

            foreach ($process->steps as $step) {
                RequestStep::create([
                    'request_id' => $newRequest->request_id,
                    'step_id' => $step->step_id,
                    'request_step_status' => $step->order === 1 ? 'en_progreso' : 'pendiente',
                    'step_date' => $step->order === 1 ? Carbon::now() : null,
                ]);
            }

            DB::commit();

            ActivityLogger::log(
                'tramite.iniciar',
                "Trámite iniciado: '{$process->name}' - Código: {$newRequest->request_code}",
                $user->users_id
            );

            return response()->json([
                'success' => true,
                'message' => 'Tr?mite creado exitosamente',
                'data' => [
                    'request_id' => $newRequest->request_id,
                    'request_code' => $newRequest->request_code,
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el tr?mite',
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
                        'title' => $reqStep->step?->title,
                        'description' => $reqStep->step?->description,
                        'status' => $reqStep->request_step_status,
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

        $currentStep = $req->requestSteps()->where('request_step_status', 'en_progreso')->first();
        if (!$currentStep) {
            return response()->json([
                'success' => false,
                'message' => 'No hay pasos en progreso para este trámite',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $currentStep->request_step_status = 'completado';
            $currentStep->step_date = Carbon::now();
            $currentStep->save();

            $nextStep = $req->requestSteps()
                ->where('request_step_status', 'pendiente')
                ->orderBy('step_id')
                ->first();

            if ($nextStep) {
                $nextStep->request_step_status = 'en_progreso';
                $nextStep->step_date = Carbon::now();
                $nextStep->save();
            } else {
                $req->status = 'completado';
                $req->end_date = Carbon::now();
                $req->save();
            }

            DB::commit();

            $stepName = $currentStep->step?->title ?? 'Paso';

            // Log activity - SAME MESSAGE AS WEB
            ActivityLogger::log(
                'tramite.paso.completado',
                "Paso completado: '{$stepName}' del trámite '{$req->process->name}'",
                $user->users_id
            );

            if (!$nextStep) {
                ActivityLogger::log(
                    'tramite.completado',
                    "Trámite completado: '{$req->process->name}'",
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

        $currentStep = $req->requestSteps()->where('request_step_status', 'en_progreso')->first();
        if (!$currentStep) {
            return response()->json([
                'success' => false,
                'message' => 'No hay pasos en progreso para este trámite',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $currentStep->request_step_status = $validated['condition_type'] === 'aprobado' ? 'completado' : 'rechazado';
            $currentStep->step_date = Carbon::now();
            $currentStep->comments = $validated['comments'] ?? null;
            $currentStep->save();

            if ($validated['condition_type'] === 'aprobado') {
                $nextStep = $req->requestSteps()
                    ->where('request_step_status', 'pendiente')
                    ->orderBy('step_id')
                    ->first();

                if ($nextStep) {
                    $nextStep->request_step_status = 'en_progreso';
                    $nextStep->step_date = Carbon::now();
                    $nextStep->save();
                } else {
                    $req->status = 'completado';
                    $req->end_date = Carbon::now();
                    $req->save();
                }
            } else {
                $req->status = 'rechazado';
                $req->save();
            }

            DB::commit();

            $stepName = $currentStep->step?->title ?? 'Paso';
            $decisionLabel = $validated['condition_type'] === 'aprobado' ? 'sí' : 'no';

            // Log activity - SAME MESSAGE AS WEB
            ActivityLogger::log(
                'tramite.decision',
                "Decisión '{$decisionLabel}' en el paso '{$stepName}' del trámite '{$req->process->name}'",
                $user->users_id
            );

            if ($req->status === 'completado') {
                ActivityLogger::log(
                    'tramite.completado',
                    "Trámite completado: '{$req->process->name}'",
                    $user->users_id
                );
            }

            return response()->json([
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

    public function uploadDocument(Request $request, $id)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'step_id' => 'required|integer|exists:steps,step_id',
        ]);

        $user = $request->user();
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $req = WorkerRequest::where('worker_id', $worker->workers_id)->find($id);

        if (!$req) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado',
            ], 404);
        }

        // Verify step belongs to process
        $step = Step::where('process_id', $req->process_id)->find($validated['step_id']);
        if (!$step) {
            return response()->json([
                'success' => false,
                'message' => 'El paso no pertenece al proceso de este trámite',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $content = file_get_contents($file->getRealPath());

            $document = \App\Models\Document::create([
                'request_id' => $req->request_id,
                'step_id' => $step->step_id,
                'name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'file_content' => $content,
            ]);

            // Log activity - SAME MESSAGE AS WEB
            ActivityLogger::log(
                'tramite.documento.subido',
                "Documento '{$document->name}' subido para el paso '{$step->title}' del trámite '{$req->process->name}'",
                $user->users_id
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Documento subido exitosamente',
                'data' => [
                    'document_id' => $document->document_id,
                    'name' => $document->name,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el documento',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function cancel(Request $request, $id)
    {
        $user = $request->user();
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró perfil de trabajador para este usuario',
            ], 404);
        }

        $req = WorkerRequest::with(['process'])
            ->where('worker_id', $worker->workers_id)
            ->find($id);

        if (!$req) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado',
            ], 404);
        }

        // Validar que el trámite pueda ser cancelado
        if (in_array($req->status, ['completado', 'cancelado', 'rechazado'])) {
            return response()->json([
                'success' => false,
                'message' => 'El trámite no puede ser cancelado porque ya está ' . $req->status,
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Actualizar el estado del trámite
            $req->status = 'cancelado';
            $req->save();

            // Cancelar todos los pasos pendientes o en progreso
            RequestStep::where('request_id', $req->request_id)
                ->whereIn('request_step_status', ['pendiente', 'en_progreso'])
                ->update([
                    'request_step_status' => 'cancelado',
                    'step_date' => Carbon::now(),
                ]);

            DB::commit();

            // Log activity
            ActivityLogger::log(
                'tramite.cancelado',
                "Trámite cancelado: '{$req->process->name}' - Código: {$req->request_code}",
                $user->users_id
            );

            return response()->json([
                'success' => true,
                'message' => 'Trámite cancelado exitosamente',
                'data' => [
                    'request_id' => $req->request_id,
                    'request_code' => $req->request_code,
                    'status' => $req->status,
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar el trámite',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
