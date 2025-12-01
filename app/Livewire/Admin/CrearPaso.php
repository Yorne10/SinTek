<?php
/**
 * Company: CETAM
 * Project: ST
 * File: CrearPaso.php
 * Created on: 05/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace App\Livewire\Admin;

use App\Models\Process;
use App\Models\Step;
use Livewire\Component;

class CrearPaso extends Component
{
    // Campos del paso
    public $step_id;
    public $process_id;
    public $tittle;
    public $order;
    public $description;
    public $instructions;
    public $condition_type = 'form';
    public $responsible;
    public $deadline_days;
    public $priority = 'media';
    public $send_notification = false;
    public $requires_documents = false;
    public $next_yes;
    public $next_no;

    // Control de UI
    public $activarRamificacion = false;
    public $isEditing = false;

    // Listas
    public $procesos = [];
    public $availableSteps = [];

    public function mount($process_id = null, $step_id = null)
    {
        // Cargar procesos disponibles
        $this->procesos = Process::where('active', 1)->orderBy('name')->get();

        if ($step_id) {
            // Modo edición
            $this->isEditing = true;
            $this->step_id = $step_id;
            $this->loadStep();
        } elseif ($process_id) {
            // Modo creación con proceso preseleccionado
            $this->process_id = $process_id;
            $this->loadAvailableSteps();
            $this->calculateNextOrder();
        }
    }

    public function loadStep()
    {
        $step = Step::find($this->step_id);
        if ($step) {
            $this->process_id = $step->process_id;
            $this->tittle = $step->tittle;
            $this->order = $step->order;
            $this->description = $step->description;
            $this->instructions = $step->instructions;
            $this->condition_type = $step->condition_type ?? 'form';
            $this->responsible = $step->responsible;
            $this->deadline_days = $step->deadline_days;
            $this->priority = $step->priority ?? 'media';
            $this->send_notification = $step->send_notification ?? false;
            $this->requires_documents = $step->requires_documents ?? false;
            $this->next_yes = $step->next_yes;
            $this->next_no = $step->next_no;

            // Activar ramificación si tiene flujo condicional
            $this->activarRamificacion = ($this->condition_type === 'approval');

            $this->loadAvailableSteps();
        }
    }

    public function updatedProcessId()
    {
        if ($this->process_id && !$this->isEditing) {
            $this->loadAvailableSteps();
            $this->calculateNextOrder();
        }
    }

    public function updatedConditionType()
    {
        // Si cambia a approval, activar ramificación
        if ($this->condition_type === 'approval') {
            $this->activarRamificacion = true;
        }
    }

    public function loadAvailableSteps()
    {
        if ($this->process_id) {
            $query = Step::where('process_id', $this->process_id)
                ->orderBy('order', 'asc');

            // Excluir el paso actual si estamos editando
            if ($this->step_id) {
                $query->where('step_id', '!=', $this->step_id);
            }

            $this->availableSteps = $query->get();
        }
    }

    public function calculateNextOrder()
    {
        if ($this->process_id && !$this->order) {
            $maxOrder = Step::where('process_id', $this->process_id)->max('order') ?? 0;
            $this->order = $maxOrder + 1;
        }
    }

    public function save()
    {
        $this->validate([
            'process_id' => 'required|exists:processes,process_id',
            'tittle' => 'required|string|max:200',
            'order' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'condition_type' => 'required|string|max:50',
            'responsible' => 'nullable|string|max:100',
            'deadline_days' => 'nullable|integer|min:1',
            'priority' => 'required|string|in:baja,media,alta,urgente',
            'send_notification' => 'boolean',
            'requires_documents' => 'boolean',
            'next_yes' => 'nullable|exists:steps,step_id',
            'next_no' => 'nullable|exists:steps,step_id',
        ], [
            'process_id.required' => 'Debes seleccionar un proceso',
            'tittle.required' => 'El nombre del paso es obligatorio',
            'order.required' => 'El orden es obligatorio',
            'condition_type.required' => 'Debes seleccionar un tipo de paso',
            'priority.required' => 'Debes seleccionar una prioridad',
        ]);

        $data = [
            'process_id' => $this->process_id,
            'tittle' => $this->tittle,
            'order' => $this->order,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'condition_type' => $this->condition_type,
            'responsible' => $this->responsible,
            'deadline_days' => $this->deadline_days,
            'priority' => $this->priority,
            'send_notification' => $this->send_notification,
            'requires_documents' => $this->requires_documents,
            'next_yes' => $this->condition_type === 'approval' ? $this->next_yes : null,
            'next_no' => $this->condition_type === 'approval' ? $this->next_no : null,
        ];

        if ($this->isEditing) {
            $step = Step::find($this->step_id);
            $step->update($data);
            session()->flash('success', 'Paso actualizado exitosamente');
        } else {
            Step::create($data);
            session()->flash('success', 'Paso creado exitosamente');
        }

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.admin.definir-pasos');
    }

    public function render()
    {
        return view('modules.admin.crear-paso')
            ->layout('layouts.app');
    }
}

