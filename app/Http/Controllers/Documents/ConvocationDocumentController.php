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

    public function __construct(ConvocationDocumentService $convocationDocumentService)
    {
        $this->convocationDocumentService = $convocationDocumentService;
    }

    public function show(Request $request, $id)
    {
        return $this->convocationDocumentService->show($id);
    }

    public function download($id)
    {
        return $this->convocationDocumentService->download($id);
    }
}
