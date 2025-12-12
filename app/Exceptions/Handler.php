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
            // Si viene de una petición Ajax/Livewire, redirigir a sesión expirada
            if ($request->ajax() || $request->wantsJson() || $request->is('livewire/*')) {
                return redirect()->route(config('proj.route_name_prefix', 'proj') . '.errors.session-expired');
            }
            // Si es una petición normal, redirigir al login
            return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login');
        });
    }
}
