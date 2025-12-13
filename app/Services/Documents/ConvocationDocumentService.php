<?php

namespace App\Services\Documents;

use App\Models\ConvocationDocument;

class ConvocationDocumentService
{
    public function show($id)
    {
        $document = ConvocationDocument::findOrFail($id);

        // Asegurar que el nombre del archivo siempre termine en .pdf
        $filename = $document->file_name ?: $document->title;

        // Remover extensión existente si la hay
        $filename = preg_replace('/\.[^.]+$/', '', $filename);

        // Agregar extensión .pdf
        $filename = $filename . '.pdf';

        return response($document->file_content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }

    public function download($id)
    {
        $document = ConvocationDocument::findOrFail($id);

        // Asegurar que el nombre del archivo siempre termine en .pdf
        $filename = $document->file_name ?: $document->title;

        // Remover extensión existente si la hay
        $filename = preg_replace('/\.[^.]+$/', '', $filename);

        // Agregar extensión .pdf
        $filename = $filename . '.pdf';

        return response($document->file_content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
