<?php
/**
 * Company: CETAM
 * Project: ST
 * File: StepProvidedDocumentController.php
 * Created on: 14/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace App\Http\Controllers;

use App\Models\StepProvidedDocument;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StepProvidedDocumentController extends Controller
{
    /**
     * Show the document in browser.
     */
    public function show($documentId)
    {
        $document = StepProvidedDocument::findOrFail($documentId);

        return response($document->file_content)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $document->name . '"');
    }

    /**
     * Download the document.
     */
    public function download($documentId)
    {
        $document = StepProvidedDocument::findOrFail($documentId);

        return response($document->file_content)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $document->name . '"');
    }
}
