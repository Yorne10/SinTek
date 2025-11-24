<?php

namespace App\Http\Controllers;

use App\Models\InstitutionalDocument;
use Illuminate\Http\Request;

class InstitutionalDocumentController extends Controller
{
    /**
     * Mostrar el documento en el navegador
     */
    public function show($id)
    {
        $document = InstitutionalDocument::findOrFail($id);

        return response($document->file_content)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $document->file_name . '"');
    }

    /**
     * Descargar el documento
     */
    public function download($id)
    {
        $document = InstitutionalDocument::findOrFail($id);

        return response($document->file_content)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $document->file_name . '"')
            ->header('Content-Length', strlen($document->file_content));
    }
}
