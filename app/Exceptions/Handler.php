<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Handler.php
 * Created on: 14/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle invalid CSRF token (session expired)
        $this->renderable(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sesión expirada'], 419);
            }
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired');
        });

        // Handle method not allowed errors (e.g., GET on POST route)
        // This should NOT show "session expired" because the session may still be active
        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Método no permitido'], 405);
            }
            // Redirect to dashboard if authenticated, or to login if not
            if (auth()->check()) {
                return redirect()->route(config('proj.route_name_prefix', 'proj') . '.dashboard.index');
            }
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login');
        });

        // Handle authentication failure (unauthenticated user)
        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No autenticado'], 401);
            }
            // If coming from an Ajax/Livewire request, redirect to session expired
            if ($request->ajax() || $request->wantsJson() || $request->is('livewire/*')) {
                return redirect()->route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired');
            }
            // If it is a normal request, redirect to login
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login');
        });

        // Handle database connection errors
        $this->renderable(function (\Illuminate\Database\QueryException $e, $request) {
            // Only treat as connection error if it is REALLY a critical connection error
            if ($this->isCriticalDatabaseError($e)) {
                $errorMessage = 'No se pudo establecer conexión con la base de datos. Por favor, intenta nuevamente.';

                // For Livewire/AJAX requests
                if ($request->expectsJson() || $request->is('livewire/*') || $request->header('X-Livewire')) {
                    // Instead of pure JSON, redirect to an error page
                    return response()->view('errors.database-error', [
                        'message' => $errorMessage,
                        'redirectUrl' => route(config('proj.route_name_prefix', 'proj') . '.auth.login')
                    ], 503);
                }

                // For normal requests
                return response()->view('errors.database-error', [
                    'message' => $errorMessage,
                    'redirectUrl' => route(config('proj.route_name_prefix', 'proj') . '.auth.login')
                ], 503);
            }
            // If not a critical error, let Laravel handle it normally
        });

        // Handle PDO errors (connection failed at lower level)
        $this->renderable(function (\PDOException $e, $request) {
            $errorMessage = 'No se pudo establecer conexión con la base de datos. Por favor, intenta nuevamente.';

            // For Livewire/AJAX or normal requests, show error view
            return response()->view('errors.database-error', [
                'message' => $errorMessage,
                'redirectUrl' => route(config('proj.route_name_prefix', 'proj') . '.auth.login')
            ], 503);
        });
    }

    /**
     * Determine if the exception is a CRITICAL database connection error.
     * Only returns true for real connection errors, not for normal query errors.
     *
     * @param \Illuminate\Database\QueryException $e
     * @return bool
     */
    protected function isCriticalDatabaseError(\Illuminate\Database\QueryException $e): bool
    {
        // Error codes indicating CRITICAL connection problems
        $criticalErrorCodes = [
            2002, // Connection refused (MySQL)
            2003, // Can't connect to MySQL server
            2006, // MySQL server has gone away
            2013, // Lost connection to MySQL server during query
            1040, // Too many connections
        ];

        $previousException = $e->getPrevious();
        if ($previousException instanceof \PDOException) {
            $errorCode = $previousException->getCode();

            // Only consider critical error if the code matches exactly
            if (in_array((int) $errorCode, $criticalErrorCodes, true)) {
                return true;
            }

            // Check specific keywords indicating connection loss
            $message = strtolower($previousException->getMessage());
            $criticalKeywords = ['connection refused', 'can\'t connect', 'server has gone away', 'lost connection'];

            foreach ($criticalKeywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return true;
                }
            }
        }

        return false;
    }
}
