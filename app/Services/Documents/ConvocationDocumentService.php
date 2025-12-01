<?php

namespace App\Services\Documents;

use App\Models\ConvocationDocument;

class ConvocationDocumentService
{
    public function show($id)
    {
        $document = ConvocationDocument::findOrFail($id);

        return response($document->file_content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $document->title . '.pdf"');
    }

    public function download($id)
    {
        $document = ConvocationDocument::findOrFail($id);

        return response($document->file_content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $document->title . '.pdf"');
    }
}
