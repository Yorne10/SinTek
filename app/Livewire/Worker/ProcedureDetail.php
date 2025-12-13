<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ProcedureDetail.php
 * Created on: 09/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Worker;

use Livewire\Component;
use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Worker;
use App\Models\Step;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProcedureDetail extends Component
{
    use \Livewire\WithFileUploads;

    public $requestId;
    public $request;
    public $currentStep;
    public $allSteps = [];
    public $file;

    public function mount($id)
    {
        $this->requestId = $id;
        $this->loadRequest();
    }

    public function loadRequest()
    {
        $user = Auth::user();
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            abort(404, 'Worker no encontrado');
        }

        $this->request = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id)
            ->findOrFail($this->requestId);

        $this->currentStep = $this->request->requestSteps
            ->where('request_step_status', 'in_progress')
            ->first();

        // Cargar todos los pasos del proceso para el timeline completo
        $this->allSteps = Step::where('process_id', $this->request->process_id)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function nextStep()
    {
        if (!$this->currentStep) {
            session()->flash('error', 'No hay un paso activo');
            return;
        }

        $currentStepModel = $this->currentStep->step;
        $stepName = $currentStepModel->title ?? $currentStepModel->name ?? 'Paso';

        $this->currentStep->update([
            'request_step_status' => 'completed',
            'step_date' => Carbon::now(),
        ]);

        $nextStep = Step::where('process_id', $this->request->process_id)
            ->where('order', '>', $currentStepModel->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextStep) {
            $nextRequestStep = RequestStep::where('request_id', $this->request->request_id)
                ->where('step_id', $nextStep->step_id)
                ->first();

            if ($nextRequestStep) {
                $nextRequestStep->update([
                    'request_step_status' => 'in_progress',
                    'step_date' => Carbon::now(),
                    'user_id' => Auth::id(),
                ]);
            }

            // Log activity - SAME MESSAGE AS API
            ActivityLogger::log(
                'tramite.paso.completado',
                "Paso completado: '{$stepName}' del trámite '{$this->request->process->name}'",
                Auth::id()
            );

            session()->flash('success', 'Paso completado exitosamente');
        } else {
            $this->request->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

            // Log activity - SAME MESSAGE AS API
            ActivityLogger::log(
                'tramite.completado',
                "Trámite completado: '{$this->request->process->name}'",
                Auth::id()
            );

            session()->flash('success', 'Trámite completado exitosamente');
        }

        $this->loadRequest();
    }

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file|max:10240', // 10MB Max
        ]);

        if (!$this->currentStep) {
            session()->flash('error', 'No hay un paso activo');
            return;
        }

        $currentStepModel = $this->currentStep->step;

        if ($currentStepModel->step_type !== 'upload') {
            session()->flash('error', 'Este paso no requiere carga de archivos');
            return;
        }

        $content = file_get_contents($this->file->getRealPath());

        \App\Models\Document::create([
            'request_id' => $this->request->request_id,
            'step_id' => $currentStepModel->step_id,
            'name' => $this->file->getClientOriginalName(),
            'mime_type' => $this->file->getMimeType(),
            'file_content' => $content,
        ]);

        $stepName = $currentStepModel->title ?? $currentStepModel->name ?? 'Paso';

        // Log activity - SAME MESSAGE AS API
        ActivityLogger::log(
            'tramite.documento.subido',
            "Documento '{$this->file->getClientOriginalName()}' subido para el paso '{$stepName}' del trámite '{$this->request->process->name}'",
            Auth::id()
        );

        $this->file = null;
        $this->nextStep();
    }

    public function conditionalStep($decision)
    {
        if (!$this->currentStep) {
            session()->flash('error', 'No hay un paso activo');
            return;
        }

        $currentStepModel = $this->currentStep->step;
        $stepName = $currentStepModel->title ?? $currentStepModel->name ?? 'Paso';
        $decisionLabel = $decision === 'yes' ? 'sí' : 'no';

        $this->currentStep->update([
            'request_step_status' => 'completed',
            'step_date' => Carbon::now(),
        ]);

        $nextStepId = $decision === 'yes' ? $currentStepModel->next_yes : $currentStepModel->next_no;

        if ($nextStepId) {
            $nextStep = Step::find($nextStepId);

            if ($nextStep) {
                $nextRequestStep = RequestStep::firstOrCreate(
                    [
                        'request_id' => $this->request->request_id,
                        'step_id' => $nextStep->step_id,
                    ],
                    [
                        'user_id' => Auth::id(),
                        'request_step_status' => 'in_progress',
                        'step_date' => Carbon::now(),
                    ]
                );

                if (!$nextRequestStep->wasRecentlyCreated) {
                    $nextRequestStep->update([
                        'request_step_status' => 'in_progress',
                        'step_date' => Carbon::now(),
                    ]);
                }

                // Log activity - SAME MESSAGE AS API
                ActivityLogger::log(
                    'tramite.decision',
                    "Decisión '{$decisionLabel}' en el paso '{$stepName}' del trámite '{$this->request->process->name}'",
                    Auth::id()
                );

                session()->flash('success', 'Decisión registrada exitosamente');
            }
        } else {
            $this->request->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

            // Log activity - SAME MESSAGE AS API
            ActivityLogger::log(
                'tramite.completado',
                "Trámite completado: '{$this->request->process->name}'",
                Auth::id()
            );

            session()->flash('success', 'Trámite completado exitosamente');
        }

        $this->loadRequest();
    }

    public function render()
    {
        return view('modules.worker.procedure-detail')->layout('layouts.app');
    }
}
