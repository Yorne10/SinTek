<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocationService.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Services\API\Convocations;

use App\Models\Convocation;
use App\Models\ConvocationDocument;

class ConvocationService
{
    public function index()
    {
        $convocatorias = Convocation::with('documents')
            ->whereIn('status', ['activa', 'proxima', 'permanente'])
            ->orderByRaw("FIELD(status, 'activa', 'permanente', 'proxima')")
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($convocatoria) {
                return [
                    'convocation_id' => $convocatoria->convocation_id,
                    'title' => $convocatoria->title,
                    'description' => $convocatoria->description,
                    'start_date' => $convocatoria->start_date ? $convocatoria->start_date->format('Y-m-d') : null,
                    'end_date' => $convocatoria->end_date ? $convocatoria->end_date->format('Y-m-d') : null,
                    'status' => $convocatoria->status,
                    'status_label' => $this->getStatusLabel($convocatoria->status),
                    'is_permanent' => $convocatoria->end_date === null,
                    'documents' => $convocatoria->documents->map(function ($doc) {
                        return [
                            'document_id' => $doc->convocation_document_id,
                            'title' => $doc->title,
                            'download_url' => route('api.convocation-document.show', $doc->convocation_document_id),
                        ];
                    }),
                    'documents_count' => $convocatoria->documents->count(),
                    'created_at' => $convocatoria->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $convocatorias,
            'count' => $convocatorias->count(),
        ]);
    }

    public function show($id)
    {
        $convocatoria = Convocation::with('documents')->find($id);

        if (!$convocatoria) {
            return response()->json([
                'success' => false,
                'message' => 'Convocatoria no encontrada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'convocation_id' => $convocatoria->convocation_id,
                'title' => $convocatoria->title,
                'description' => $convocatoria->description,
                'start_date' => $convocatoria->start_date ? $convocatoria->start_date->format('Y-m-d') : null,
                'end_date' => $convocatoria->end_date ? $convocatoria->end_date->format('Y-m-d') : null,
                'status' => $convocatoria->status,
                'status_label' => $this->getStatusLabel($convocatoria->status),
                'is_permanent' => $convocatoria->end_date === null,
                'documents' => $convocatoria->documents->map(function ($doc) {
                    return [
                        'document_id' => $doc->convocation_document_id,
                        'title' => $doc->title,
                        'download_url' => route('api.convocation-document.show', $doc->convocation_document_id),
                    ];
                }),
                'documents_count' => $convocatoria->documents->count(),
                'created_at' => $convocatoria->created_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function downloadDocument($id)
    {
        $document = ConvocationDocument::find($id);

        if (!$document) {
            return response()->json([
                'success' => false,
                'message' => 'Documento no encontrado',
            ], 404);
        }

        $base64Content = base64_encode($document->file_content);

        return response()->json([
            'success' => true,
            'data' => [
                'document_id' => $document->convocation_document_id,
                'title' => $document->title,
                'file_content' => $base64Content,
                'mime_type' => 'application/pdf',
                'file_extension' => 'pdf',
            ],
        ]);
    }

    private function getStatusLabel(string $status): string
    {
        $labels = [
            'activa' => 'Vigente',
            'permanente' => 'Permanente',
            'proxima' => 'Próximamente',
            'cerrada' => 'Cerrada',
        ];

        return $labels[$status] ?? ucfirst($status);
    }
}

