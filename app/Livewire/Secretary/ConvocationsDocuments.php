<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocationsDocuments.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\Convocation;
use App\Models\ConvocationDocument;
use App\Models\InstitutionalDocument;
use App\Services\ActivityLogger;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ConvocationsDocuments extends Component
{
    use WithFileUploads, WithPagination;

    // Form fields para convocatorias
    public $titulo;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;
    public $convocatoria_permanente = false;

    // Documents array para convocatorias
    public $documentos = [];

    // Form fields para documentos institucionales
    public $showInstitutionalForm = false;
    public $doc_titulo;
    public $doc_descripcion;
    public $doc_categoria = 'reglamento';
    public $doc_version = '1.0';
    public $doc_fecha_vigencia;
    public $doc_archivo;

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        $rules = [
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'documentos.*.titulo' => 'required|string|max:150',
            'documentos.*.archivo' => 'required|file|mimes:pdf|max:5120',
        ];

        if ($this->showInstitutionalForm) {
            $rules['doc_titulo'] = 'required|string|max:200';
            $rules['doc_categoria'] = 'required|string';
            $rules['doc_version'] = 'required|string|max:20';
            $rules['doc_archivo'] = 'required|file|mimes:pdf|max:10240'; // 10MB max
        }

        return $rules;
    }

    protected $messages = [
        'titulo.required' => 'El título es obligatorio.',
        'descripcion.required' => 'La descripción es obligatoria.',
        'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
        'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        'documentos.*.titulo.required' => 'El título del documento es obligatorio.',
        'documentos.*.archivo.required' => 'Debe seleccionar un archivo PDF.',
        'documentos.*.archivo.mimes' => 'El archivo debe ser un PDF.',
        'documentos.*.archivo.max' => 'El archivo no debe superar los 5MB.',
        'doc_titulo.required' => 'El título del documento es obligatorio.',
        'doc_categoria.required' => 'La categoría es obligatoria.',
        'doc_archivo.required' => 'Debe seleccionar un archivo PDF.',
        'doc_archivo.mimes' => 'El archivo debe ser un PDF.',
        'doc_archivo.max' => 'El archivo no debe superar los 10MB.',
    ];

    public function save()
    {
        $this->validate();
        $user = Auth::user();

        try {
            // Determinar el estado de la convocatoria
            $status = 'activa';
            $today = now()->startOfDay();
            $startDate = \Carbon\Carbon::parse($this->fecha_inicio)->startOfDay();

            if ($this->fecha_fin) {
                $endDate = \Carbon\Carbon::parse($this->fecha_fin)->startOfDay();

                if ($today->lt($startDate)) {
                    $status = 'proxima';
                } elseif ($today->gt($endDate)) {
                    $status = 'cerrada';
                } else {
                    $status = 'activa';
                }
            } else {
                if ($today->lt($startDate)) {
                    $status = 'proxima';
                } else {
                    $status = 'permanente';
                }
            }

            // Crear la convocatoria
            $convocatoria = Convocation::create([
                'title' => $this->titulo,
                'description' => $this->descripcion,
                'start_date' => $this->fecha_inicio,
                'end_date' => $this->convocatoria_permanente ? null : $this->fecha_fin,
                'status' => $status,
            ]);

            ActivityLogger::log(
                'convocatoria.crear',
                "Convocatoria creada: '{$convocatoria->title}'",
                $user?->users_id
            );

            // Guardar documentos si existen
            if (!empty($this->documentos)) {
                foreach ($this->documentos as $documento) {
                    if (isset($documento['archivo']) && $documento['archivo']) {
                        $file = $documento['archivo'];
                        ConvocationDocument::create([
                            'convocation_id' => $convocatoria->convocation_id,
                            'title' => $documento['titulo'],
                            'file_name' => $file->getClientOriginalName(),
                            'mime_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(),
                            'file_content' => file_get_contents($file->getRealPath()),
                        ]);
                    }
                }
            }

            // Limpiar el formulario
            $this->reset(['titulo', 'descripcion', 'fecha_inicio', 'fecha_fin', 'convocatoria_permanente', 'documentos']);

            $this->dispatch(
                'convocatoria-notify',
                type: 'success',
                title: '¡Convocatoria creada!',
                message: 'La convocatoria ha sido publicada exitosamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'convocatoria-notify',
                type: 'error',
                title: 'Error',
                message: 'No se pudo crear la convocatoria: ' . $e->getMessage()
            );
        }
    }

    public function saveInstitutionalDocument()
    {
        $this->validate([
            'doc_titulo' => 'required|string|max:200',
            'doc_categoria' => 'required|string',
            'doc_version' => 'required|string|max:20',
            'doc_archivo' => 'required|file|mimes:pdf|max:10240',
        ]);
        $user = Auth::user();

        try {
            $fileContent = file_get_contents($this->doc_archivo->getRealPath());
            $fileName = $this->doc_archivo->getClientOriginalName();
            $fileSize = $this->doc_archivo->getSize();

            $institutional = InstitutionalDocument::create([
                'title' => $this->doc_titulo,
                'description' => $this->doc_descripcion,
                'category' => $this->doc_categoria,
                'file_content' => $fileContent,
                'file_name' => $fileName,
                'mime_type' => 'application/pdf',
                'file_size' => $fileSize,
                'version' => $this->doc_version,
                'status' => 'vigente',
                'effective_date' => $this->doc_fecha_vigencia,
                'uploaded_by' => Auth::id(),
            ]);

            ActivityLogger::log(
                'documento.crear',
                "Documento institucional creado: '{$this->doc_titulo}' - Categoría: {$this->doc_categoria}",
                $user?->users_id
            );

            $this->reset(['doc_titulo', 'doc_descripcion', 'doc_categoria', 'doc_version', 'doc_fecha_vigencia', 'doc_archivo']);
            $this->showInstitutionalForm = false;

            $this->dispatch(
                'convocatoria-notify',
                type: 'success',
                title: '¡Documento subido!',
                message: 'El documento institucional ha sido guardado exitosamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'convocatoria-notify',
                type: 'error',
                title: 'Error',
                message: 'No se pudo guardar el documento: ' . $e->getMessage()
            );
        }
    }

    public function toggleInstitutionalForm()
    {
        $this->showInstitutionalForm = !$this->showInstitutionalForm;
        if (!$this->showInstitutionalForm) {
            $this->reset(['doc_titulo', 'doc_descripcion', 'doc_categoria', 'doc_version', 'doc_fecha_vigencia', 'doc_archivo']);
            $this->resetValidation();
        }
    }

    public function archiveInstitutionalDocument($id)
    {
        try {
            $user = Auth::user();
            $document = InstitutionalDocument::findOrFail($id);
            $document->status = 'archivado';
            $document->save();

            ActivityLogger::log(
                'documento.archivar',
                "Documento institucional archivado: '{$document->title}' - Categoría: {$document->category}",
                $user?->users_id
            );

            $this->dispatch(
                'convocatoria-notify',
                type: 'warning',
                title: 'Documento archivado',
                message: 'El documento ha sido archivado correctamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'convocatoria-notify',
                type: 'error',
                title: 'Error',
                message: 'No se pudo archivar el documento.'
            );
        }
    }

    public function addDocumento()
    {
        $this->documentos[] = ['titulo' => '', 'archivo' => null];
    }

    public function removeDocumento($index)
    {
        unset($this->documentos[$index]);
        $this->documentos = array_values($this->documentos);
    }

    public function limpiar()
    {
        $this->reset(['titulo', 'descripcion', 'fecha_inicio', 'fecha_fin', 'convocatoria_permanente', 'documentos']);
        $this->resetValidation();
    }

    public function render()
    {
        $convocatorias = Convocation::with('documents')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'convocatorias_page');

        $institutionalDocuments = InstitutionalDocument::with('uploader')
            ->where('status', 'vigente')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'institutional_page');

        return view('modules.secretary.convocations-documents', [
            'convocatorias' => $convocatorias,
            'institutionalDocuments' => $institutionalDocuments
        ])->layout('layouts.app');
    }
}
