<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqQuestions.php
 * Created on: 09/12/2025
 * Created by: Codex
 * Approved by: Alfonso Angel GarcÍa Hern·ndez
 * 
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Livewire\Secretary;

use App\Models\Faq;
use App\Models\FaqCategory;
use Livewire\Component;
use Livewire\WithPagination;

class FaqQuestions extends Component
{
    use WithPagination;

    public $categoryId;
    public $category;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    /**

     * Initialize component state.

     *

     * @param mixed $categoryId

     *

     * @return void

     */

    public function mount($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->category = FaqCategory::findOrFail($categoryId);
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
        $query = Faq::where('faq_category_id', $this->categoryId);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('question', 'like', '%' . $this->search . '%')
                  ->orWhere('answer', 'like', '%' . $this->search . '%');
            });
        }

        $faqs = $query->orderBy('order')->paginate(15);

        return view('modules.secretary.faq-questions', [
            'faqs' => $faqs,
        ])->layout('layouts.app');
    }
}
