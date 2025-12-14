<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StepDetail.php
 * Created on: 13/12/2025
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
use Livewire\WithFileUploads;
use App\Models\Request as WorkerRequest;
use App\Models\Step;
use App\Models\RequestStep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityLogger;

class StepDetail extends Component
{
    use WithFileUploads;

    public $requestId;
    public $stepId;
    public $request;
    public $step;
    public $requestStep;
    public $file;
    public $completedSteps = [];

    /**
     * Mount the component.
     *
     * @param int $requestId
     * @param int $stepId
     * @return void
     */
    public function mount($requestId, $stepId)
    {
        $this->requestId = $requestId;
        $this->stepId = $stepId;

        $user = Auth::user();
        $worker = $user->worker;

        // Load request with relationships
        $this->request = WorkerRequest::with(['process', 'requestSteps'])
            ->where('worker_id', $worker->workers_id)
            ->where('request_id', $requestId)
            ->firstOrFail();

        // Load step
        $this->step = Step::findOrFail($stepId);

        // Load request step
        $this->requestStep = RequestStep::where('request_id', $requestId)
            ->where('step_id', $stepId)
            ->firstOrFail();

        // Load completed steps for sidebar
        $this->loadCompletedSteps();
    }

    /**
     * Load completed steps for display.
     *
     * @return void
     */
    protected function loadCompletedSteps()
    {
        $completedRequestSteps = $this->request->requestSteps
            ->where('request_step_status', 'completed');

        $stepIds = $completedRequestSteps->pluck('step_id')->toArray();
        $this->completedSteps = Step::whereIn('step_id', $stepIds)
            ->orderBy('order')
            ->get()
            ->map(function ($step) use ($completedRequestSteps) {
                $reqStep = $completedRequestSteps->where('step_id', $step->step_id)->first();
                return [
                    'step_id' => $step->step_id,
                    'title' => $step->title,
                    'completed_at' => $reqStep ? $reqStep->step_date : null,
                ];
            })
            ->toArray();
    }

    /**
     * Upload file and complete step.
     *
     * @return void
     */
    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        // Store file
        $path = $this->file->store('request-documents/' . $this->requestId, 'public');

        // Update request step
        $this->requestStep->update([
            'request_step_status' => 'completed',
            'step_date' => now(),
            'document_path' => $path,
        ]);

        // Move to next step or complete request
        $this->advanceToNextStep();
    }

    /**
     * Complete current step and advance.
     *
     * @return void
     */
    public function completeStep()
    {
        $this->requestStep->update([
            'request_step_status' => 'completed',
            'step_date' => now(),
        ]);

        $this->advanceToNextStep();
    }

    /**
     * Handle conditional step response.
     *
     * @param string $response
     * @return void
     */
    public function conditionalStep($response)
    {
        $this->requestStep->update([
            'request_step_status' => 'completed',
            'step_date' => now(),
            'step_response' => $response,
        ]);

        // TODO: Handle conditional branching based on response
        $this->advanceToNextStep();
    }

    /**
     * Advance to next step or complete request.
     *
     * @return void
     */
    protected function advanceToNextStep()
    {
        // Find next pending step
        $nextRequestStep = $this->request->requestSteps
            ->where('request_step_status', 'pending')
            ->first();

        if ($nextRequestStep) {
            // Activate next step
            $nextRequestStep->update([
                'request_step_status' => 'in_progress',
            ]);

            // Log activity
            $user = Auth::user();
            ActivityLogger::log(
                'tramite.paso_completado',
                "Paso '{$this->step->title}' completado - Avanzando al siguiente paso",
                $user->users_id
            );

            $this->dispatch(
                'step-completed',
                title: '¡Paso completado!',
                message: 'Se ha avanzado al siguiente paso.',
                redirectUrl: route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $this->requestId])
            );
        } else {
            // All steps completed - complete request
            $this->request->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $user = Auth::user();
            ActivityLogger::log(
                'tramite.completado',
                "Trámite '{$this->request->process->name}' completado exitosamente",
                $user->users_id
            );

            $this->dispatch(
                'step-completed',
                title: '¡Trámite completado!',
                message: 'Has completado todos los pasos de este trámite.',
                redirectUrl: route(config('proj.route_name_prefix', 'proj') . '.worker.my-procedures')
            );
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('modules.worker.step-detail')
            ->layout('layouts.app');
    }
}
