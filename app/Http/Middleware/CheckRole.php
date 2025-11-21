<?php
/**
 * Company: CETAM
 * Project: ST
 * File: CheckRole.php
 * Created on: 04/11/2025
 * Created by: Alfonso Angel García Hernández
 * Approved by: Alfonso Angel García Hernández
 *
 * Changelog:
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if authenticated (supports both web and API)
        $user = $request->user();

        if (!$user) {
            // If API request, return JSON response
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated'
                ], 401);
            }
            // Otherwise redirect to login
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login');
        }

        // Check if user has one of the required roles
        if (!in_array($user->role, $roles)) {
            // If API request, return JSON response
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para acceder a esta sección.'
                ], 403);
            }
            // Otherwise abort with 403
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
