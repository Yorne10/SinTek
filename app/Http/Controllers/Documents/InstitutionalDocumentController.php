<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\RestfulController;
use App\Services\Documents\InstitutionalDocumentService;

use Illuminate\Http\Request;

class InstitutionalDocumentController extends RestfulController
{
    protected InstitutionalDocumentService $institutionalDocumentService;

    public function __construct(InstitutionalDocumentService $institutionalDocumentService)
    {
        $this->institutionalDocumentService = $institutionalDocumentService;
    }

    public function show(Request $request, $id)
    {
        return $this->institutionalDocumentService->show($id);
    }

    public function download($id)
    {
        return $this->institutionalDocumentService->download($id);
    }
}
