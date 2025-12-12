<?php
/**
 * Company: CETAM
 * Project: ST
 * File: CreateProcess.php
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

class CreateProcess extends Component
{
    public $name = '';
    public $description = '';
    public $active = false;
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
        'description' => 'required|string|max:2000',
        'active' => 'boolean',
        'process_code' => 'required|string|max:50',
        'category' => 'required|string|in:Administrativo,Operativo,Finanzas,Recursos Humanos,Tecnologia',
        'department' => 'required|string|in:Administracion,Finanzas,Recursos Humanos,Sistemas,Juridico',
    ];

    protected $messages = [
        'name.required' => 'El campo nombre del proceso es obligatorio',
        'name.max' => 'El nombre no debe exceder 255 caracteres',
        'description.required' => 'El campo descripción es obligatorio',
        'description.max' => 'La descripción no debe exceder 2000 caracteres',
        'process_code.required' => 'El campo código del proceso es obligatorio',
        'process_code.max' => 'El código del proceso no debe exceder 50 caracteres',
        'category.required' => 'El campo categoría es obligatorio',
        'category.in' => 'La opción seleccionada en categoría no es válida',
        'department.required' => 'El campo área responsable es obligatorio',
        'department.in' => 'La opción seleccionada en área responsable no es válida',
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
            'name',
            'description',
            'process_code',
            'category',
            'department',
            'active',
        ]);
        $this->active = true;
        $this->successMessage = 'Proceso creado correctamente.';
    }

    public function render()
    {
        return view('modules.admin.create-process')
            ->layout('layouts.app');
    }
}
