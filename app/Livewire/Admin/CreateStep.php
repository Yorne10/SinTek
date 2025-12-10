<?php
/**
 * Company: CETAM
 * Project: ST
 * File: CreateStep.php
 * Created on: 05/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace App\Livewire\Admin;

use App\Models\Process;
use App\Models\Step;
use App\Models\StepRequiredDocument;
use App\Services\ActivityLogger;
use Livewire\Component;

class CreateStep extends Component
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
    public $documents = [];
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
        $this->procesos = Process::where('active', 1)->orderBy('name')->get();

        if ($step_id) {
            $this->isEditing = true;
            $this->step_id = $step_id;
            $this->loadStep();
        } elseif ($process_id) {
            $this->process_id = $process_id;
            $this->loadAvailableSteps();
            $this->calculateNextOrder();
        }
    }

    public function loadStep()
    {
        $step = Step::with('requiredDocuments')->find($this->step_id);
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
            $this->documents = $step->requiredDocuments->map(fn($doc) => ['title' => $doc->title])->toArray();

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
        $this->activarRamificacion = $this->condition_type === 'approval';

        if ($this->condition_type === 'upload') {
            $this->requires_documents = true;
            if (empty($this->documents)) {
                $this->documents = [['title' => '']];
            }
        }
    }

    public function addDocument()
    {
        $this->documents[] = ['title' => ''];
        $this->requires_documents = true;
    }

    public function removeDocument($index)
    {
        unset($this->documents[$index]);
        $this->documents = array_values($this->documents);
        if (empty($this->documents) && $this->condition_type !== 'upload') {
            $this->requires_documents = false;
        }
    }

    public function loadAvailableSteps()
    {
        if ($this->process_id) {
            $query = Step::where('process_id', $this->process_id)
                ->orderBy('order', 'asc');

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
        $rules = [
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
        ];

        if ($this->requires_documents || $this->condition_type === 'upload') {
            $rules['documents'] = 'required|array|min:1';
            $rules['documents.*.title'] = 'required|string|max:150';
        }

        $this->validate($rules, [
            'process_id.required' => 'Debes seleccionar un proceso',
            'tittle.required' => 'El nombre del paso es obligatorio',
            'order.required' => 'El orden es obligatorio',
            'condition_type.required' => 'Debes seleccionar un tipo de paso',
            'priority.required' => 'Debes seleccionar una prioridad',
            'documents.*.title.required' => 'Indica el título del documento requerido',
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
            'requires_documents' => ($this->condition_type === 'upload') ? true : $this->requires_documents,
            'next_yes' => $this->condition_type === 'approval' ? $this->next_yes : null,
            'next_no' => $this->condition_type === 'approval' ? $this->next_no : null,
        ];

        $user = auth()->user();
        if ($this->isEditing) {
            $step = Step::find($this->step_id);
            $step->update($data);
            $actionKey = 'paso.actualizado';
            $actionVerb = 'actualizado';
            session()->flash('success', 'Paso actualizado exitosamente');
        } else {
            $step = Step::create($data);
            $this->step_id = $step->step_id;
            $actionKey = 'paso.creado';
            $actionVerb = 'creado';
            session()->flash('success', 'Paso creado exitosamente');
        }

        // Sincronizar documentos requeridos
        StepRequiredDocument::where('step_id', $step->step_id)->delete();
        if ($this->requires_documents || $this->condition_type === 'upload') {
            foreach ($this->documents as $doc) {
                StepRequiredDocument::create([
                    'step_id' => $step->step_id,
                    'title' => $doc['title'],
                ]);
            }
        }

        $process = Process::find($this->process_id);
        $processName = $process ? $process->name : 'Proceso';

        ActivityLogger::log(
            $actionKey === 'paso.creado' ? 'paso.crear' : 'paso.editar',
            "Paso {$actionVerb}: '{$this->tittle}' del proceso '{$processName}'",
            $user?->users_id
        );

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps');
    }

    public function render()
    {
        return view('modules.admin.create-step')->layout('layouts.app');
    }
}
