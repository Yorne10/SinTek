<?php
/**
 * Company: CETAM
 * Project: ST
 * File: BusquedaTrabajadores.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 */

namespace App\Livewire\Secretary;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Worker;
use App\Models\User;

class BusquedaTrabajadores extends Component
{
    use WithPagination;

    public $search = '';
    public $searchCurp = '';
    public $searchRfc = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSearchCurp()
    {
        $this->resetPage();
    }

    public function updatingSearchRfc()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'searchCurp', 'searchRfc', 'statusFilter']);
        $this->resetPage();
    }

    public function render()
    {
        $workers = Worker::query()
            ->with(['user', 'positions'])
            ->whereHas('user', function ($query) {
                $query->where('role', 'worker');
            })
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                      ->orWhere('email', 'like', $search);
                });
            })
            ->when($this->searchCurp, function ($query) {
                $query->where('curp', 'like', '%' . $this->searchCurp . '%');
            })
            ->when($this->searchRfc, function ($query) {
                $query->where('rfc', 'like', '%' . $this->searchRfc . '%');
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'active') {
                    $query->whereHas('user', function ($q) {
                        $q->where('is_active', 1);
                    });
                } elseif ($this->statusFilter === 'inactive') {
                    $query->whereHas('user', function ($q) {
                        $q->where('is_active', 0);
                    });
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.secretary.busqueda-trabajadores', [
            'workers' => $workers
        ])->layout('layouts.app');
    }
}
