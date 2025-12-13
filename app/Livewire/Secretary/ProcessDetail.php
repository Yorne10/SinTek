<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ProcessDetail.php
 * Created on: 10/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use App\Models\Process;
use Livewire\Component;

class ProcessDetail extends Component
{
    public $processId;
    public $process;

    /**

     * Initialize component state.

     *

     * @param mixed $processId

     *

     * @return void

     */

    public function mount($processId)
    {
        $this->processId = $processId;
        $this->process = Process::with(['steps' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($processId);
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.secretary.process-detail')->layout('layouts.app');
    }
}
