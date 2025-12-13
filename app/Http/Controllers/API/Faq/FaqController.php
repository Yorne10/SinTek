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

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function getCategories()
    {
        return $this->faqService->getCategories();
    }

    public function getAllFaqs()
    {
        return $this->faqService->getAllFaqs();
    }

    public function getFaqsByCategory(int $categoryId)
    {
        return $this->faqService->getFaqsByCategory($categoryId);
    }

    public function searchFaqs(Request $request)
    {
        return $this->faqService->searchFaqs($request);
    }

    public function getFaqById(int $faqId)
    {
        return $this->faqService->getFaqById($faqId);
    }
}
