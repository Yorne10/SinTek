<?php

if (!function_exists('icon')) {
    /**
     * Get icon class from config
     *
     * @param string $name Icon name from config/icons.php (e.g., 'nav.home', 'user.profile')
     * @param string $additionalClasses Additional CSS classes to add
     * @return string Font Awesome icon classes
     */
    function icon(string $name, string $additionalClasses = ''): string
    {
        // Try config helper first
        $iconClass = config("icons.{$name}");

        // Fallback: load icons config manually in case cache/config helper misses it
        if (!$iconClass && file_exists(config_path('icons.php'))) {
            $icons = include config_path('icons.php');
            if (is_array($icons)) {
                $iconClass = $icons[$name] ?? null;
            }
        }

        // Final fallback
        if (!$iconClass) {
            $iconClass = 'fa-solid fa-circle-question';
        }

        return trim("{$iconClass} {$additionalClasses}");
    }
}
