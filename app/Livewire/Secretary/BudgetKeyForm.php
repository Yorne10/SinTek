<?php

namespace App\Livewire\Secretary;

use Livewire\Component;
use App\Models\Position;

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

        Position::updateOrCreate(
            ['positions_id' => $this->budget_key_id],
            [
                'budget_key' => $this->budget_key,
                'position_name' => $this->position_name,
            ]
        );

        session()->flash('success', $this->budget_key_id ? 'Clave presupuestal actualizada correctamente.' : 'Clave presupuestal creada correctamente.');

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys');
    }

    public function cancel()
    {
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-keys');
    }

    public function render()
    {
        return view('modules.secretary.budget-key-form')
            ->layout('layouts.app');
    }
}
