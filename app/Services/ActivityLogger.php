<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ActivityLogger.php
 * Created on: 12/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

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
            // Worker actions - Web y API
            'tramite.iniciar' => 'Iniciar trámite',
            'tramite.paso.completado' => 'Completar paso de trámite',
            'tramite.completado' => 'Completar trámite',
            'tramite.decision' => 'Registrar decisión en trámite',
            'tramite.documento.subido' => 'Subir documento a trámite',
            'notificacion.marcar_leida' => 'Marcar notificación como leída',
            'notificacion.leida' => 'Marcar notificación como leída',

            // Secretary actions - Convocatorias
            'convocatoria.crear' => 'Crear convocatoria',
            'convocatoria.editar' => 'Editar convocatoria',
            'convocatoria.eliminar' => 'Eliminar convocatoria',
            'convocatoria.publicar' => 'Publicar convocatoria',

            // Secretary actions - Documentos institucionales
            'documento.crear' => 'Crear documento institucional',
            'documento.editar' => 'Editar documento institucional',
            'documento.eliminar' => 'Eliminar documento institucional',
            'documento.archivar' => 'Archivar documento institucional',

            // Secretary actions - Claves presupuestales
            'clave.crear' => 'Crear clave presupuestal',
            'clave.editar' => 'Editar clave presupuestal',
            'clave.eliminar' => 'Eliminar clave presupuestal',

            // Secretary actions - Notificaciones y FAQs
            'notificacion.crear' => 'Crear notificación',
            'notificaciones.enviar' => 'Enviar notificaciones',
            'faq.crear' => 'Crear pregunta frecuente',
            'faq.editar' => 'Editar pregunta frecuente',
            'faq.eliminar' => 'Eliminar pregunta frecuente',
            'faq.publicar' => 'Publicar pregunta frecuente',
            'faq.categoria.crear' => 'Crear categoría de FAQ',
            'faq.categoria.editar' => 'Editar categoría de FAQ',
            'faq.categoria.eliminar' => 'Eliminar categoría de FAQ',

            // Admin actions - Procesos
            'proceso.crear' => 'Crear proceso',
            'proceso.editar' => 'Editar proceso',
            'proceso.eliminar' => 'Eliminar proceso',
            'proceso.activar' => 'Activar proceso',
            'proceso.desactivar' => 'Desactivar proceso',

            // Admin actions - Pasos
            'paso.crear' => 'Crear paso',
            'paso.editar' => 'Editar paso',
            'paso.eliminar' => 'Eliminar paso',
            'paso.asignar' => 'Asignar paso a proceso',

            // API actions (compatibilidad)
            'api.login' => 'Inicio de sesión (API)',
            'api.profile' => 'Consultar perfil (API)',
            'api.convocations' => 'Consultar convocatorias (API)',
            'api.processes' => 'Consultar procesos (API)',
        ];

        return $actions[$action] ?? $action;
    }
}
