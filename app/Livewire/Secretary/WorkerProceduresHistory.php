<?php
/**
 * Company: CETAM
 * Project: ST
 * File: WorkerProceduresHistory.php
 * Created on: 09/12/2025
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
use Livewire\WithPagination;
use App\Models\Worker;
use App\Models\Request;

class WorkerProceduresHistory extends Component
{
    use WithPagination;

    public $workerId;
    public $worker;
    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    /**

     * Initialize component state.

     *

     * @param mixed $id

     *

     * @return void

     */

    public function mount($id)
    {
        $this->workerId = $id;
        $this->worker = Worker::with('user')->findOrFail($id);
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        $query = Request::with(['process'])
            ->where('worker_id', $this->workerId);

        if ($this->search) {
            $query->whereHas('process', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('modules.secretary.worker-procedures-history', [
            'requests' => $requests,
        ])->layout('layouts.app');
    }

    /**

     * Clear filters.

     *

     * @return void

     */

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->resetPage();
    }
}
