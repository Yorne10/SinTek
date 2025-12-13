<?php
/**
 * Company: CETAM
 * Project: ST
 * File: proj.php
 * Created on: 02/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

return [
    // Slug configurable del proyecto para prefijar rutas: /p/<slug>
    // Personaliza vía entorno con CETAM_PROJ_SLUG
    'slug' => env('CETAM_PROJ_SLUG', 'sintek'),

    // (Opcional) Prefijo base para nombres de ruta, por convención 'proj'
    'route_name_prefix' => env('CETAM_PROJ_ROUTE_NAME_PREFIX', 'sintek'),
];
