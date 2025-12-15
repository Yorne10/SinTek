<?php
/**
 * Company: CETAM
 * Project: ST
 * File: DocumentForm.php
 * Created on: 01/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
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
    public $categoria;
    public $version;
    public $fecha_vigencia;
    public $sin_fecha_vigencia = false;
    public $archivo;
    public $archivo_actual;
    public $status = 'active';

    /**

     * Initialize component state.

     *

     * @param mixed $id

     *

     * @return void

     */

    public function mount($id = null): void
    {
        if ($id) {
            $this->documentId = $id;
            $document = InstitutionalDocument::findOrFail($id);
            $this->titulo = $document->title;
            $this->descripcion = $document->description;
            $this->categoria = $document->category;
            $this->version = $document->version;
            $this->fecha_vigencia = $document->effective_date?->format('Y-m-d');
            $this->sin_fecha_vigencia = !$document->effective_date;
            $this->archivo_actual = $document->file_name;
            $this->status = $document->status ?? 'active';
        }
    }

    /**

     * Updated sin fecha vigencia.

     *

     * @param mixed $value

     *

     * @return void

     */

    public function updatedSinFechaVigencia($value)
    {
        if ($value) {
            $this->fecha_vigencia = null;
        }
    }

    /**

     * Toggle status.

     *

     * @return void

     */

    public function toggleStatus()
    {
        $this->status = $this->status === 'active' ? 'inactive' : 'active';
    }

    protected function rules(): array
    {
        $rules = [
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:5000',
            'categoria' => 'required|string|in:reglamento,manual,lineamiento,codigo,otro',
            'version' => 'required|string|max:20',
            'fecha_vigencia' => $this->sin_fecha_vigencia ? 'nullable|date' : 'required|date',
        ];

        // If it is a new document, file is required
        // If it is editing, file is optional
        if ($this->documentId) {
            $rules['archivo'] = 'nullable|file|mimes:pdf|max:10240';
        } else {
            $rules['archivo'] = 'required|file|mimes:pdf|max:10240';
        }

        return $rules;
    }

    protected $messages = [
        'titulo.required' => 'El campo título es obligatorio',
        'titulo.max' => 'El título no debe exceder los 200 caracteres',
        'descripcion.max' => 'La descripción no debe exceder los 5000 caracteres',
        'categoria.required' => 'El campo categoría es obligatorio',
        'categoria.in' => 'La opción seleccionada en categoría no es válida',
        'version.required' => 'El campo versión es obligatorio',
        'version.max' => 'La versión no debe exceder los 20 caracteres',
        'fecha_vigencia.required' => 'El campo fecha de vigencia es obligatorio',
        'fecha_vigencia.date' => 'La fecha de vigencia no tiene un formato válido',
        'archivo.required' => 'El archivo es obligatorio',
        'archivo.file' => 'El archivo no tiene un formato válido',
        'archivo.mimes' => 'El archivo debe ser un PDF',
        'archivo.max' => 'El archivo no debe exceder los 10MB',
    ];

    /**

     * Save the data.

     *

     * @return void

     */

    public function save(): void
    {
        try {
            // Validate fields
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
                'status' => $this->status,
            ];

            // Prepare file if exists
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
                    // Usar el título del formulario como nombre del archivo
                    $data['file_name'] = Str::slug($this->titulo) . '.pdf';

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

                // Dispatch evento para mostrar alerta de éxito
                $this->dispatch(
                    'document-saved',
                    type: 'success',
                    title: 'Documento guardado',
                    message: 'El documento ha sido guardado exitosamente.'
                );

                // Clear form after creation
                $this->reset(['titulo', 'descripcion', 'categoria', 'version', 'fecha_vigencia', 'sin_fecha_vigencia', 'archivo']);

                // Dispatch evento para limpiar el input file
                $this->dispatch('document-saved');
            } else {
                $document = InstitutionalDocument::findOrFail($this->documentId);

                $data['status'] = $this->status;
                $data['uploaded_by'] = $document->uploaded_by ?? $user?->users_id;

                Log::info('Actualizando documento', ['id' => $this->documentId, 'data' => array_keys($data)]);

                $document->update($data);

                ActivityLogger::log(
                    'documento.editar',
                    "Documento institucional editado: '{$document->title}' - Categoría: {$document->category}",
                    $user?->users_id
                );

                // Dispatch evento para mostrar alerta de éxito
                $this->dispatch(
                    'document-saved',
                    type: 'success',
                    title: 'Documento actualizado',
                    message: 'El documento ha sido actualizado exitosamente.'
                );
            }

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
            // Dispatch evento para mostrar alerta de error
            $this->dispatch(
                'document-error',
                type: 'error',
                title: 'Error',
                message: 'Error al guardar el documento: ' . $e->getMessage()
            );
        }
    }

    /**

     * Delete the specified resource.

     *

     * @return void

     */

    public function delete(): void
    {
        if (!$this->documentId) {
            return;
        }

        try {
            $document = InstitutionalDocument::findOrFail($this->documentId);
            $title = $document->title;
            $document->delete();

            $user = Auth::user();
            ActivityLogger::log(
                'documento.eliminar',
                "Documento institucional eliminado: '{$title}'",
                $user?->users_id
            );

            $this->dispatch(
                'document-deleted',
                type: 'success',
                title: 'Eliminado',
                message: 'El documento ha sido eliminado exitosamente.'
            );
        } catch (\Exception $e) {
            Log::error('Error al eliminar documento', [
                'error' => $e->getMessage()
            ]);
            $this->dispatch(
                'document-error',
                type: 'error',
                title: 'Error',
                message: 'No se pudo eliminar el documento.'
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
        return view('modules.secretary.document-form')->layout('layouts.app');
    }
}
