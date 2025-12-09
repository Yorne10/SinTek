<?php

namespace App\Livewire\Worker;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Process;
use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvailableProcedures extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->resetPage();
    }

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

        // Obtener trámites paginados
        $processes = $query->orderBy('name', 'asc')
            ->paginate(12);

        return view('modules.worker.available-procedures', [
            'processes' => $processes,
        ])->layout('layouts.app');
    }

    public function startProcedure($processId)
    {
        $user = Auth::user();

        // Obtener el worker asociado al usuario
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            session()->flash('error', 'No se encontró el perfil de trabajador.');
            return;
        }

        // Verificar que el proceso existe y está activo
        $process = Process::with('steps')->find($processId);

        if (!$process || !$process->active) {
            session()->flash('error', 'El trámite no está disponible.');
            return;
        }

        try {
            DB::beginTransaction();

            // Crear la solicitud
            $request = WorkerRequest::create([
                'worker_id' => $worker->workers_id,
                'process_id' => $process->process_id,
                'status' => 'in_progress',
                'start_date' => now(),
            ]);

            // Crear los pasos de la solicitud
            foreach ($process->steps as $step) {
                RequestStep::create([
                    'request_id' => $request->request_id,
                    'step_id' => $step->step_id,
                    'request_step_status' => 'pending',
                ]);
            }

            DB::commit();

            session()->flash('success', 'Trámite iniciado exitosamente.');
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $request->request_id]);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Ocurrió un error al iniciar el trámite: ' . $e->getMessage());
        }
    }
}
