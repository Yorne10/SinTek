<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocatoriasDocumentos.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 */

namespace App\Livewire\Secretary;

use App\Models\Convocation;
use App\Models\ConvocationDocument;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ConvocatoriasDocumentos extends Component
{
    use WithFileUploads, WithPagination;

    // Form fields
    public $titulo;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;
    public $convocatoria_permanente = false;

    // Documents array
    public $documentos = [];

    protected function rules()
    {
        return [
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'documentos.*.titulo' => 'required|string|max:150',
            'documentos.*.archivo' => 'required|file|mimes:pdf|max:5120', // 5MB max
        ];
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
    ];

    public function save()
    {
        $this->validate();

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
            // Si es permanente
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

        // Guardar documentos si existen
        if (!empty($this->documentos)) {
            foreach ($this->documentos as $documento) {
                if (isset($documento['archivo']) && $documento['archivo']) {
                    // Leer el contenido del archivo
                    $fileContent = file_get_contents($documento['archivo']->getRealPath());

                    // Crear el registro del documento
                    ConvocationDocument::create([
                        'convocation_id' => $convocatoria->convocation_id,
                        'title' => $documento['titulo'],
                        'file_content' => $fileContent,
                    ]);
                }
            }
        }

        // Limpiar el formulario
        $this->reset(['titulo', 'descripcion', 'fecha_inicio', 'fecha_fin', 'convocatoria_permanente', 'documentos']);

        // Mensaje de éxito
        session()->flash('success', 'Convocatoria creada exitosamente.');

        $this->dispatch('convocatoria-created');
    }

    public function addDocumento()
    {
        $this->documentos[] = ['titulo' => '', 'archivo' => null];
    }

    public function removeDocumento($index)
    {
        unset($this->documentos[$index]);
        $this->documentos = array_values($this->documentos); // Reindexar el array
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
            ->paginate(10);

        return view('livewire.secretary.convocatorias-documentos', [
            'convocatorias' => $convocatorias
        ])->layout('layouts.app');
    }
}
