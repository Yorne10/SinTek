<?php
/**
 * Company: CETAM
 * Project: ST
 * File: AvailableProcedures.php
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
use Livewire\WithPagination;
use App\Models\Process;
use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogger;

class AvailableProcedures extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';

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

     * Updating category filter.

     *

     * @return void

     */

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    /**

     * Clear filters.

     *

     * @return void

     */

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->resetPage();
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        // Construir la consulta
        $query = Process::with('steps')
            ->where('active', true);

        // Aplicar filtro de búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Aplicar filtro de categoría si existe
        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        // Get trámites paginados
        $processes = $query->orderBy('name', 'asc')
            ->paginate(12);

        return view('modules.worker.available-procedures', [
            'processes' => $processes,
        ])->layout('layouts.app');
    }

    /**

     * Start procedure.

     *

     * @param mixed $processId

     *

     * @return void

     */

    public function startProcedure($processId)
    {
        $user = Auth::user();

        // Get el worker asociado al usuario
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            session()->flash('error', 'No se encontró el perfil de trabajador.');
            return;
        }

        // Verify que el proceso existe y está activo
        $process = Process::with('steps')->find($processId);

        if (!$process || !$process->active) {
            session()->flash('error', 'El trámite no está disponible.');
            return;
        }

        try {
            DB::beginTransaction();

            // Create request
            $request = WorkerRequest::create([
                'worker_id' => $worker->workers_id,
                'process_id' => $process->process_id,
                'status' => 'in_progress',
                'start_date' => now(),
            ]);

            // Create request steps
            foreach ($process->steps as $step) {
                RequestStep::create([
                    'request_id' => $request->request_id,
                    'step_id' => $step->step_id,
                    'request_step_status' => 'pending',
                ]);
            }

            DB::commit();

            // Log activity
            ActivityLogger::log(
                'tramite.iniciar',
                "Trámite iniciado: '{$process->name}' - ID: {$request->request_id}",
                $user->users_id
            );

            // Dispatch success event for SweetAlert
            $this->dispatch(
                'procedure-started',
                title: '¡Trámite iniciado!',
                message: "El trámite '{$process->name}' ha sido iniciado exitosamente.",
                redirectUrl: route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $request->request_id])
            );

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch(
                'procedure-error',
                title: 'Error',
                message: 'Ocurrió un error al iniciar el trámite: ' . $e->getMessage()
            );
        }
    }
}
