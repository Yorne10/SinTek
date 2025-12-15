<?php
/**
 * Company: CETAM
 * Project: ST
 * File: SecretaryProcedureDetail.php
 * Created on: 14/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use Livewire\Component;
use App\Models\Request as WorkerRequest;
use App\Models\Step;
use Illuminate\Support\Facades\Auth;

class SecretaryProcedureDetail extends Component
{
    public $requestId;
    public $request;
    public $currentStep;
    public $allSteps = [];
    public $worker;

    /**
     * Initialize component state.
     *
     * @param mixed $id
     * @return void
     */
    public function mount($id)
    {
        $this->requestId = $id;
        $this->loadRequest();
    }

    /**
     * Load request.
     *
     * @return void
     */
    public function loadRequest()
    {
        $this->request = WorkerRequest::with(['process', 'requestSteps.step', 'worker.user'])
            ->findOrFail($this->requestId);

        $this->worker = $this->request->worker;

        $this->currentStep = $this->request->requestSteps
            ->where('request_step_status', 'in_progress')
            ->first();

        // Load all steps for the process timeline
        $this->allSteps = Step::where('process_id', $this->request->process_id)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('modules.secretary.procedure-detail-readonly')->layout('layouts.app');
    }
}
