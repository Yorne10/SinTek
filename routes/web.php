<?php

use App\Livewire\BootstrapTables;
use App\Livewire\Components\Buttons;
use App\Livewire\Components\Forms;
use App\Livewire\Components\Modals;
use App\Livewire\Components\Notifications;
use App\Livewire\Components\Typography;
use App\Livewire\Dashboard;
use App\Livewire\Err404;
use App\Livewire\Err500;
use App\Livewire\ResetPassword;
use App\Livewire\ForgotPassword;
use App\Livewire\Lock;
use App\Livewire\Auth\Login;
use App\Livewire\Profile;
use App\Livewire\Auth\Register;
use App\Livewire\ForgotPasswordExample;
use App\Livewire\Index;
use App\Livewire\LoginExample;
use App\Livewire\ProfileExample;
use App\Livewire\RegisterExample;
use App\Livewire\Transactions;
use Illuminate\Support\Facades\Route;
use App\Livewire\ResetPasswordExample;
use App\Livewire\UpgradeToPro;
use App\Livewire\Users;
use App\Livewire\UserCreate;
use App\Livewire\PreguntasFrecuentes;
use App\Livewire\Worker\TramitesDisponibles;
use App\Livewire\Worker\MisTramites;
use App\Livewire\Worker\Convocatorias;
use App\Livewire\Worker\Notificaciones;
use App\Livewire\Admin\GestionTramites;
use App\Livewire\Admin\Solicitudes;
use App\Livewire\Admin\ConvocatoriasEventos;
use App\Livewire\Admin\PlantillasDocumentos;
use App\Livewire\Admin\Reportes;
use App\Livewire\Admin\Bitacora;
use App\Livewire\Admin\Configuracion;
use App\Livewire\Admin\CrearProceso;
use App\Livewire\Admin\CrearPaso;
use App\Livewire\Admin\DefinirPasos;
use App\Livewire\Admin\ModificarProceso;
use App\Livewire\Secretary\PanelSolicitudes;
use App\Livewire\Secretary\ValidarPasos;
use App\Livewire\Secretary\BusquedaTrabajadores;
use App\Livewire\Secretary\ConvocatoriasDocumentos;
use App\Livewire\Secretary\Reportes as SecretaryReportes;
use App\Livewire\Secretary\Notificaciones as SecretaryNotificaciones;
use App\Http\Controllers\ConvocationDocumentController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\FallbackAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Prefijo configurable del proyecto: /p/<slug>
$slug = config('proj.slug');
$namePrefix = config('proj.route_name_prefix', 'proj');

// Redirección base a login dentro del prefijo
Route::redirect('/', "/p/{$slug}/login");

// Verificación de correo (enlace firmado, sin exigir sesión)
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed'])
    ->name('verification.verify');

Route::prefix("p/{$slug}")
    ->as($namePrefix . '.')
    ->group(function () use ($namePrefix) {
        // Público
    Route::get('/register', Register::class)->name('auth.register');
    Route::post('/register', [FallbackAuthController::class, 'register'])->name('auth.register.submit');

    Route::get('/login', Login::class)->name('auth.login');
    Route::post('/login', [FallbackAuthController::class, 'login'])->name('auth.login.submit');
    Route::post('/logout', [FallbackAuthController::class, 'logout'])->name('auth.logout');
        Route::get('/forgot-password', ForgotPassword::class)->name('auth.forgot-password');
        Route::get('/reset-password/{id}', ResetPassword::class)->name('auth.reset-password')->middleware('signed');

        // Errores y páginas informativas
        Route::get('/404', Err404::class)->name('errors.404');
        Route::get('/500', Err500::class)->name('errors.500');
        Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('marketing.upgrade-to-pro');

        // Privado
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', Dashboard::class)->name('dashboard.index');
            Route::get('/profile', Profile::class)->name('profile.index');

            // Rutas para documentos de convocatorias
            Route::get('/convocation-document/{id}', [ConvocationDocumentController::class, 'show'])->name('convocation-document.show');
            Route::get('/convocation-document/{id}/download', [ConvocationDocumentController::class, 'download'])->name('convocation-document.download');

            // Preguntas frecuentes (compartido entre todos los roles)
            Route::get('/preguntas-frecuentes', PreguntasFrecuentes::class)->name('preguntas-frecuentes');

            // Rutas para trabajadores (workers)
            Route::middleware(['role:worker'])->group(function () {
                Route::get('/tramites-disponibles', TramitesDisponibles::class)->name('worker.tramites-disponibles');
                Route::get('/mis-tramites', MisTramites::class)->name('worker.mis-tramites');
                Route::get('/convocatorias', Convocatorias::class)->name('worker.convocatorias');
                Route::get('/notificaciones', Notificaciones::class)->name('worker.notificaciones');
            });

            // Rutas para secretarios/operadores
            Route::middleware(['role:secretary'])->group(function () {
                // Funciones de secretaría
                Route::get('/panel-solicitudes', PanelSolicitudes::class)->name('secretary.panel-solicitudes');
                Route::get('/validar-pasos', ValidarPasos::class)->name('secretary.validar-pasos');
                Route::get('/busqueda-trabajadores', BusquedaTrabajadores::class)->name('secretary.busqueda-trabajadores');
                Route::get('/convocatorias-documentos', ConvocatoriasDocumentos::class)->name('secretary.convocatorias-documentos');
                Route::get('/reportes-secretary', SecretaryReportes::class)->name('secretary.reportes');
                Route::get('/notificaciones-secretary', SecretaryNotificaciones::class)->name('secretary.notificaciones');
            });

            // Rutas para administradores (gestión de usuarios y sistema)
            Route::middleware(['role:admin'])->group(function () {
                Route::get('/configuracion', Configuracion::class)->name('admin.configuracion');
                Route::get('/bitacora', Bitacora::class)->name('admin.bitacora');
                Route::get('/reportes', Reportes::class)->name('admin.reportes');
            });

            // Rutas compartidas: admin Y secretary (gestión de procesos)
            Route::middleware(['role:admin,secretary'])->group(function () {
                Route::get('/crear-proceso', CrearProceso::class)->name('admin.crear-proceso');
                Route::get('/definir-pasos', DefinirPasos::class)->name('admin.definir-pasos');
                Route::get('/crear-paso', CrearPaso::class)->name('admin.crear-paso');
                Route::get('/modificar-proceso', ModificarProceso::class)->name('admin.modificar-proceso');
                Route::get('/gestion-tramites', GestionTramites::class)->name('admin.gestion-tramites');
                Route::get('/solicitudes', Solicitudes::class)->name('admin.solicitudes');
                Route::get('/convocatorias-eventos', ConvocatoriasEventos::class)->name('admin.convocatorias-eventos');
                Route::get('/plantillas-documentos', PlantillasDocumentos::class)->name('admin.plantillas-documentos');
            });

            // Rutas de la plantilla original
            Route::get('/profile-example', ProfileExample::class)->name('profile.example');

            // Ruta de gestión de usuarios (solo para admin)
            Route::middleware(['role:admin'])->group(function () {
                Route::get('/users', Users::class)->name('users.index');
                Route::get('/users/create', UserCreate::class)->name('users.create');
            });
            Route::get('/login-example', LoginExample::class)->name('examples.login');
            Route::get('/register-example', RegisterExample::class)->name('examples.register');
            Route::get('/forgot-password-example', ForgotPasswordExample::class)->name('examples.forgot-password');
            Route::get('/reset-password-example', ResetPasswordExample::class)->name('examples.reset-password');
            Route::get('/transactions', Transactions::class)->name('billing.transactions');
            Route::get('/bootstrap-tables', BootstrapTables::class)->name('ui.bootstrap-tables');
            Route::get('/lock', Lock::class)->name('auth.lock');
            Route::get('/buttons', Buttons::class)->name('ui.buttons');
            Route::get('/notifications', Notifications::class)->name('ui.notifications');
            Route::get('/forms', Forms::class)->name('ui.forms');
            Route::get('/modals', Modals::class)->name('ui.modals');
            Route::get('/typography', Typography::class)->name('ui.typography');
        });
    });
