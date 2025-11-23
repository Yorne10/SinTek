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
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 *
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Admin;

use App\Models\Process;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CrearProceso extends Component
{
    public $name = '';
    public $description = '';
    public $active = true;
    public $process_code = '';
    public $category = '';
    public $priority = 'medium';
    public $deadline_days = null;
    public $department = '';
    public $successMessage = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:2000',
        'active' => 'boolean',
        'process_code' => 'nullable|string|max:50',
        'category' => 'nullable|string|max:100',
        'priority' => 'nullable|string|in:low,medium,high,urgent',
        'deadline_days' => 'nullable|integer|min:1|max:365',
        'department' => 'nullable|string|max:100',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.max' => 'El nombre no debe exceder 255 caracteres.',
        'description.max' => 'La descripción es demasiado larga.',
        'process_code.max' => 'El código no debe exceder 50 caracteres.',
        'deadline_days.min' => 'El tiempo máximo de respuesta debe ser al menos 1 día.',
        'deadline_days.max' => 'El tiempo máximo de respuesta no debe exceder 365 días.',
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
            'priority' => $this->priority,
            'deadline_days' => $this->deadline_days,
            'department' => $this->department,
        ]);

        $this->reset([
            'name', 'description', 'process_code',
            'category', 'priority', 'deadline_days',
            'department', 'active',
        ]);
        $this->active = true;
        $this->priority = 'medium';
        $this->successMessage = 'Proceso creado correctamente.';
    }

    public function render()
    {
        return view('livewire.admin.crear-proceso')
            ->layout('layouts.app');
    }
}
