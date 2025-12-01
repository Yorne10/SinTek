<?php

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
