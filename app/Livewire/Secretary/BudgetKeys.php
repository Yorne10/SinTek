<?php

namespace App\Livewire\Secretary;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Position;

class BudgetKeys extends Component
{
    use WithPagination;

    public $search = '';
    public $budget_key;
    public $position_name;
    public $selected_id;
    public $isOpen = false;

    protected $rules = [
        'budget_key' => 'required|string|max:100',
        'position_name' => 'required|string|max:150',
    ];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $positions = Position::where('budget_key', 'like', '%' . $this->search . '%')
            ->orWhere('position_name', 'like', '%' . $this->search . '%')
            ->orderBy('positions_id', 'desc')
            ->paginate(10);

        return view('livewire.secretary.budget-keys', compact('positions'))
            ->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->budget_key = '';
        $this->position_name = '';
        $this->selected_id = null;
    }

    public function store()
    {
        $this->validate();

        Position::updateOrCreate(['positions_id' => $this->selected_id], [
            'budget_key' => $this->budget_key,
            'position_name' => $this->position_name,
        ]);

        session()->flash('message', $this->selected_id ? 'Clave Presupuestal actualizada correctamente.' : 'Clave Presupuestal creada correctamente.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $position = Position::findOrFail($id);
        $this->selected_id = $id;
        $this->budget_key = $position->budget_key;
        $this->position_name = $position->position_name;

        $this->openModal();
    }

    public function delete($id)
    {
        Position::find($id)->delete();
        session()->flash('message', 'Clave Presupuestal eliminada correctamente.');
    }
}
