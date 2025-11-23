<?php

namespace App\Http\Controllers;

use App\Models\ConvocationDocument;
use Illuminate\Http\Request;

class ConvocationDocumentController extends Controller
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
