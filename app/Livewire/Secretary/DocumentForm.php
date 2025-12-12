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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
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
            'descripcion' => 'nullable|string|max:5000',
            'categoria' => 'required|string|in:reglamento,manual,lineamiento,codigo,otro',
            'version' => 'required|string|max:20',
            'fecha_vigencia' => 'nullable|date',
        ];

        // Si es nuevo documento, el archivo es obligatorio
        // Si es edición, el archivo es opcional
        if ($this->documentId) {
            $rules['archivo'] = 'nullable|file|mimes:pdf|max:10240';
        } else {
            $rules['archivo'] = 'required|file|mimes:pdf|max:10240';
        }

        return $rules;
    }

    protected $messages = [
        'titulo.required' => 'El título del documento es obligatorio',
        'titulo.max' => 'El título no debe exceder los 200 caracteres',
        'descripcion.max' => 'La descripción no debe exceder los 5000 caracteres',
        'categoria.required' => 'La categoría es obligatoria',
        'categoria.in' => 'La categoría seleccionada no es válida',
        'version.required' => 'La versión es obligatoria',
        'version.max' => 'La versión no debe exceder los 20 caracteres',
        'fecha_vigencia.date' => 'La fecha de vigencia no es válida',
        'archivo.required' => 'Debes seleccionar un archivo PDF',
        'archivo.file' => 'El archivo seleccionado no es válido',
        'archivo.mimes' => 'El archivo debe ser un PDF',
        'archivo.max' => 'El archivo no debe superar los 10MB',
    ];

    public function save(): void
    {
        try {
            // Validar campos
            $validated = $this->validate();

            Log::info('DocumentForm::save - Validación exitosa', [
                'archivo_presente' => $this->archivo ? 'SI' : 'NO',
                'es_nuevo' => !$this->documentId
            ]);

            $user = Auth::user();

            $data = [
                'title' => trim((string) $this->titulo),
                'description' => trim((string) $this->descripcion) ?: null,
                'category' => $this->categoria,
                'version' => trim((string) $this->version),
                'effective_date' => $this->fecha_vigencia ?: null,
            ];

            // Preparar archivo si existe
            if ($this->archivo) {
                try {
                    $file = $this->archivo;
                    $filePath = $file->getRealPath();

                    Log::info('Procesando archivo', [
                        'path' => $filePath,
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType()
                    ]);

                    $data['file_content'] = file_get_contents($filePath);
                    $data['file_size'] = $file->getSize();
                    $data['mime_type'] = $file->getMimeType() ?? 'application/pdf';
                    $data['file_name'] = $file->getClientOriginalName() ?: ('documento-' . Str::random(8) . '.pdf');

                    Log::info('Archivo procesado correctamente', [
                        'file_name' => $data['file_name'],
                        'file_size' => $data['file_size']
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error al procesar archivo', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    session()->flash('error', 'Error al procesar el archivo PDF: ' . $e->getMessage());
                    return;
                }
            }

            $isNew = !$this->documentId;

            if ($isNew) {
                $data['status'] = 'active';
                $data['uploaded_by'] = $user?->users_id;

                Log::info('Creando nuevo documento', $data);

                $document = InstitutionalDocument::create($data);

                ActivityLogger::log(
                    'documento.crear',
                    "Documento institucional creado: '{$document->title}' - Categoría: {$document->category}",
                    $user?->users_id
                );

                session()->flash('success', 'El documento ha sido guardado exitosamente.');
            } else {
                $document = InstitutionalDocument::findOrFail($this->documentId);

                $data['status'] = $document->status ?? 'active';
                $data['uploaded_by'] = $document->uploaded_by ?? $user?->users_id;

                Log::info('Actualizando documento', ['id' => $this->documentId, 'data' => array_keys($data)]);

                $document->update($data);

                ActivityLogger::log(
                    'documento.editar',
                    "Documento institucional editado: '{$document->title}' - Categoría: {$document->category}",
                    $user?->users_id
                );

                session()->flash('success', 'El documento ha sido actualizado exitosamente.');
            }

            redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.documents');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación', [
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error al guardar documento', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Error al guardar el documento: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('modules.secretary.document-form')->layout('layouts.app');
    }
}
