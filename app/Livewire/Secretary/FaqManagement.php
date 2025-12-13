<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqManagement.php
 * Created on: 24/11/2025
 * Created by: Codex
 * Approved by: Alfonso Angel GarcÍa Hernández
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use App\Models\FaqCategory;
use Livewire\Component;
use Livewire\WithPagination;

class FaqManagement extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected function normalizeOrder(): void
    {
        $categories = FaqCategory::orderBy('order')->orderBy('faq_category_id')->get();
        $order = 1;
        foreach ($categories as $cat) {
            $cat->order = $order++;
            $cat->save();
        }
    }

    /**

     * Move up.

     *

     * @param mixed $categoryId

     *

     * @return void

     */

    public function moveUp($categoryId)
    {
        $this->moveCategory($categoryId, 'up');
    }

    /**

     * Move down.

     *

     * @param mixed $categoryId

     *

     * @return void

     */

    public function moveDown($categoryId)
    {
        $this->moveCategory($categoryId, 'down');
    }

    protected function moveCategory($categoryId, $direction = 'up')
    {
        try {
            $this->normalizeOrder();

            $category = FaqCategory::findOrFail($categoryId);
            if ($direction === 'up') {
                $target = FaqCategory::where('order', '<', $category->order)
                    ->orderBy('order', 'desc')
                    ->first();
            } else {
                $target = FaqCategory::where('order', '>', $category->order)
                    ->orderBy('order', 'asc')
                    ->first();
            }

            if (!$target) {
                return;
            }

            [$category->order, $target->order] = [$target->order, $category->order];
            $category->save();
            $target->save();

            $this->dispatch('faq-notify', type: 'success', title: 'Orden actualizado', message: 'La categorÍa ha sido reordenada.');
        } catch (\Exception $e) {
            $this->dispatch('faq-notify', type: 'error', title: 'Error', message: 'No se pudo reordenar la categorÍa.');
        }
    }

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

     * Clear filters.

     *

     * @return void

     */

    public function clearFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    /**

     * Render the component view.

     *

     * @return \Illuminate\View\View

     */

    public function render()
    {
        $query = FaqCategory::withCount('faqs');

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $categories = $query->orderBy('order')->paginate(10);

        return view('modules.secretary.faq-management', [
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
