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
    public $title;  // Corrected from 'tittle'
    public $instruction;  // Corrected from 'instructions' (singular)
    public $step_type = 'initial';  // Updated: initial, conditional, file_upload, final
    public $condition_question;
    public $requires_documents = false;
    public $documents = [];
    public $next_step_id;
    public $next_yes;
    public $next_no;
    public $finalization_message;
    public $is_initial_step = false;
    public $is_linked = false;
    public $active = true;

    // Control de UI
    public $activarRamificacion = false;
    public $isEditing = false;

    // Listas
    public $procesos = [];
    public $availableSteps = [];

    // Query string parameters
    protected $queryString = ['process_id', 'step_id'];

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
        }
    }

    public function loadStep()
    {
        $step = Step::with('requiredDocuments')->find($this->step_id);
        if ($step) {
            $this->process_id = $step->process_id;
            $this->title = $step->title;
            $this->instruction = $step->instruction;
            $this->step_type = $step->step_type ?? 'initial';
            $this->condition_question = $step->condition_question;
            $this->requires_documents = $step->requires_documents ?? false;
            $this->next_step_id = $step->next_step_id;
            $this->next_yes = $step->next_yes;
            $this->next_no = $step->next_no;
            $this->finalization_message = $step->finalization_message;
            $this->is_initial_step = $step->is_initial_step ?? false;
            $this->is_linked = $step->is_linked ?? false;
            $this->active = $step->active ?? true;
            $this->documents = $step->requiredDocuments->map(fn($doc) => ['title' => $doc->title])->toArray();

            $this->activarRamificacion = ($this->step_type === 'conditional' && $this->condition_question);
            $this->loadAvailableSteps();
        }
    }

    public function updatedProcessId()
    {
        if ($this->process_id && !$this->isEditing) {
            $this->loadAvailableSteps();
        }
    }

    public function updatedStepType()
    {
        $this->activarRamificacion = $this->step_type === 'conditional';
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
        if (empty($this->documents)) {
            $this->requires_documents = false;
        }
    }

    public function loadAvailableSteps()
    {
        if ($this->process_id) {
            $query = Step::where('process_id', $this->process_id);

            if ($this->step_id) {
                $query->where('step_id', '!=', $this->step_id);
            }

            $this->availableSteps = $query->get();
        }
    }

    public function save()
    {
        try {
            $rules = [
                'process_id' => 'required|exists:processes,process_id',
                'title' => 'required|string|max:200',
                'instruction' => 'nullable|string',
                'step_type' => 'required|string|in:initial,conditional,final',
                'condition_question' => 'nullable|string',
                'requires_documents' => 'boolean',
                'next_step_id' => 'nullable|exists:steps,step_id',
                'next_yes' => 'nullable|exists:steps,step_id',
                'next_no' => 'nullable|exists:steps,step_id',
                'finalization_message' => 'nullable|string',
                'is_initial_step' => 'boolean',
                'is_linked' => 'boolean',
                'active' => 'boolean',
            ];

            if ($this->requires_documents) {
                $rules['documents'] = 'required|array|min:1';
                $rules['documents.*.title'] = 'required|string|max:150';
            }

            \Log::info('Validando...');
            $this->validate($rules, [
                'process_id.required' => 'Debes seleccionar un proceso',
                'title.required' => 'El nombre del paso es obligatorio',
                'step_type.required' => 'Debes seleccionar un tipo de paso',
                'documents.*.title.required' => 'Indica el título del documento requerido',
            ]);
            \Log::info('Validación exitosa');

            $data = [
                'process_id' => $this->process_id,
                'title' => $this->title,
                'instruction' => $this->instruction,
                'step_type' => $this->step_type,
                'condition_question' => $this->condition_question,
                'requires_documents' => $this->requires_documents,
                'next_step_id' => $this->next_step_id,
                'next_yes' => $this->step_type === 'conditional' ? $this->next_yes : null,
                'next_no' => $this->step_type === 'conditional' ? $this->next_no : null,
                'finalization_message' => $this->finalization_message,
                'is_initial_step' => $this->is_initial_step,
                'is_linked' => $this->is_linked,
                'active' => $this->active,
            ];

            $user = auth()->user();
            \Log::info('Usuario autenticado: ' . ($user ? $user->users_id : 'null'));

            if ($this->isEditing) {
                \Log::info('Modo edición - Step ID: ' . $this->step_id);
                $step = Step::find($this->step_id);
                $step->update($data);
                $actionKey = 'paso.actualizado';
                $actionVerb = 'actualizado';
                session()->flash('success', 'Paso actualizado exitosamente');
                \Log::info('Paso actualizado en BD');
            } else {
                \Log::info('Modo creación - Creando nuevo paso');
                $step = Step::create($data);
                $this->step_id = $step->step_id;
                $actionKey = 'paso.creado';
                $actionVerb = 'creado';
                session()->flash('success', 'Paso creado exitosamente');
                \Log::info('Paso creado en BD con ID: ' . $step->step_id);
            }

            // Sincronizar documentos requeridos
            \Log::info('Sincronizando documentos...');
            StepRequiredDocument::where('step_id', $step->step_id)->delete();
            if ($this->requires_documents) {
                foreach ($this->documents as $doc) {
                    StepRequiredDocument::create([
                        'step_id' => $step->step_id,
                        'title' => $doc['title'],
                    ]);
                }
                \Log::info('Documentos sincronizados: ' . count($this->documents));
            }

            $process = Process::find($this->process_id);
            $processName = $process ? $process->name : 'Proceso';

            \Log::info('Registrando actividad...');
            ActivityLogger::log(
                $actionKey === 'paso.creado' ? 'paso.crear' : 'paso.editar',
                "Paso {$actionVerb}: '{$this->title}' del proceso '{$processName}'",
                $user?->users_id
            );
            \Log::info('Actividad registrada');

            \Log::info('Disparando evento step-saved...');
            $this->dispatch(
                'step-saved',
                title: $this->isEditing ? 'Paso actualizado' : 'Paso creado',
                message: $this->isEditing ? 'El paso ha sido actualizado correctamente.' : 'El paso ha sido creado correctamente.',
                redirect: route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $this->process_id])
            );
            \Log::info('=== SAVE COMPLETADO ===');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación: ' . json_encode($e->errors()));
            // Los errores de validación se manejan automáticamente por Livewire
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error al guardar paso: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            $this->dispatch(
                'step-error',
                title: 'Error',
                message: 'Ocurrió un error al guardar el paso: ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('modules.admin.create-step')->layout('layouts.app');
    }
}
