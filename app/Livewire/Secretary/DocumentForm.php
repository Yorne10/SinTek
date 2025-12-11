<?php
/**
 * Company: CETAM
 * Project: ST
 * File: DocumentForm.php
 * Created on: 01/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace App\Livewire\Secretary;

use App\Models\InstitutionalDocument;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentForm extends Component
{
    use WithFileUploads;

    public $documentId;
    public $titulo;
    public $descripcion;
    public $categoria = 'reglamento';
    public $version = '1.0';
    public $fecha_vigencia;
    public $archivo;

    public function mount($id = null): void
    {
        if ($id) {
            $this->documentId = $id;
            $document = InstitutionalDocument::findOrFail($id);
            $this->titulo = $document->title;
            $this->descripcion = $document->description;
            $this->categoria = $document->category ?? 'reglamento';
            $this->version = $document->version ?? '1.0';
            $this->fecha_vigencia = $document->effective_date?->format('Y-m-d');
        }
    }

    protected function rules(): array
    {
        $rules = [
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|string',
            'version' => 'required|string|max:20',
            'fecha_vigencia' => 'nullable|date',
        ];

        if (!$this->documentId) {
            $rules['archivo'] = 'required|file|mimes:pdf|max:10240'; // 10MB
        } else {
            $rules['archivo'] = 'nullable|file|mimes:pdf|max:10240';
        }

        return $rules;
    }

    protected $messages = [
        'titulo.required' => 'El título del documento es obligatorio.',
        'titulo.max' => 'El título no debe exceder los 200 caracteres.',
        'categoria.required' => 'La categoría es obligatoria.',
        'version.required' => 'La versión es obligatoria.',
        'archivo.required' => 'Debe seleccionar un archivo PDF.',
        'archivo.mimes' => 'El archivo debe ser un PDF.',
        'archivo.max' => 'El archivo no debe superar los 10MB.',
    ];

    public function save(): void
    {
        $this->validate();
        $user = Auth::user();

        $data = [
            'title' => trim((string) $this->titulo),
            'description' => $this->descripcion ? trim($this->descripcion) : null,
            'category' => $this->categoria,
            'version' => trim((string) $this->version),
            'effective_date' => $this->fecha_vigencia ?: null,
        ];

        $isNew = !$this->documentId;

        // Preparar archivo si se cargó
        if ($this->archivo) {
            $file = $this->archivo;
            $data['file_content'] = file_get_contents($file->getRealPath());
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType() ?? 'application/pdf';
            $data['file_name'] = $file->getClientOriginalName() ?: ('documento-' . Str::random(8) . '.pdf');
        }

        try {
            if ($isNew) {
                $data['status'] = 'active';
                $data['uploaded_by'] = $user?->users_id;

                $document = InstitutionalDocument::create($data);

                ActivityLogger::log(
                    'documento.crear',
                    "Documento institucional creado: '{$document->title}' - Categoría: {$document->category}",
                    $user?->users_id
                );

                session()->flash('success', 'El documento ha sido guardado exitosamente.');
            } else {
                $document = InstitutionalDocument::findOrFail($this->documentId);

                // Mantener status/uploader si no se envían
                $data['status'] = $document->status ?? 'active';
                $data['uploaded_by'] = $document->uploaded_by ?? $user?->users_id;

                $document->update($data);

                ActivityLogger::log(
                    'documento.editar',
                    "Documento institucional editado: '{$document->title}' - Categoría: {$document->category}",
                    $user?->users_id
                );

                session()->flash('success', 'El documento ha sido actualizado exitosamente.');
            }

            redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.documents')->send();
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el documento.');
        }
    }

    public function render()
    {
        return view('modules.secretary.document-form')->layout('layouts.app');
    }
}
