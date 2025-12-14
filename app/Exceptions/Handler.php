<?php

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

        // Manejo de CSRF token inválido (sesión expirada)
        $this->renderable(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sesión expirada'], 419);
            }
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired');
        });

        // Manejo de errores de método no permitido
        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Método no permitido'], 405);
            }
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired');
        });

        // Manejo de autenticación fallida (usuario no autenticado)
        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No autenticado'], 401);
            }
            // If viene de una petición Ajax/Livewire, redirigir a sesión expirada
            if ($request->ajax() || $request->wantsJson() || $request->is('livewire/*')) {
                return redirect()->route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired');
            }
            // If it is una petición normal, redirigir al login
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login');
        });

        // Manejo de errores de conexión con la base de datos
        $this->renderable(function (\Illuminate\Database\QueryException $e, $request) {
            // Solo tratar como error de conexión si REALMENTE es un error de conexión crítico
            if ($this->isCriticalDatabaseError($e)) {
                $errorMessage = 'No se pudo establecer conexión con la base de datos. Por favor, intenta nuevamente.';

                // Para peticiones Livewire/AJAX
                if ($request->expectsJson() || $request->is('livewire/*') || $request->header('X-Livewire')) {
                    // En lugar de JSON puro, redirigir a una página de error
                    return response()->view('errors.database-error', [
                        'message' => $errorMessage,
                        'redirectUrl' => route(config('proj.route_name_prefix', 'proj') . '.auth.login')
                    ], 503);
                }

                // Para peticiones normales
                return response()->view('errors.database-error', [
                    'message' => $errorMessage,
                    'redirectUrl' => route(config('proj.route_name_prefix', 'proj') . '.auth.login')
                ], 503);
            }
            // Si no es un error crítico, dejar que Laravel lo maneje normalmente
        });

        // Manejo de errores PDO (conexión fallida a nivel más bajo)
        $this->renderable(function (\PDOException $e, $request) {
            $errorMessage = 'No se pudo establecer conexión con la base de datos. Por favor, intenta nuevamente.';

            // Para peticiones Livewire/AJAX o normales, mostrar vista de error
            return response()->view('errors.database-error', [
                'message' => $errorMessage,
                'redirectUrl' => route(config('proj.route_name_prefix', 'proj') . '.auth.login')
            ], 503);
        });
    }

    /**
     * Determinar si la excepción es un error de conexión CRÍTICO con la base de datos.
     * Solo devuelve true para errores reales de conexión, no para errores de query normales.
     *
     * @param \Illuminate\Database\QueryException $e
     * @return bool
     */
    protected function isCriticalDatabaseError(\Illuminate\Database\QueryException $e): bool
    {
        // Códigos de error que indican problemas CRÍTICOS de conexión
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

            // Solo considerar error crítico si el código coincide exactamente
            if (in_array((int) $errorCode, $criticalErrorCodes, true)) {
                return true;
            }

            // Verificar palabras clave específicas que indican pérdida de conexión
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
