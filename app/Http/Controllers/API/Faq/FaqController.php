<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqController.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers\API\Faq;

use App\Http\Controllers\RestfulController;
use App\Services\API\Faq\FaqService;
use Illuminate\Http\Request;

class FaqController extends RestfulController
{
    protected FaqService $faqService;
    /**
     * Create a new instance.
     *
     * @param FaqService $faqService
     */

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }
    /**
     * get Categories.
     */

    public function getCategories()
    {
        return $this->faqService->getCategories();
    }
    /**
     * get All Faqs.
     */

    public function getAllFaqs()
    {
        return $this->faqService->getAllFaqs();
    }
    /**
     * get Faqs By Category.
     *
     * @param int $categoryId
     */

    public function getFaqsByCategory(int $categoryId)
    {
        return $this->faqService->getFaqsByCategory($categoryId);
    }
    /**
     * search Faqs.
     *
     * @param Request $request
     */

    public function searchFaqs(Request $request)
    {
        return $this->faqService->searchFaqs($request);
    }
    /**
     * get Faq By Id.
     *
     * @param int $faqId
     */

    public function getFaqById(int $faqId)
    {
        return $this->faqService->getFaqById($faqId);
    }
}
