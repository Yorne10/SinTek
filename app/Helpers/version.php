<?php
/**
 * Company: CETAM
 * Project: ST
 * File: version.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

if (!function_exists('app_version')) {
    /**
     * Get the application version.
     *
     * @return string
     */
    function app_version(): string
    {
        return config('app.version', '1.0.0');
    }
}

if (!function_exists('version_badge')) {
    /**
     * Get HTML badge with application version.
     *
     * @return string
     */
    function version_badge(): string
    {
        $version = app_version();
        return '<span class="badge bg-secondary">v' . $version . '</span>';
    }
}
