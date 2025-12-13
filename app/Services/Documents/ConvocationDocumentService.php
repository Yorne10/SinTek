<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocationDocumentService.php
 * Created on: 12/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Services\Documents;

use App\Models\ConvocationDocument;

class ConvocationDocumentService
{
    /**
     * Display the specified resource.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**

     * Download.

     *

     * @param mixed $id

     *

     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse

     */

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
