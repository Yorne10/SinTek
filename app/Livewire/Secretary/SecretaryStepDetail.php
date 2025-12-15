<?php
/**
 * Company: CETAM
 * Project: ST
 * File: SecretaryStepDetail.php
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
use App\Models\RequestStep;
use App\Models\Step;

class SecretaryStepDetail extends Component
{
    public $requestId;
    public $stepId;
    public $request;
    public $step;
    public $requestStep;
    public $worker;

    /**
     * Initialize component state.
     *
     * @param mixed $requestId
     * @param mixed $stepId
     * @return void
     */
    public function mount($requestId, $stepId)
    {
        $this->requestId = $requestId;
        $this->stepId = $stepId;
        $this->loadData();
    }

    /**
     * Load request and step data.
     *
     * @return void
     */
    public function loadData()
    {
        $this->request = WorkerRequest::with(['process', 'worker.user'])
            ->findOrFail($this->requestId);

        $this->worker = $this->request->worker;

        $this->step = Step::with(['requiredDocuments', 'providedDocuments'])
            ->findOrFail($this->stepId);

        $this->requestStep = RequestStep::where('request_id', $this->requestId)
            ->where('step_id', $this->stepId)
            ->first();
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('modules.secretary.step-detail-readonly')->layout('layouts.app');
    }
}
