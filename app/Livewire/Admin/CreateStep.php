<?php
/**
 * Company: CETAM
 * Project: ST
 * File: CreateStep.php
 * Created on: 05/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Admin;

use App\Models\Process;
use App\Models\Step;
use App\Models\StepProvidedDocument;
use App\Models\StepRequiredDocument;
use App\Services\ActivityLogger;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateStep extends Component
{
    use WithFileUploads;

    // Campos del paso
    public $step_id;
    public $process_id;
    public $title;  // Corrected from 'tittle'
    public $instruction;  // Corrected from 'instructions' (singular)
    public $step_type = '';  // Default empty, options: initial, normal, conditional, final
    public $condition_question;
    public $requires_documents = false;
    public $documents = [];
    public $providedDocuments = [];
    public $existingProvidedDocuments = [];
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
    public $hasInitialStep = false;

    // Listas
    public $procesos = [];
    public $availableSteps = [];

    // Query string parameters
    protected $queryString = ['process_id', 'step_id'];

    /**

     * Initialize component state.

     *

     * @param mixed $process_id

     * @param mixed $step_id

     *

     * @return void

     */

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

    /**

     * Load step.

     *

     * @return void

     */

    public function loadStep()
    {
        $step = Step::with(['requiredDocuments', 'providedDocuments'])->find($this->step_id);
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

            // Load existing provided documents
            $this->existingProvidedDocuments = $step->providedDocuments->map(fn($doc) => [
                'id' => $doc->document_id,
                'titulo' => $doc->name,
            ])->toArray();

            $this->activarRamificacion = ($this->step_type === 'conditional' && $this->condition_question);
            $this->loadAvailableSteps();
        }
    }

    /**

     * Updated process id.

     *

     * @return void

     */

    public function updatedProcessId()
    {
        if ($this->process_id && !$this->isEditing) {
            $this->loadAvailableSteps();
        }
    }

    /**

     * Updated step type.

     *

     * @return void

     */

    public function updatedStepType()
    {
        $this->activarRamificacion = $this->step_type === 'conditional';
    }

    /**

     * Add document.

     *

     * @return void

     */

    public function addDocument()
    {
        $this->documents[] = ['title' => ''];
        $this->requires_documents = true;
    }

    /**

     * Remove document.

     *

     * @param mixed $index

     *

     * @return void

     */

    public function removeDocument($index)
    {
        unset($this->documents[$index]);
        $this->documents = array_values($this->documents);
        if (empty($this->documents)) {
            $this->requires_documents = false;
        }
    }

    /**
     * Add provided document.
     *
     * @return void
     */
    public function addProvidedDocument()
    {
        $this->providedDocuments[] = ['titulo' => '', 'archivo' => null];
    }

    /**
     * Remove provided document.
     *
     * @param mixed $index
     *
     * @return void
     */
    public function removeProvidedDocument($index)
    {
        unset($this->providedDocuments[$index]);
        $this->providedDocuments = array_values($this->providedDocuments);
    }

    /**
     * Remove existing provided document.
     *
     * @param mixed $docId
     *
     * @return void
     */
    public function removeExistingProvidedDocument($docId)
    {
        $this->existingProvidedDocuments = array_filter(
            $this->existingProvidedDocuments,
            fn($doc) => $doc['id'] != $docId
        );
        $this->existingProvidedDocuments = array_values($this->existingProvidedDocuments);
    }

    /**
     * Reset form for creating a new step (after successful creation).
     *
     * @return void
     */
    public function resetFormForNewStep()
    {
        $this->step_id = null;
        $this->title = '';
        $this->instruction = '';
        $this->step_type = '';
        $this->condition_question = '';
        $this->requires_documents = false;
        $this->documents = [];
        $this->providedDocuments = [];
        $this->existingProvidedDocuments = [];
        $this->next_step_id = null;
        $this->next_yes = null;
        $this->next_no = null;
        $this->finalization_message = '';
        $this->is_initial_step = false;
        $this->is_linked = false;
        $this->active = true;
        $this->activarRamificacion = false;
        $this->isEditing = false;

        // Reload available steps to include the newly created one
        $this->loadAvailableSteps();
    }

    /**

     * Load available steps.

     *

     * @return void

     */

    public function loadAvailableSteps()
    {
        if ($this->process_id) {
            $query = Step::where('process_id', $this->process_id);

            if ($this->step_id) {
                $query->where('step_id', '!=', $this->step_id);
            }

            $this->availableSteps = $query->get();

            // Check if an initial step already exists for this process
            // Use is_initial_step boolean field OR step_type = 'initial'
            $initialStepQuery = Step::where('process_id', $this->process_id)
                ->where(function ($q) {
                    $q->where('is_initial_step', true)
                        ->orWhere('step_type', 'initial');
                });

            // If editing, exclude current step from the check
            if ($this->step_id) {
                $initialStepQuery->where('step_id', '!=', $this->step_id);
            }

            $this->hasInitialStep = $initialStepQuery->exists();
        }
    }

    /**

     * Save the data.

     *

     * @return void

     */

    public function save()
    {
        try {
            $rules = [
                'process_id' => 'required|exists:processes,process_id',
                'title' => 'required|string|max:200',
                // Instrucciones solo obligatorias si no es paso final
                'instruction' => $this->step_type === 'final' ? 'nullable|string|max:5000' : 'required|string|max:5000',
                'step_type' => 'required|string|in:initial,normal,conditional,final',
                'condition_question' => 'nullable|string',
                'requires_documents' => 'boolean',
                'next_step_id' => 'nullable|exists:steps,step_id',
                'next_yes' => 'nullable|exists:steps,step_id',
                'next_no' => 'nullable|exists:steps,step_id',
                'finalization_message' => 'nullable|string|max:1000',
                'is_initial_step' => 'boolean',
                'is_linked' => 'boolean',
                'active' => 'boolean',
            ];

            if ($this->requires_documents) {
                $rules['documents'] = 'required|array|min:1';
                $rules['documents.*.title'] = 'required|string|max:150';
            }

            // Validaciones adicionales por tipo
            if ($this->step_type === 'conditional') {
                $rules['condition_question'] = 'required|string|max:255';
            }

            if ($this->step_type === 'final') {
                $rules['finalization_message'] = 'required|string|max:1000';
            }

            // Validar documentos proporcionados nuevos (si existen)
            if (!empty($this->providedDocuments)) {
                $rules['providedDocuments'] = 'array';
                $rules['providedDocuments.*.titulo'] = 'required|string|max:150';
                $rules['providedDocuments.*.archivo'] = 'required|file|mimes:pdf|max:10240';
            }

            \Log::info('Validando...');
            $this->validate($rules, [
                'process_id.required' => 'El campo proceso es obligatorio',
                'title.required' => 'El campo título del paso es obligatorio',
                'instruction.required' => 'El campo instrucciones es obligatorio',
                'step_type.required' => 'El campo tipo de paso es obligatorio',
                'condition_question.required' => 'El campo pregunta condicional es obligatorio',
                'finalization_message.required' => 'El campo mensaje de finalización es obligatorio',
                'documents.required' => 'El campo documentos requeridos es obligatorio',
                'documents.*.title.required' => 'El campo nombre del documento requerido es obligatorio',
                'providedDocuments.*.titulo.required' => 'El campo título del documento proporcionado es obligatorio',
                'providedDocuments.*.archivo.required' => 'El campo archivo del documento proporcionado es obligatorio',
            ]);

            // Validaciones adicionales según el tipo
            if ($this->step_type === 'conditional' && !trim((string) $this->condition_question)) {
                $this->addError('condition_question', 'El campo pregunta condicional es obligatorio');
                return;
            }

            if ($this->step_type === 'final' && !trim((string) $this->finalization_message)) {
                $this->addError('finalization_message', 'El campo mensaje de finalización es obligatorio');
                return;
            }

            // Custom validation: only one initial step per process
            if ($this->step_type === 'initial') {
                $existingInitialStep = Step::where('process_id', $this->process_id)
                    ->where('step_type', 'initial');

                if ($this->step_id) {
                    $existingInitialStep->where('step_id', '!=', $this->step_id);
                }

                if ($existingInitialStep->exists()) {
                    $this->addError('step_type', 'Este proceso ya tiene un paso inicial. Solo puede existir un paso inicial por proceso.');
                    return;
                }
            }

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
                'is_initial_step' => $this->step_type === 'initial',  // Auto-set based on step_type
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
            \Log::info('Sincronizando documentos requeridos...');
            StepRequiredDocument::where('step_id', $step->step_id)->delete();
            if ($this->requires_documents) {
                foreach ($this->documents as $doc) {
                    StepRequiredDocument::create([
                        'step_id' => $step->step_id,
                        'title' => $doc['title'],
                    ]);
                }
                \Log::info('Documentos requeridos sincronizados: ' . count($this->documents));
            }

            // Sincronizar documentos proporcionados
            \Log::info('Sincronizando documentos proporcionados...');

            // Get IDs of existing documents that should remain
            $keepIds = array_column($this->existingProvidedDocuments, 'id');

            // Delete documents not in the keep list
            StepProvidedDocument::where('step_id', $step->step_id)
                ->whereNotIn('document_id', $keepIds)
                ->delete();

            // Add new provided documents
            foreach ($this->providedDocuments as $doc) {
                if (!empty($doc['titulo']) && isset($doc['archivo'])) {
                    $file = $doc['archivo'];
                    StepProvidedDocument::create([
                        'step_id' => $step->step_id,
                        'name' => $doc['titulo'],
                        'file_content' => file_get_contents($file->getRealPath()),
                        'mime_type' => $file->getMimeType() ?? 'application/pdf',
                    ]);
                }
            }
            \Log::info('Documentos proporcionados sincronizados');

            // Reset provided documents array
            $this->providedDocuments = [];

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
            if ($this->isEditing) {
                $this->dispatch(
                    'step-saved',
                    title: 'Paso actualizado',
                    message: 'El paso ha sido actualizado correctamente.',
                    redirect: route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $this->process_id])
                );
            } else {
                // Clear form and stay on page for creating more steps
                $this->resetFormForNewStep();
                $this->dispatch(
                    'step-saved',
                    title: 'Paso creado',
                    message: 'El paso ha sido creado correctamente. Puedes crear otro paso.',
                    redirect: null
                );
            }
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

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.admin.create-step')->layout('layouts.app');
    }

    /**
     * Delete the current step (only from edit mode).
     */
    public function deleteStep(): void
    {
        if (!$this->isEditing || !$this->step_id) {
            return;
        }

        $step = Step::with('process')->find($this->step_id);
        if (!$step) {
            $this->dispatch(
                'step-error',
                title: 'No encontrado',
                message: 'No se encontró el paso a eliminar.'
            );
            return;
        }

        // If it's linked (and not the initial), block deletion until it is disconnected
        if ($step->is_linked && !$step->is_initial_step) {
            $this->dispatch(
                'step-error',
                title: 'No se puede eliminar',
                message: 'El paso está conectado al flujo. Primero debes desvincularlo desde "Configurar flujo".'
            );
            return;
        }

        $process = $step->process;
        $wasInitial = $step->is_initial_step;
        $title = $step->title;

        $step->delete();

        if ($process && $wasInitial) {
            $process->active = false;
            $process->save();
        }

        $user = auth()->user();
        ActivityLogger::log(
            'paso.eliminar',
            "Paso eliminado: '{$title}' del proceso '" . ($process->name ?? 'Proceso') . "'",
            $user?->users_id
        );

        $this->dispatch(
            'step-saved',
            title: 'Paso eliminado',
            message: $wasInitial
            ? 'El paso inicial fue eliminado. El proceso se desactivó hasta que configures un nuevo flujo.'
            : 'El paso fue eliminado correctamente.',
            redirect: route(config('proj.route_name_prefix', 'proj') . '.admin.define-steps', ['process_id' => $this->process_id])
        );
    }
}



