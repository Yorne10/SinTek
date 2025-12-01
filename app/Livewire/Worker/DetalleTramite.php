<?php
namespace App\Livewire\Worker;

use Livewire\Component;
use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Worker;
use App\Models\Step;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DetalleTramite extends Component
{
    public $requestId;
    public $request;
    public $currentStep;

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
    }

    public function nextStep()
    {
        if (!$this->currentStep) {
            session()->flash('error', 'No hay un paso activo');
            return;
        }

        $currentStepModel = $this->currentStep->step;
        $user = Auth::user();
        $stepName = $currentStepModel->tittle ?? $currentStepModel->name ?? 'Paso';

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

            ActivityLogger::log(
                'tramite.paso.completar',
                "Completado paso '{$stepName}' del trámite #{$this->request->request_id}",
                $user->users_id
            );

            session()->flash('success', 'Paso completado exitosamente');
        } else {
            $this->request->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

            ActivityLogger::log(
                'tramite.completado',
                "Completado trámite #{$this->request->request_id} del proceso '" . ($this->request->process->name ?? 'Proceso') . "'",
                $user->users_id
            );

            session()->flash('success', 'Trámite completado exitosamente');
        }

        $this->loadRequest();
    }

    public function conditionalStep($decision)
    {
        if (!$this->currentStep) {
            session()->flash('error', 'No hay un paso activo');
            return;
        }

        $currentStepModel = $this->currentStep->step;
        $user = Auth::user();
        $stepName = $currentStepModel->tittle ?? $currentStepModel->name ?? 'Paso';
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

                ActivityLogger::log(
                    'tramite.decision',
                    "Decisión '{$decisionLabel}' registrada en paso '{$stepName}' del trámite #{$this->request->request_id}",
                    $user->users_id
                );

                session()->flash('success', 'Decisión registrada exitosamente');
            }
        } else {
            $this->request->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

            ActivityLogger::log(
                'tramite.completado',
                "Completado trámite #{$this->request->request_id} del proceso '" . ($this->request->process->name ?? 'Proceso') . "'",
                $user->users_id
            );

            session()->flash('success', 'Trámite completado exitosamente');
        }

        $this->loadRequest();
    }

    public function render()
    {
        return view('modules.worker.detalle-tramite')->layout('layouts.app');
    }
}
