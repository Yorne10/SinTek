<?php
/**
 * Company: CETAM
 * Project: ST
 * File: BudgetKeys.php
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
use Livewire\WithPagination;
use App\Models\Position;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;

class BudgetKeys extends Component
{
    use WithPagination;

    public $search = '';

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
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-key.create');
    }

    public function edit($id)
    {
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.secretary.budget-key.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        $user = Auth::user();
        $position = Position::find($id);

        if ($position) {
            $budgetKey = $position->budget_key;
            $positionName = $position->position_name;

            $position->delete();

            ActivityLogger::log(
                'clave.eliminar',
                "Clave presupuestal eliminada: '{$budgetKey}' - {$positionName}",
                $user?->users_id
            );

            session()->flash('message', 'Clave Presupuestal eliminada correctamente.');
        }
    }
}
