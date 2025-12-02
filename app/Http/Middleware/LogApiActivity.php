<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;

class LogApiActivity
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()?->getName() ?? '';
        if (str_contains($routeName, 'login') || str_contains($routeName, 'logout')) {
            return $next($request);
        }

        $response = $next($request);

        // Solo registramos si el controlador/servicio envió acción y descripción explícitas
        $user = $request->user();
        $action = $request->attributes->get('log_action');
        $description = $request->attributes->get('log_description');

        if ($user && $action && $description) {
            ActivityLogger::log($action, $description, $user->users_id);
        }

        return $response;
    }
}
