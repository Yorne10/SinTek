<?php
/**
 * Company: CETAM
 * Project: ST
 * File: InstitutionalDocumentService.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Services\Documents;

use App\Models\InstitutionalDocument;

class InstitutionalDocumentService
{
    public function show($id)
    {
        $document = InstitutionalDocument::findOrFail($id);

        return response($document->file_content)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $document->file_name . '"');
    }

    public function download($id)
    {
        $document = InstitutionalDocument::findOrFail($id);

        return response($document->file_content)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $document->file_name . '"')
            ->header('Content-Length', strlen($document->file_content));
    }
}
