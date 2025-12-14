<?php
/**
 * Company: CETAM
 * Project: ST
 * File: EnsureWorkerAcceptedPrivacy.php
 * Created on: 13/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureWorkerAcceptedPrivacy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user not authenticated, continue
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Only apply to workers
        if ($user->role !== 'worker') {
            return $next($request);
        }

        $worker = $user->worker;

        // If no worker record or already accepted, continue
        if (!$worker || $worker->privacy_accepted_at) {
            return $next($request);
        }

        // If on privacy terms page, allow
        $routeName = $request->route()?->getName();
        $prefix = config('proj.route_name_prefix', 'proj');
        if ($routeName === $prefix . '.worker.privacy-terms') {
            return $next($request);
        }

        // Redirect to privacy terms
        return redirect()->route($prefix . '.worker.privacy-terms');
    }
}
