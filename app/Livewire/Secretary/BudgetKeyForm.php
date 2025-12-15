<?php
/**
 * Company: CETAM
 * Project: ST
 * File: BudgetKeyForm.php
 * Created on: 09/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use Livewire\Component;
use App\Models\Position;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;

class BudgetKeyForm extends Component
{
    public $budget_key_id;
    public $budget_key;
    public $position_name;

    protected $rules = [
        'budget_key' => 'required|string|max:100',
        'position_name' => 'required|string|max:150',
    ];

    protected $messages = [
        'budget_key.required' => 'El campo clave presupuestal es obligatorio',
        'budget_key.max' => 'La clave presupuestal no debe exceder los 100 caracteres',
        'budget_key.unique' => 'La clave presupuestal ya existe',
        'position_name.required' => 'El campo nombre del puesto es obligatorio',
        'position_name.max' => 'El nombre del puesto no debe exceder los 150 caracteres',
    ];

    /**

     * Initialize component state.

     *

     * @param mixed $id

     *

     * @return void

     */

    public function mount($id = null)
    {
        if ($id) {
            $position = Position::findOrFail($id);
            $this->budget_key_id = $id;
            $this->budget_key = $position->budget_key;
            $this->position_name = $position->position_name;
        }
    }

    /**

     * Save the data.

     *

     * @return void

     */

    public function save()
    {
        // Dynamic validations (unique by key)
        $user = Auth::user();

        $isEditing = !empty($this->budget_key_id);

        $uniqueRule = 'unique:positions,budget_key';
        if ($isEditing && $this->budget_key_id) {
            $uniqueRule = $uniqueRule . ',' . $this->budget_key_id . ',positions_id';
        }

        $this->validate([
            'budget_key' => 'required|string|max:100|' . $uniqueRule,
            'position_name' => 'required|string|max:150',
        ], $this->messages);

        // Limit of 10 budget keys per employee (user)
        if (!$isEditing) {
            $existingCount = Position::where('user_id', $user->users_id)->count();
            if ($existingCount >= 10) {
                $this->addError('budget_key', 'Has alcanzado el límite de 10 claves presupuestales.');
                return;
            }
        }

        Position::updateOrCreate(
            ['positions_id' => $this->budget_key_id],
            [
                'budget_key' => $this->budget_key,
                'position_name' => $this->position_name,
            ]
        );

        // Log activity
        $successMessage = '';
        if ($isEditing) {
            ActivityLogger::log(
                'clave.editar',
                "Clave presupuestal editada: '{$this->budget_key}' - {$this->position_name}",
                $user?->users_id
            );
            $successMessage = 'Clave presupuestal actualizada correctamente.';

            // Redirect only if editing
            $redirect = route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys');
            $this->dispatch('budget-key-saved', message: $successMessage, redirect: $redirect);
        } else {
            ActivityLogger::log(
                'clave.crear',
                "Clave presupuestal creada: '{$this->budget_key}' - {$this->position_name}",
                $user?->users_id
            );
            $successMessage = 'Clave presupuestal creada correctamente.';

            // Clear form and stay on the page
            $this->reset(['budget_key', 'position_name']);

            // Show alert without redirect
            $this->dispatch('budget-key-saved', message: $successMessage, redirect: null);
        }
    }

    /**

     * Cancel.

     *

     * @return void

     */

    public function cancel()
    {
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys');
    }

    /**

     * Delete key.

     *

     * @return void

     */

    public function deleteKey()
    {
        if (!$this->budget_key_id) {
            return;
        }

        $user = Auth::user();
        $position = Position::find($this->budget_key_id);

        if ($position) {
            $budgetKey = $position->budget_key;
            $positionName = $position->position_name;

            $position->delete();

            ActivityLogger::log(
                'clave.eliminar',
                "Clave presupuestal eliminada: '{$budgetKey}' - {$positionName}",
                $user?->users_id
            );

            $redirect = route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys');
            $this->dispatch('budget-key-saved', message: 'Clave presupuestal eliminada correctamente.', redirect: $redirect);
        }
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        return view('modules.secretary.budget-key-form')
            ->layout('layouts.app');
    }
}
