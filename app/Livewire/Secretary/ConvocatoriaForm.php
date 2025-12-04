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

class ConvocatoriaForm extends Component
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

    protected function rules()
    {
        return [
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'documentos.*.titulo' => 'required_with:documentos.*.archivo|string|max:150',
            'documentos.*.archivo' => 'required_with:documentos.*.titulo|file|mimes:pdf|max:5120',
        ];
    }

    protected $messages = [
        'titulo.required' => 'El título es obligatorio.',
        'descripcion.required' => 'La descripción es obligatoria.',
        'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
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
                    'convocatoria.editada',
                    "Edición de convocatoria '{$convocatoria->title}' (ID: {$convocatoria->convocation_id})",
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
                    'convocatoria.creada',
                    "Creación de convocatoria '{$convocatoria->title}' (ID: {$convocatoria->convocation_id})",
                    $user?->users_id
                );

                $message = 'La convocatoria ha sido publicada exitosamente.';
            }

            // Guardar documentos si existen (solo para nuevas convocatorias)
            if (!$this->convocationId && !empty($this->documentos)) {
                foreach ($this->documentos as $documento) {
                    if (isset($documento['archivo']) && $documento['archivo'] && isset($documento['titulo']) && $documento['titulo']) {
                        $fileContent = file_get_contents($documento['archivo']->getRealPath());

                        ConvocationDocument::create([
                            'convocation_id' => $convocatoria->convocation_id,
                            'title' => $documento['titulo'],
                            'file_content' => $fileContent,
                        ]);
                    }
                }
            }

            session()->flash('success', $message);
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.convocatorias-documentos');

        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar la convocatoria: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('modules.secretary.convocatoria-form')->layout('layouts.app');
    }
}
