<?php
/**
 * Company: CETAM
 * Project: ST
 * File: CallsIndex.php
 * Created on: 04/12/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 */

namespace App\Livewire\Secretary;

use App\Models\Convocation;
use Livewire\Component;
use Livewire\WithPagination;

class CallsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'statusFilter']);
        $this->resetPage();
    }

    public function render()
    {
        $convocations = Convocation::with('documents')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('modules.secretary.calls-index', [
            'convocations' => $convocations,
        ])->layout('layouts.app');
    }
}
