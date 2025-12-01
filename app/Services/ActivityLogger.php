<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Registra una acción en la bitácora.
     */
    public static function log(string $action, string $description, ?int $userId = null): void
    {
        // Asegurar que las cadenas estén en UTF-8
        $action = mb_convert_encoding($action, 'UTF-8', 'UTF-8');
        $description = mb_convert_encoding($description, 'UTF-8', 'UTF-8');

        Log::create([
            'user_id' => $userId ?? Auth::id(),
            'action' => $action,
            'description' => $description,
            'date' => now(),
        ]);
    }

    /**
     * Obtiene una etiqueta legible para una acción.
     */
    public static function getActionLabel(string $action): string
    {
        $actions = [
            // Worker actions
            'tramite.iniciar' => 'Iniciar trámite',
            'tramite.paso.completar' => 'Completar paso',
            'tramite.completado' => 'Completar trámite',
            'tramite.decision' => 'Registrar decisión',
            'tramite.documento.subir' => 'Subir documento',
            'tramite.documento.actualizar' => 'Actualizar documento',
            'notificacion.marcar_leida' => 'Marcar notificación como leída',
            'notificacion.leida' => 'Marcar notificación como leída',

            // Secretary actions
            'convocatoria.creada' => 'Crear convocatoria',
            'convocatoria.editada' => 'Editar convocatoria',
            'convocatoria.eliminada' => 'Eliminar convocatoria',
            'convocatoria.publicada' => 'Publicar convocatoria',
            'notificacion.crear' => 'Crear notificación',
            'notificaciones.enviadas' => 'Enviar notificaciones',
            'faq.crear' => 'Crear pregunta frecuente',
            'faq.editar' => 'Editar pregunta frecuente',
            'faq.eliminar' => 'Eliminar pregunta frecuente',
            'faq.publicar' => 'Publicar pregunta frecuente',
            'faq.categoria.crear' => 'Crear categoría FAQ',
            'faq.categoria.editar' => 'Editar categoría FAQ',
            'faq.categoria.eliminar' => 'Eliminar categoría FAQ',
            'documento.institucional.crear' => 'Crear documento institucional',
            'documento.institucional.archivar' => 'Archivar documento institucional',

            // Admin actions
            'proceso.crear' => 'Crear proceso',
            'proceso.creado' => 'Crear proceso',
            'paso.crear' => 'Crear paso',
            'paso.editar' => 'Editar paso',
            'paso.eliminar' => 'Eliminar paso',
            'paso.asignar' => 'Asignar paso a proceso',
            'paso.creado' => 'Crear paso',
            'paso.actualizado' => 'Actualizar paso',

            // API actions
            'api.login' => 'Inicio de sesión (API)',
            'api.profile' => 'Consultar perfil (API)',
            'api.convocations' => 'Consultar convocatorias (API)',
            'api.processes' => 'Consultar procesos (API)',
        ];

        $label = $actions[$action] ?? $action;

        // Ensure the returned label is valid UTF-8
        return mb_convert_encoding($label, 'UTF-8', 'UTF-8');
    }
}
