<?php
/**
 * Company: CETAM
 * Project: ST
 * File: CrearProceso.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 *   Modified by: <Developer name> |
 *   Description: <Brief description of change> |
 *
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 *   Modified by: <Developer name> |
 *   Description: <Brief description of change> |
 */

namespace App\Livewire\Admin;

use App\Models\Process;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CrearProceso extends Component
{
    public $name = '';
    public $description = '';
    public $active = true;
    public $process_code = '';
    public $category = '';
    public $department = '';
    public $successMessage = '';

    // Opciones precargadas para selects
    public array $categoryOptions = [
        'Administrativo',
        'Operativo',
        'Finanzas',
        'Recursos Humanos',
        'Tecnologia',
    ];

    public array $departmentOptions = [
        'Administracion',
        'Finanzas',
        'Recursos Humanos',
        'Sistemas',
        'Juridico',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:2000',
        'active' => 'boolean',
        'process_code' => 'nullable|string|max:50',
        'category' => 'nullable|string|in:Administrativo,Operativo,Finanzas,Recursos Humanos,Tecnologia',
        'department' => 'nullable|string|in:Administracion,Finanzas,Recursos Humanos,Sistemas,Juridico',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.max' => 'El nombre no debe exceder 255 caracteres.',
        'description.max' => 'La descripcion es demasiado larga.',
        'process_code.max' => 'El codigo no debe exceder 50 caracteres.',
        'category.in' => 'Selecciona una categoria valida.',
        'department.in' => 'Selecciona un area responsable valida.',
    ];

    public function save()
    {
        $this->validate();

        Process::create([
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active ? 1 : 0,
            'created_by' => Auth::id(),
            'process_code' => $this->process_code,
            'category' => $this->category,
            'department' => $this->department,
        ]);

        ActivityLogger::log(
            'proceso.crear',
            "Proceso '{$this->name}' creado",
            Auth::id()
        );

        $this->reset([
            'name', 'description', 'process_code',
            'category', 'department', 'active',
        ]);
        $this->active = true;
        $this->successMessage = 'Proceso creado correctamente.';
    }

    public function render()
    {
        return view('modules.admin.crear-proceso')
            ->layout('layouts.app');
    }
}
