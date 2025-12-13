<?php
/**
 * Company: CETAM
 * Project: ST
 * File: MyProcedures.php
 * Created on: 23/11/2025
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
use Livewire\WithPagination;
use App\Models\Request as WorkerRequest;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;

class MyProcedures extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    /**

     * Updating search.

     *

     * @return void

     */

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**

     * Updating status filter.

     *

     * @return void

     */

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        $user = Auth::user();

        // Get el worker asociado al usuario
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            return view('modules.worker.my-procedures', [
                'requests' => collect([]),
                'stats' => [
                    'total' => 0,
                    'in_progress' => 0,
                    'completed' => 0,
                ],
            ])->layout('layouts.app');
        }

        // Construir la consulta
        $query = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id);

        // Aplicar filtro de búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('process', function ($processQuery) {
                    $processQuery->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('request_id', 'like', '%' . $this->search . '%');
            });
        }

        // Aplicar filtro de estado
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Get trámites paginados
        $requests = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calcular estadísticas
        $allRequests = WorkerRequest::where('worker_id', $worker->workers_id)->get();
        $stats = [
            'total' => $allRequests->count(),
            'in_progress' => $allRequests->where('status', 'in_progress')->count(),
            'completed' => $allRequests->where('status', 'completed')->count(),
            'cancelled' => $allRequests->where('status', 'cancelled')->count(),
        ];

        return view('modules.worker.my-procedures', [
            'requests' => $requests,
            'stats' => $stats,
        ])->layout('layouts.app');
    }

    /**

     * Get progress percentage.

     *

     * @param mixed $request

     *

     * @return void

     */

    public function getProgressPercentage($request)
    {
        $totalSteps = $request->requestSteps->count();
        if ($totalSteps === 0) {
            return 0;
        }

        $completedSteps = $request->requestSteps->where('request_step_status', 'completed')->count();
        return round(($completedSteps / $totalSteps) * 100);
    }

    /**

     * Get completed steps.

     *

     * @param mixed $request

     *

     * @return void

     */

    public function getCompletedSteps($request)
    {
        return $request->requestSteps->where('request_step_status', 'completed')->count();
    }

    /**

     * Get total steps.

     *

     * @param mixed $request

     *

     * @return void

     */

    public function getTotalSteps($request)
    {
        return $request->requestSteps->count();
    }
}

