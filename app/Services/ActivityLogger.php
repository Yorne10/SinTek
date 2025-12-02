<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Registra una accion en la bitacora.
     */
    public static function log(string $action, string $description, ?int $userId = null): void
    {
        Log::create([
            'user_id' => $userId ?? Auth::id(),
            'action' => $action,
            'description' => $description,
            'date' => now(),
        ]);
    }

    /**
     * Obtiene una etiqueta legible para una accion.
     */
    public static function getActionLabel(string $action): string
    {
        $actions = [
            // Worker actions
            'tramite.iniciar' => 'Iniciar tramite',
            'tramite.paso.completado' => 'Completar paso',
            'tramite.completado' => 'Completar tramite',
            'tramite.decision' => 'Registrar decision',
            'tramite.documento.subido' => 'Subir documento',
            'notificacion.marcar_leida' => 'Marcar notificacion como leida',
            'notificacion.leida' => 'Marcar notificacion como leida',

            // Secretary actions
            'convocatoria.creada' => 'Crear convocatoria',
            'convocatoria.editada' => 'Editar convocatoria',
            'convocatoria.eliminada' => 'Eliminar convocatoria',
            'convocatoria.publicada' => 'Publicar convocatoria',
            'notificacion.crear' => 'Crear notificacion',
            'notificaciones.enviadas' => 'Enviar notificaciones',
            'faq.crear' => 'Crear pregunta frecuente',
            'faq.editar' => 'Editar pregunta frecuente',
            'faq.eliminar' => 'Eliminar pregunta frecuente',
            'faq.publicar' => 'Publicar pregunta frecuente',
            'faq.categoria.crear' => 'Crear categoria FAQ',
            'faq.categoria.editar' => 'Editar categoria FAQ',
            'faq.categoria.eliminar' => 'Eliminar categoria FAQ',
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
            'api.login' => 'Inicio de sesion (API)',
            'api.profile' => 'Consultar perfil (API)',
            'api.convocations' => 'Consultar convocatorias (API)',
            'api.processes' => 'Consultar procesos (API)',
        ];

        return $actions[$action] ?? $action;
    }
}
