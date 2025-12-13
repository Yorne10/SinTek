<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocationDocumentController.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\RestfulController;
use App\Services\Documents\ConvocationDocumentService;

use Illuminate\Http\Request;

class ConvocationDocumentController extends RestfulController
{
    protected ConvocationDocumentService $convocationDocumentService;

    /**

     * Create a new instance.

     *

     * @param ConvocationDocumentService $convocationDocumentService

     */

    public function __construct(ConvocationDocumentService $convocationDocumentService)
    {
        $this->convocationDocumentService = $convocationDocumentService;
    }

    /**

     * Display the specified resource.

     *

     * @param Request $request

     * @param mixed $id

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function show(Request $request, $id)
    {
        return $this->convocationDocumentService->show($id);
    }

    /**

     * Download.

     *

     * @param mixed $id

     *

     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse

     */

    public function download($id)
    {
        return $this->convocationDocumentService->download($id);
    }
}
