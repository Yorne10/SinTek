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

        // Load step with required and provided documents relations
        $this->step = Step::with(['requiredDocuments', 'providedDocuments'])->findOrFail($stepId);

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

        // Handle conditional branching based on response
        $this->advanceToNextStep($response);
    }

    /**
     * Advance to next step or complete request.
     *
     * @param string|null $conditionalResponse For conditional steps: 'yes' or 'no'
     * @return void
     */
    protected function advanceToNextStep($conditionalResponse = null)
    {
        // Determine next step based on current step type
        $nextStepId = null;

        if ($this->step->step_type === 'conditional' && $conditionalResponse) {
            // For conditional steps, use next_yes or next_no
            $nextStepId = ($conditionalResponse === 'yes')
                ? $this->step->next_yes
                : $this->step->next_no;
        } else {
            // For normal/initial/final steps, use next_step_id
            $nextStepId = $this->step->next_step_id;
        }

        if ($nextStepId) {
            // Find the request step for the next step
            $nextRequestStep = $this->request->requestSteps
                ->where('step_id', $nextStepId)
                ->first();

            if ($nextRequestStep) {
                // Activate next step
                $nextRequestStep->update([
                    'request_step_status' => 'in_progress',
                ]);

                $this->dispatch(
                    'step-completed',
                    title: '¡Paso completado!',
                    message: 'Se ha avanzado al siguiente paso.',
                    redirectUrl: route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $this->requestId])
                );
                return;
            }
        }

        // No next step found - complete the request
        $this->request->update([
            'status' => 'completed',
            'end_date' => now(),
        ]);

        $this->dispatch(
            'step-completed',
            title: '¡Trámite completado!',
            message: 'Has completado todos los pasos de este trámite.',
            redirectUrl: route(config('proj.route_name_prefix', 'proj') . '.worker.my-procedures')
        );
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
