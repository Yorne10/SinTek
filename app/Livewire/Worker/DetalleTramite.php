<?php

namespace App\Livewire\Worker;

use Livewire\Component;
use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Worker;
use App\Models\Step;
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

        // Marcar paso actual como completado
        $this->currentStep->update([
            'request_step_status' => 'completed',
            'step_date' => Carbon::now(),
        ]);

        // Buscar siguiente paso secuencial
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

            session()->flash('success', 'Paso completado exitosamente');
        } else {
            // No hay más pasos, completar trámite
            $this->request->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

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

        // Marcar paso actual como completado
        $this->currentStep->update([
            'request_step_status' => 'completed',
            'step_date' => Carbon::now(),
        ]);

        // Determinar siguiente paso según decisión
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

                session()->flash('success', 'Decisión registrada exitosamente');
            }
        } else {
            // Completar trámite
            $this->request->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

            session()->flash('success', 'Trámite completado exitosamente');
        }

        $this->loadRequest();
    }

    public function render()
    {
        return view('livewire.worker.detalle-tramite')->layout('layouts.app');
    }
}
