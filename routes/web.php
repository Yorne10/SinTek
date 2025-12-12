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
use App\Livewire\Faq;
use App\Livewire\Worker\AvailableProcedures;
use App\Livewire\Worker\MyProcedures;
use App\Livewire\Worker\CallsIndex;
use App\Livewire\Worker\Notifications as WorkerNotifications;
use App\Livewire\Admin\ProcedureManagement;
use App\Livewire\Admin\Requests;
use App\Livewire\Admin\ConvocationEvents;
use App\Livewire\Admin\DocumentTemplates;
use App\Livewire\Admin\AuditLog;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\CreateProcess;
use App\Livewire\Admin\CreateStep;
use App\Livewire\Admin\DefineSteps;
use App\Livewire\Admin\ConfigureFlow;
use App\Livewire\Admin\EditProcess;
use App\Livewire\Secretary\ValidateSteps;
use App\Livewire\Secretary\SearchWorkers;
use App\Livewire\Secretary\ConvocationsDocuments;
use App\Livewire\Secretary\CallsIndex as SecretaryCallsIndex;
use App\Livewire\Secretary\DocumentsIndex as SecretaryDocumentsIndex;
use App\Livewire\Secretary\ConvocationForm;
use App\Livewire\Secretary\DocumentForm;
use App\Livewire\Secretary\Reports as SecretaryReports;
use App\Livewire\Secretary\Notifications as SecretaryNotifications;
use App\Livewire\Secretary\NotificationsHistory;
use App\Livewire\Secretary\FaqManagement;
use App\Livewire\Secretary\FaqCategoryForm;
use App\Livewire\Secretary\FaqQuestions;
use App\Livewire\Secretary\FaqQuestionForm;
use App\Livewire\Secretary\ProcessesIndex;
use App\Livewire\Secretary\ProcessDetail;
use App\Livewire\Secretary\BudgetKeyForm;
use App\Http\Controllers\Documents\ConvocationDocumentController;
use App\Http\Controllers\Documents\InstitutionalDocumentController;
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

// Redireccin base a login dentro del prefijo
Route::redirect('/', "/p/{$slug}/login");

// Verificacin de correo (enlace firmado, sin exigir sesin)
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed'])
    ->name('verification.verify');

Route::prefix("p/{$slug}")
    ->as($namePrefix . '.')
    ->group(function () use ($namePrefix) {
        // Pblico
        Route::get('/register', Register::class)->name('auth.register');
        Route::post('/register', [FallbackAuthController::class, 'register'])->name('auth.register.submit');

        Route::get('/login', Login::class)->name('auth.login');
        Route::post('/login', [FallbackAuthController::class, 'login'])->name('auth.login.submit');
        Route::post('/logout', [FallbackAuthController::class, 'logout'])->name('auth.logout');

        // Ruta para sesión expirada
        Route::view('/session-expired', 'errors.session-expired')->name('errors.session-expired');

        // Fallback for GET logout (e.g. refresh) -> Redirect to session expired
        Route::get('/logout', function () use ($namePrefix) {
            return redirect()->route($namePrefix . '.errors.session-expired');
        });

        Route::get('/forgot-password', ForgotPassword::class)->name('auth.forgot-password');
        Route::get('/reset-password/{id}', ResetPassword::class)->name('auth.reset-password')->middleware('signed');

        // Errores y pginas informativas
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

            // Rutas para documentos institucionales
            Route::get('/institutional-document/{id}', [InstitutionalDocumentController::class, 'show'])->name('institutional-document.show');
            Route::get('/institutional-document/{id}/download', [InstitutionalDocumentController::class, 'download'])->name('institutional-document.download');

            // Preguntas frecuentes (compartido entre todos los roles)
            Route::get('/faq', Faq::class)->name('faq');

            // Rutas para trabajadores (workers)
            Route::middleware(['role:worker'])->group(function () {
                Route::get('/available-procedures', AvailableProcedures::class)->name('worker.available-procedures');
                Route::get('/my-procedures', MyProcedures::class)->name('worker.my-procedures');
                Route::get('/procedure-detail/{id}', \App\Livewire\Worker\ProcedureDetail::class)->name('worker.procedure-detail');
                Route::get('/calls', CallsIndex::class)->name('worker.calls');
                Route::get('/convocations', CallsIndex::class)->name('worker.convocations');
                Route::get('/documents', \App\Livewire\Worker\DocumentsIndex::class)->name('worker.documents');
                Route::get('/worker-notifications', WorkerNotifications::class)->name('worker.notifications');
            });

            // Rutas para secretarios/operadores
            Route::middleware(['role:secretary'])->group(function () {
                // Funciones de secretara
                Route::get('/validate-steps', ValidateSteps::class)->name('secretary.validate-steps');
                Route::get('/search-workers', SearchWorkers::class)->name('secretary.search-workers');
                Route::get('/secretary/calls', SecretaryCallsIndex::class)->name('secretary.calls');
                Route::get('/secretary/documents', SecretaryDocumentsIndex::class)->name('secretary.documents');
                Route::get('/convocation/create', ConvocationForm::class)->name('secretary.convocation.create');
                Route::get('/convocation/{id}/edit', ConvocationForm::class)->name('secretary.convocation.edit');
                Route::get('/document/create', DocumentForm::class)->name('secretary.document.create');
                Route::get('/document/{id}/edit', DocumentForm::class)->name('secretary.document.edit');
                Route::get('/secretary-reports', SecretaryReports::class)->name('secretary.reports');
                Route::get('/secretary-notifications', NotificationsHistory::class)->name('secretary.notifications');
                Route::get('/secretary-notifications/send', SecretaryNotifications::class)->name('secretary.notifications.send');
                Route::get('/secretary-notifications/{notificationId}/edit', SecretaryNotifications::class)->name('secretary.notifications.edit');
                Route::get('/faq/categories', FaqManagement::class)->name('faq.categories');
                Route::get('/faq/category/create', FaqCategoryForm::class)->name('faq.category.create');
                Route::get('/faq/category/{categoryId}/edit', FaqCategoryForm::class)->name('faq.category.edit');
                Route::get('/faq/questions/{categoryId}', FaqQuestions::class)->name('faq.questions');
                Route::get('/faq/question/{categoryId}/create', FaqQuestionForm::class)->name('faq.question.create');
                Route::get('/faq/question/{categoryId}/{faqId}/edit', FaqQuestionForm::class)->name('faq.question.edit');
                Route::get('/secretary/processes', ProcessesIndex::class)->name('secretary.processes');
                Route::get('/secretary/process/{processId}', ProcessDetail::class)->name('secretary.process.detail');
                Route::get('/secretary/budget-keys', \App\Livewire\Secretary\BudgetKeys::class)->name('secretary.budget-keys');
                Route::get('/budget-key/create', BudgetKeyForm::class)->name('secretary.budget-key.create');
                Route::get('/budget-key/{id}/edit', BudgetKeyForm::class)->name('secretary.budget-key.edit');
                Route::get('/worker/{id}/procedures', \App\Livewire\Secretary\WorkerProceduresHistory::class)->name('secretary.worker-procedures');
            });

            // Rutas para administradores (gestin de usuarios y sistema)
            Route::middleware(['role:admin'])->group(function () {
                Route::get('/configuration', Settings::class)->name('admin.configuration');
                Route::get('/activity-log', AuditLog::class)->name('admin.activity-log');
                Route::view('/alerts-preview', 'modules.admin.alerts-preview')->name('admin.alerts-preview');
            });

            // Rutas compartidas: admin Y secretary (gestin de procesos)
            Route::middleware(['role:admin,secretary'])->group(function () {
                Route::get('/create-process', CreateProcess::class)->name('admin.create-process');
                Route::get('/define-steps/{process_id?}', DefineSteps::class)->name('admin.define-steps');
                Route::get('/configure-flow/{process_id}', ConfigureFlow::class)->name('admin.configure-flow');
                Route::get('/create-step', CreateStep::class)->name('admin.create-step');
                Route::get('/modify-process/{process_id?}', EditProcess::class)->name('admin.modify-process');
                Route::get('/manage-procedures', ProcedureManagement::class)->name('admin.manage-procedures');
                Route::get('/requests', Requests::class)->name('admin.requests');
                Route::get('/convocations-events', ConvocationEvents::class)->name('admin.convocations-events');
                Route::get('/document-templates', DocumentTemplates::class)->name('admin.document-templates');
            });

            // Rutas de la plantilla original
            Route::get('/profile-example', ProfileExample::class)->name('profile.example');

            // Ruta de gestin de usuarios (solo para admin)
            Route::middleware(['role:admin'])->group(function () {
                Route::get('/users', Users::class)->name('users.index');
                Route::get('/users/create', UserCreate::class)->name('users.create');
                Route::get('/users/{id}/edit', \App\Livewire\UserEdit::class)->name('users.edit');
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
