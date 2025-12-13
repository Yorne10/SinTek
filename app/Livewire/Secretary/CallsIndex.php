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

    /**

     * Updating search.

     *

     * @return void

     */

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**

     * Updating status filter.

     *

     * @return void

     */

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    /**

     * Clear filters.

     *

     * @return void

     */

    public function clearFilters()
    {
        $this->reset(['search', 'statusFilter']);
        $this->resetPage();
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

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
