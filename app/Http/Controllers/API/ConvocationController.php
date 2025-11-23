<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Convocation;
use App\Models\ConvocationDocument;
use Illuminate\Http\Request;

class ConvocationController extends Controller
{
    /**
     * Obtener todas las convocatorias activas
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Obtener una convocatoria específica
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Obtener el label del estado
     *
     * @param string $status
     * @return string
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'activa' => 'Vigente',
            'permanente' => 'Permanente',
            'proxima' => 'Próximamente',
            'cerrada' => 'Cerrada',
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    /**
     * Descargar documento de convocatoria (PDF en Base64)
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadDocument($id)
    {
        $document = ConvocationDocument::find($id);

        if (!$document) {
            return response()->json([
                'success' => false,
                'message' => 'Documento no encontrado',
            ], 404);
        }

        // Convertir el contenido binario a Base64 para enviarlo por JSON
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
}
