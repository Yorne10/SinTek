<?php

namespace App\Services\Documents;

use App\Models\ConvocationDocument;

class ConvocationDocumentService
{
    public function show($id)
    {
        $document = ConvocationDocument::findOrFail($id);

        $filename = $document->file_name ?: ($document->title . '.pdf');
        $mime = $document->mime_type ?: 'application/pdf';

        return response($document->file_content)
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }

    public function download($id)
    {
        $document = ConvocationDocument::findOrFail($id);

        $filename = $document->file_name ?: ($document->title . '.pdf');
        $mime = $document->mime_type ?: 'application/pdf';

        return response($document->file_content)
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
