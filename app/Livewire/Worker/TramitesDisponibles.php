<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: TramitesDisponibles.php
 * Fecha de creación: 03/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace App\Livewire\Worker;

use App\Models\Process;
use App\Models\Worker;
use App\Models\RequestStep;
use App\Models\Step;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;

class TramitesDisponibles extends Component
{
    public $search = '';
    public $categoryFilter = '';

    public function render()
    {
        $query = Process::with('steps')
            ->where('active', 1);

        // Aplicar búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Aplicar filtro de categoría
        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        $procesos = $query->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.worker.tramites-disponibles', [
            'procesos' => $procesos
        ])->layout('layouts.app');
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
    }

    public function iniciarTramite($processId)
    {
        $user = Auth::user();
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            session()->flash('error', 'No se encontró perfil de trabajador');
            return;
        }

        $process = Process::with('steps')->find($processId);

        if (!$process || !$process->active) {
            session()->flash('error', 'El proceso no está disponible');
            return;
        }

        if ($process->steps->count() === 0) {
            session()->flash('error', 'El proceso no tiene pasos configurados');
            return;
        }

        DB::beginTransaction();
        try {
            // Crear la solicitud
            $request = \App\Models\Request::create([
                'worker_id' => $worker->workers_id,
                'process_id' => $process->process_id,
                'status' => 'in_progress',
                'start_date' => Carbon::now(),
            ]);

            // Crear primer paso
            $firstStep = $process->steps->where('order', 1)->first();

            if ($firstStep) {
                RequestStep::create([
                    'request_id' => $request->request_id,
                    'step_id' => $firstStep->step_id,
                    'user_id' => $user->users_id,
                    'request_step_status' => 'in_progress',
                    'step_date' => Carbon::now(),
                ]);

                // Crear pasos restantes como pending
                foreach ($process->steps->where('order', '>', 1) as $step) {
                    RequestStep::create([
                        'request_id' => $request->request_id,
                        'step_id' => $step->step_id,
                        'user_id' => null,
                        'request_step_status' => 'pending',
                        'step_date' => null,
                    ]);
                }
            }

            DB::commit();

            session()->flash('success', 'Trámite iniciado exitosamente');
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.worker.detalle-tramite', ['id' => $request->request_id]);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al iniciar el trámite: ' . $e->getMessage());
        }
    }
}
