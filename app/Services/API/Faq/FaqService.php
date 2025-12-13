<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqService.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Services\API\Faq;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqService
{
    public function getCategories(): JsonResponse
    {
        try {
            $categories = FaqCategory::active()
                ->with(['activeFaqs' => function ($query) {
                    $query->orderBy('order');
                }])
                ->ordered()
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->faq_category_id,
                        'name' => $category->name,
                        'description' => $category->description,
                        'order' => $category->order,
                        'faqs_count' => $category->activeFaqs->count(),
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'Categorías obtenidas exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las categorías.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllFaqs(): JsonResponse
    {
        try {
            $categories = FaqCategory::active()
                ->with(['activeFaqs' => function ($query) {
                    $query->orderBy('order');
                }])
                ->ordered()
                ->get()
                ->map(function ($category) {
                    return [
                        'category_id' => $category->faq_category_id,
                        'category_name' => $category->name,
                        'category_description' => $category->description,
                        'category_order' => $category->order,
                        'faqs' => $category->activeFaqs->map(function ($faq) {
                            return [
                                'id' => $faq->faq_id,
                                'question' => $faq->question,
                                'answer' => $faq->answer,
                                'order' => $faq->order,
                            ];
                        })
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'FAQs obtenidas exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las FAQs.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getFaqsByCategory(int $categoryId): JsonResponse
    {
        try {
            $category = FaqCategory::active()
                ->with(['activeFaqs' => function ($query) {
                    $query->orderBy('order');
                }])
                ->findOrFail($categoryId);

            $faqs = $category->activeFaqs->map(function ($faq) use ($category) {
                return [
                    'id' => $faq->faq_id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                    'order' => $faq->order,
                    'category' => [
                        'id' => $category->faq_category_id,
                        'name' => $category->name,
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'category' => [
                        'id' => $category->faq_category_id,
                        'name' => $category->name,
                        'description' => $category->description,
                        'order' => $category->order,
                    ],
                    'faqs' => $faqs,
                ],
                'message' => 'FAQs por categoría obtenidas exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener FAQs por categoría.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchFaqs(Request $request): JsonResponse
    {
        try {
            $keyword = $request->get('keyword');

            if (!$keyword) {
                return response()->json([
                    'success' => false,
                    'message' => 'El parámetro "keyword" es requerido.'
                ], 400);
            }

            $faqs = Faq::active()
                ->with('category')
                ->where(function ($query) use ($keyword) {
                    $query->where('question', 'like', '%' . $keyword . '%')
                          ->orWhere('answer', 'like', '%' . $keyword . '%');
                })
                ->ordered()
                ->get()
                ->map(function ($faq) {
                    return [
                        'id' => $faq->faq_id,
                        'category' => [
                            'id' => $faq->category->faq_category_id ?? null,
                            'name' => $faq->category->name ?? 'Sin categoría',
                        ],
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'order' => $faq->order,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $faqs,
                'count' => $faqs->count(),
                'message' => 'Búsqueda completada exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar FAQs.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getFaqById(int $faqId): JsonResponse
    {
        try {
            $faq = Faq::active()
                ->with('category')
                ->findOrFail($faqId);

            $data = [
                'id' => $faq->faq_id,
                'category' => [
                    'id' => $faq->category->faq_category_id ?? null,
                    'name' => $faq->category->name ?? 'Sin categoría',
                ],
                'question' => $faq->question,
                'answer' => $faq->answer,
                'order' => $faq->order,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'FAQ obtenida exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'FAQ no encontrada.',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
