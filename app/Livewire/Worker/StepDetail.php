<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StepDetail.php
 * Created on: 13/12/2025
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
use Livewire\WithFileUploads;
use App\Models\Request as WorkerRequest;
use App\Models\Step;
use App\Models\RequestStep;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StepDetail extends Component
{
    use WithFileUploads;

    public $requestId;
    public $stepId;
    public $request;
    public $step;
    public $requestStep;
    public $file;
    public $files = [];
    public $completedSteps = [];

    /**
     * Mount the component.
     *
     * @param int $requestId
     * @param int $stepId
     * @return void
     */
    public function mount($requestId, $stepId)
    {
        $this->requestId = $requestId;
        $this->stepId = $stepId;

        $user = Auth::user();
        $worker = $user->worker;

        // Load request with relationships
        $this->request = WorkerRequest::with(['process', 'requestSteps'])
            ->where('worker_id', $worker->workers_id)
            ->where('request_id', $requestId)
            ->firstOrFail();

        // Load step with required and provided documents relations
        $this->step = Step::with(['requiredDocuments', 'providedDocuments'])->findOrFail($stepId);

        // Load request step
        $this->requestStep = RequestStep::where('request_id', $requestId)
            ->where('step_id', $stepId)
            ->firstOrFail();

        // Load completed steps for sidebar
        $this->loadCompletedSteps();
    }

    /**
     * Load completed steps for display.
     *
     * @return void
     */
    protected function loadCompletedSteps()
    {
        $completedRequestSteps = $this->request->requestSteps
            ->where('request_step_status', 'completed');

        $stepIds = $completedRequestSteps->pluck('step_id')->toArray();
        $this->completedSteps = Step::whereIn('step_id', $stepIds)
            ->orderBy('order')
            ->get()
            ->map(function ($step) use ($completedRequestSteps) {
                $reqStep = $completedRequestSteps->where('step_id', $step->step_id)->first();
                return [
                    'step_id' => $step->step_id,
                    'title' => $step->title,
                    'completed_at' => $reqStep ? $reqStep->step_date : null,
                ];
            })
            ->toArray();
    }

    /**
     * Upload files and complete step.
     *
     * @return void
     */
    public function uploadFile()
    {
        // Validate files if there are required documents
        if ($this->step->requiredDocuments && $this->step->requiredDocuments->count() > 0) {
            $requiredCount = $this->step->requiredDocuments->count();

            // Check if files array has all required documents
            if (empty($this->files) || count(array_filter($this->files)) < $requiredCount) {
                // Build validation rules for each required document
                $rules = [];
                foreach ($this->step->requiredDocuments as $index => $reqDoc) {
                    $rules['files.' . $index] = 'required|file|mimes:pdf|max:10240';
                }
                $this->validate($rules, [
                    'files.*.required' => 'Este documento es requerido.',
                    'files.*.file' => 'Debe ser un archivo válido.',
                    'files.*.mimes' => 'Solo se permiten archivos PDF.',
                    'files.*.max' => 'El archivo no debe superar 10MB.',
                ]);
                return;
            }

            // Validate each file is a valid uploaded file
            foreach ($this->step->requiredDocuments as $index => $reqDoc) {
                if (!isset($this->files[$index]) || !$this->files[$index]) {
                    $this->addError('files.' . $index, 'Este documento es requerido.');
                    return;
                }

                // Check if file is still uploading (is a TemporaryUploadedFile)
                if (!($this->files[$index] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)) {
                    $this->addError('files.' . $index, 'El archivo aún se está cargando. Por favor espere.');
                    return;
                }
            }

            // Store all files in documents table
            $documentIds = [];
            $attachments = [];
            foreach ($this->files as $index => $file) {
                if ($file && $file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    // Resolve requested name from required document title, fallback to original name
                    $reqDoc = $this->step->requiredDocuments[$index] ?? null;
                    $baseName = $reqDoc ? $reqDoc->title : pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension() ?: 'pdf';
                    $extension = ltrim($extension, '.'); // normalize

                    $finalName = $baseName;
                    if (!Str::endsWith(Str::lower($finalName), '.' . strtolower($extension))) {
                        $finalName .= '.' . $extension;
                    }

                    // Get file content as binary
                    $fileContent = file_get_contents($file->getRealPath());

                    // Create document record in database
                    $document = \App\Models\Document::create([
                        'request_id' => $this->requestId,
                        'step_id' => $this->stepId,
                        'file_content' => $fileContent,
                        'name' => $finalName,
                        'mime_type' => $file->getMimeType(),
                    ]);

                    $documentIds[] = $document->document_id;
                    $attachments[] = [
                        'content' => $fileContent,
                        'name' => $finalName,
                        'mime' => $file->getMimeType() ?: 'application/pdf',
                        'title' => $reqDoc ? $reqDoc->title : $finalName,
                    ];
                }
            }

            // Verify we stored all required files
            if (count($documentIds) < $requiredCount) {
                session()->flash('error', 'No se pudieron guardar todos los archivos. Por favor intente de nuevo.');
                return;
            }

            // Update request step with document IDs reference
            $this->requestStep->update([
                'request_step_status' => 'completed',
                'step_date' => now(),
                'document_path' => json_encode($documentIds),
            ]);

            // Send email notification with attachments to admin and CC worker
            if (!empty($attachments)) {
                $user = Auth::user();
                $adminEmail = SystemSetting::getValue('contact_email', config('mail.from.address'));

                $recipients = [];
                if ($adminEmail) {
                    $recipients[] = $adminEmail;
                }

                $cc = [];
                if ($user && $user->email) {
                    $cc[] = $user->email;
                }

                if (!empty($recipients)) {
                    $bodyLines = [
                        'Se recibieron documentos en el sistema.',
                        '',
                        'Trámite: ' . ($this->request->process->name ?? 'Trámite'),
                        'Paso: ' . ($this->step->title ?? 'Paso'),
                        'Usuario: ' . (($user->name ?? 'Usuario') . (isset($user->email) ? ' <' . $user->email . '>' : '')),
                        'Fecha: ' . now()->format('d/m/Y H:i'),
                        '',
                        'Documentos:',
                    ];
                    foreach ($attachments as $attach) {
                        $bodyLines[] = '- ' . ($attach['title'] ?? $attach['name']) . ' (PDF)';
                    }

                    $subject = 'Documentos cargados en el sistema';
                    $body = implode("\n", $bodyLines);

                    Mail::send([], [], function ($message) use ($recipients, $cc, $attachments, $subject, $body) {
                        $message->to($recipients)
                            ->subject($subject)
                            ->text($body);

                        if (!empty($cc)) {
                            $message->cc($cc);
                        }

                        foreach ($attachments as $attach) {
                            $message->attachData($attach['content'], $attach['name'], ['mime' => $attach['mime']]);
                        }
                    });
                }
            }
        } else {
            // No required documents - just complete the step
            $this->requestStep->update([
                'request_step_status' => 'completed',
                'step_date' => now(),
            ]);
        }

        // Move to next step or complete request
        $this->advanceToNextStep();
    }

    /**
     * Complete current step and advance.
     *
     * @return void
     */
    public function completeStep()
    {
        $this->requestStep->update([
            'request_step_status' => 'completed',
            'step_date' => now(),
        ]);

        $this->advanceToNextStep();
    }

    /**
     * Handle conditional step response.
     *
     * @param string $response
     * @return void
     */
    public function conditionalStep($response)
    {
        $this->requestStep->update([
            'request_step_status' => 'completed',
            'step_date' => now(),
            'step_response' => $response,
        ]);

        // Handle conditional branching based on response
        $this->advanceToNextStep($response);
    }

    /**
     * Advance to next step or complete request.
     *
     * @param string|null $conditionalResponse For conditional steps: 'yes' or 'no'
     * @return void
     */
    protected function advanceToNextStep($conditionalResponse = null)
    {
        // Determine next step based on current step type
        $nextStepId = null;

        if ($this->step->step_type === 'conditional' && $conditionalResponse) {
            // For conditional steps, use next_yes or next_no
            $nextStepId = ($conditionalResponse === 'yes')
                ? $this->step->next_yes
                : $this->step->next_no;
        } else {
            // For normal/initial/final steps, use next_step_id
            $nextStepId = $this->step->next_step_id;
        }

        if ($nextStepId) {
            // Find the request step for the next step
            $nextRequestStep = $this->request->requestSteps
                ->where('step_id', $nextStepId)
                ->first();

            if ($nextRequestStep) {
                // Activate next step
                $nextRequestStep->update([
                    'request_step_status' => 'in_progress',
                ]);

                $this->dispatch(
                    'step-completed',
                    title: '¡Paso completado!',
                    message: 'Se ha avanzado al siguiente paso.',
                    redirectUrl: route(config('proj.route_name_prefix', 'proj') . '.worker.procedure-detail', ['id' => $this->requestId])
                );
                return;
            }
        }

        // No next step found - complete the request
        $this->request->update([
            'status' => 'completed',
            'end_date' => now(),
        ]);

        $this->dispatch(
            'step-completed',
            title: '¡Trámite completado!',
            message: 'Has completado todos los pasos de este trámite.',
            redirectUrl: route(config('proj.route_name_prefix', 'proj') . '.worker.my-procedures')
        );
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('modules.worker.step-detail')
            ->layout('layouts.app');
    }
}
