<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;

class LogApiActivity
{
    /**
     * Registra acciones de usuarios móviles (API) sin exponer IP ni endpoint.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $user = $request->user();
        if ($user) {
            $route = $request->route();
            $routeName = $route?->getName();
            $actionMethod = $route?->getActionMethod();

            $action = $routeName
                ? "api.{$routeName}"
                : ($actionMethod ? "api.{$actionMethod}" : 'api.action');

            $description = "Acción desde app móvil: {$action}";

            ActivityLogger::log($action, $description, $user->users_id);
        }

        return $response;
    }
}
