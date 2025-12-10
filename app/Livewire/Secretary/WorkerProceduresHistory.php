<?php

namespace App\Livewire\Secretary;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Worker;
use App\Models\Request;

class WorkerProceduresHistory extends Component
{
    use WithPagination;

    public $workerId;
    public $worker;
    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->workerId = $id;
        $this->worker = Worker::with('user')->findOrFail($id);
    }

    public function render()
    {
        $query = Request::with(['process'])
            ->where('worker_id', $this->workerId);

        if ($this->search) {
            $query->whereHas('process', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('modules.secretary.worker-procedures-history', [
            'requests' => $requests,
        ])->layout('layouts.app');
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->resetPage();
    }
}
