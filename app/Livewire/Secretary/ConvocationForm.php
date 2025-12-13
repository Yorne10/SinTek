<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocatoriaForm.php
 * Created on: 01/12/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\Convocation;
use App\Models\ConvocationDocument;
use App\Services\ActivityLogger;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConvocationForm extends Component
{
    use WithFileUploads;

    public $convocationId;
    public $titulo;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;
    public $convocatoria_permanente = false;
    public $documentos = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->convocationId = $id;
            $convocation = Convocation::findOrFail($id);
            $this->titulo = $convocation->title;
            $this->descripcion = $convocation->description;
            $this->fecha_inicio = $convocation->start_date?->format('Y-m-d');
            $this->fecha_fin = $convocation->end_date?->format('Y-m-d');
            $this->convocatoria_permanente = !$convocation->end_date;
        }
    }

    public function updatedConvocatoriaPermanente($value)
    {
        if ($value) {
            $this->fecha_fin = null;
        }
    }

    protected function rules()
    {
        return [
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => $this->convocatoria_permanente ? 'nullable|date|after_or_equal:fecha_inicio' : 'required|date|after_or_equal:fecha_inicio',
            'documentos.*.titulo' => 'required_with:documentos.*.archivo|string|max:150',
            'documentos.*.archivo' => 'required_with:documentos.*.titulo|file|mimes:pdf|max:5120',
        ];
    }

    protected $messages = [
        'titulo.required' => 'El título es obligatorio.',
        'descripcion.required' => 'La descripción es obligatoria.',
        'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
        'fecha_fin.required' => 'La fecha de fin es obligatoria o marca "Convocatoria permanente".',
        'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        'documentos.*.titulo.required_with' => 'El título del documento es obligatorio.',
        'documentos.*.archivo.required_with' => 'Debe seleccionar un archivo PDF.',
        'documentos.*.archivo.mimes' => 'El archivo debe ser un PDF.',
        'documentos.*.archivo.max' => 'El archivo no debe superar los 5MB.',
    ];

    public function addDocumento()
    {
        $this->documentos[] = ['titulo' => '', 'archivo' => null];
    }

    public function removeDocumento($index)
    {
        unset($this->documentos[$index]);
        $this->documentos = array_values($this->documentos);
    }

    public function save(): void
    {
        try {
            $this->validate();

            Log::info('ConvocationForm::save - Validación exitosa', [
                'documentos_count' => count($this->documentos),
                'es_nuevo' => !$this->convocationId
            ]);

            $user = Auth::user();
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

            if ($this->convocationId) {
                // Actualizar convocatoria existente
                $convocatoria = Convocation::findOrFail($this->convocationId);
                $convocatoria->update([
                    'title' => $this->titulo,
                    'description' => $this->descripcion,
                    'start_date' => $this->fecha_inicio,
                    'end_date' => $this->convocatoria_permanente ? null : $this->fecha_fin,
                    'status' => $status,
                ]);

                ActivityLogger::log(
                    'convocatoria.editar',
                    "Convocatoria editada: '{$convocatoria->title}'",
                    $user?->users_id
                );

                $message = 'La convocatoria ha sido actualizada exitosamente.';
            } else {
                // Crear nueva convocatoria
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

                $message = 'La convocatoria ha sido publicada exitosamente.';
            }

            // Guardar documentos si existen
            if (!empty($this->documentos)) {
                foreach ($this->documentos as $index => $documento) {
                    if (isset($documento['archivo']) && $documento['archivo'] && isset($documento['titulo']) && $documento['titulo']) {
                        try {
                            $file = $documento['archivo'];
                            $filePath = $file->getRealPath();

                            Log::info('Procesando documento de convocatoria', [
                                'index' => $index,
                                'titulo' => $documento['titulo'],
                                'path' => $filePath,
                                'size' => $file->getSize(),
                                'mime' => $file->getMimeType()
                            ]);

                            ConvocationDocument::create([
                                'convocation_id' => $convocatoria->convocation_id,
                                'file_name' => $documento['titulo'] ?: ($file->getClientOriginalName() ?? 'documento.pdf'),
                                'mime_type' => $file->getMimeType() ?: 'application/pdf',
                                'file_content' => file_get_contents($filePath),
                            ]);

                            Log::info('Documento guardado correctamente', [
                                'index' => $index,
                                'titulo' => $documento['titulo']
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Error al procesar documento de convocatoria', [
                                'index' => $index,
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString()
                            ]);
                            throw $e;
                        }
                    }
                }
            }
            $isNew = !$this->convocationId;

            if ($isNew) {
                // Limpiar formulario después de crear
                $this->reset(['titulo', 'descripcion', 'fecha_inicio', 'fecha_fin', 'convocatoria_permanente', 'documentos']);

                $this->dispatch(
                    'convocation-saved',
                    type: 'success',
                    title: 'Convocatoria publicada',
                    message: $message,
                    redirect: null
                );
            } else {
                $this->dispatch(
                    'convocation-saved',
                    type: 'success',
                    title: 'Convocatoria actualizada',
                    message: $message,
                    redirect: route(config('proj.route_name_prefix', 'proj') . '.secretary.calls')
                );
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación en convocatoria', [
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error al guardar convocatoria', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Ocurrió un error al guardar la convocatoria: ' . $e->getMessage());
        }
    }

    public function delete(): void
    {
        if (!$this->convocationId) {
            return;
        }

        try {
            $convocation = Convocation::findOrFail($this->convocationId);
            $title = $convocation->title;

            // Delete associated documents first
            $convocation->documents()->delete();
            $convocation->delete();

            $user = Auth::user();
            ActivityLogger::log(
                'convocatoria.eliminar',
                "Convocatoria eliminada: '{$title}'",
                $user?->users_id
            );

            $this->dispatch(
                'convocation-deleted',
                type: 'success',
                title: 'Eliminada',
                message: 'La convocatoria ha sido eliminada exitosamente.'
            );
        } catch (\Exception $e) {
            Log::error('Error al eliminar convocatoria', [
                'error' => $e->getMessage()
            ]);
            $this->dispatch(
                'convocation-error',
                type: 'error',
                title: 'Error',
                message: 'No se pudo eliminar la convocatoria.'
            );
        }
    }

    public function render()
    {
        return view('modules.secretary.convocation-form')->layout('layouts.app');
    }
}
