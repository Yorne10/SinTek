<?php

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

    public function mount($id = null)
    {
        if ($id) {
            $position = Position::findOrFail($id);
            $this->budget_key_id = $id;
            $this->budget_key = $position->budget_key;
            $this->position_name = $position->position_name;
        }
    }

    public function save()
    {
        $this->validate();
        $user = Auth::user();

        $isEditing = !empty($this->budget_key_id);

        Position::updateOrCreate(
            ['positions_id' => $this->budget_key_id],
            [
                'budget_key' => $this->budget_key,
                'position_name' => $this->position_name,
            ]
        );

        // Registrar en bitácora
        if ($isEditing) {
            ActivityLogger::log(
                'clave.editar',
                "Clave presupuestal editada: '{$this->budget_key}' - {$this->position_name}",
                $user?->users_id
            );
            session()->flash('success', 'Clave presupuestal actualizada correctamente.');
        } else {
            ActivityLogger::log(
                'clave.crear',
                "Clave presupuestal creada: '{$this->budget_key}' - {$this->position_name}",
                $user?->users_id
            );
            session()->flash('success', 'Clave presupuestal creada correctamente.');
        }

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys');
    }

    public function cancel()
    {
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys');
    }

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

            session()->flash('success', 'Clave presupuestal eliminada correctamente.');
        }

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys');
    }

    public function render()
    {
        return view('modules.secretary.budget-key-form')
            ->layout('layouts.app');
    }
}
