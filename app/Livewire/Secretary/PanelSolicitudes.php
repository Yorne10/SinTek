<?php
/**
 * Company: CETAM
 * Project: ST
 * File: PanelSolicitudes.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 */

namespace App\Livewire\Secretary;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Request;
use Carbon\Carbon;

class PanelSolicitudes extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'statusFilter', 'dateFilter']);
        $this->resetPage();
    }

    public function getStatusCount($status)
    {
        return Request::where('status', $status)->count();
    }

    public function getTodayCount()
    {
        return Request::whereDate('created_at', Carbon::today())->count();
    }

    public function getWeekCount()
    {
        return Request::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    }

    public function render()
    {
        $requests = Request::query()
            ->with(['worker.user', 'process'])
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';
                $query->where(function ($q) use ($search) {
                    $q->where('request_id', 'like', $search)
                      ->orWhereHas('worker.user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', $search);
                      })
                      ->orWhereHas('process', function ($processQuery) use ($search) {
                          $processQuery->where('process_name', 'like', $search);
                      });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->dateFilter, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pendingCount = $this->getStatusCount('pending');
        $inProgressCount = $this->getStatusCount('in_progress');
        $todayCount = $this->getTodayCount();
        $weekCount = $this->getWeekCount();

        return view('livewire.secretary.panel-solicitudes', [
            'requests' => $requests,
            'pendingCount' => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'todayCount' => $todayCount,
            'weekCount' => $weekCount,
        ])->layout('layouts.app');
    }
}
