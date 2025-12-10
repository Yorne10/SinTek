<?php
/**
 * Company: CETAM
 * Project: ST
 * File: DocumentoForm.php
 * Created on: 01/12/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\InstitutionalDocument;
use App\Services\ActivityLogger;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

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

    public function mount($id = null)
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

    protected function rules()
    {
        $rules = [
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|string',
            'version' => 'required|string|max:20',
            'fecha_vigencia' => 'nullable|date',
        ];

        if (!$this->documentId) {
            $rules['archivo'] = 'required|file|mimes:pdf|max:10240'; // 10MB max
        } else {
            $rules['archivo'] = 'nullable|file|mimes:pdf|max:10240';
        }

        return $rules;
    }

    protected $messages = [
        'titulo.required' => 'El título del documento es obligatorio.',
        'categoria.required' => 'La categoría es obligatoria.',
        'version.required' => 'La versión es obligatoria.',
        'archivo.required' => 'Debe seleccionar un archivo PDF.',
        'archivo.mimes' => 'El archivo debe ser un PDF.',
        'archivo.max' => 'El archivo no debe superar los 10MB.',
    ];

    public function save()
    {
        $this->validate();
        $user = Auth::user();

        try {
            $data = [
                'title' => $this->titulo,
                'description' => $this->descripcion,
                'category' => $this->categoria,
                'version' => $this->version,
                'effective_date' => $this->fecha_vigencia,
                'status' => 'activo',
            ];

            if ($this->archivo) {
                $fileContent = file_get_contents($this->archivo->getRealPath());
                $data['file_content'] = $fileContent;
                $data['file_size'] = $this->archivo->getSize();
            }

            if ($this->documentId) {
                // Actualizar documento existente
                $document = InstitutionalDocument::findOrFail($this->documentId);
                $document->update($data);

                ActivityLogger::log(
                    'documento.editar',
                    "Documento institucional editado: '{$document->title}' - Categoría: {$document->category}",
                    $user?->users_id
                );

                $message = 'El documento ha sido actualizado exitosamente.';
            } else {
                // Crear nuevo documento
                $document = InstitutionalDocument::create($data);

                ActivityLogger::log(
                    'documento.crear',
                    "Documento institucional creado: '{$document->title}' - Categoría: {$document->category}",
                    $user?->users_id
                );

                $message = 'El documento ha sido guardado exitosamente.';
            }

            session()->flash('success', $message);
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.documents');

        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el documento: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('modules.secretary.document-form')->layout('layouts.app');
    }
}
