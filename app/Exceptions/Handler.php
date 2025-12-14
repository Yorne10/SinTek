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
            // Verificar si es un error de conexión
            if ($this->isDatabaseConnectionError($e)) {
                $errorMessage = 'No hay conexión con la base de datos. Por favor, contacte al administrador del sistema.';

                // Verificar si es una petición Livewire o AJAX
                if ($request->expectsJson() || $request->is('livewire/*') || $request->header('X-Livewire')) {
                    return response()->json([
                        'message' => $errorMessage,
                        'redirect' => route(config('proj.route_name_prefix', 'proj') . '.auth.login')
                    ], 503);
                }

                return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login')
                    ->with('db_error', $errorMessage);
            }
        });

        // Manejo de errores PDO (conexión fallida a nivel más bajo)
        $this->renderable(function (\PDOException $e, $request) {
            $errorMessage = 'No hay conexión con la base de datos. Por favor, contacte al administrador del sistema.';

            // Verificar si es una petición Livewire o AJAX
            if ($request->expectsJson() || $request->is('livewire/*') || $request->header('X-Livewire')) {
                return response()->json([
                    'message' => $errorMessage,
                    'redirect' => route(config('proj.route_name_prefix', 'proj') . '.auth.login')
                ], 503);
            }

            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login')
                ->with('db_error', $errorMessage);
        });
    }

    /**
     * Determinar si la excepción es un error de conexión con la base de datos.
     *
     * @param \Illuminate\Database\QueryException $e
     * @return bool
     */
    protected function isDatabaseConnectionError(\Illuminate\Database\QueryException $e): bool
    {
        $connectionErrorCodes = [
            2002, // Connection refused (MySQL)
            2003, // Can't connect to MySQL server
            2006, // MySQL server has gone away
            2013, // Lost connection to MySQL server
            1045, // Access denied
            1049, // Unknown database
            7,    // Connection failure (PostgreSQL)
            '08001', // SQL Server connection failure
            '08S01', // Communication link failure
        ];

        $previousException = $e->getPrevious();
        if ($previousException instanceof \PDOException) {
            $errorCode = $previousException->getCode();
            // PDO error codes pueden ser strings o enteros
            if (in_array($errorCode, $connectionErrorCodes) || in_array((int) $errorCode, $connectionErrorCodes)) {
                return true;
            }
            // También verificar el mensaje de error para mayor cobertura
            $message = strtolower($previousException->getMessage());
            if (
                str_contains($message, 'connection') ||
                str_contains($message, 'connect') ||
                str_contains($message, 'refused') ||
                str_contains($message, 'gone away') ||
                str_contains($message, 'lost connection')
            ) {
                return true;
            }
        }

        return false;
    }
}
