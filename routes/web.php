<?php
/**
 * Company: CETAM
 * Project: ST
 * File: web.php
 * Created on: 10/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

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
use App\Livewire\Worker\AcceptPrivacyTerms;
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

// Base redirect to login within prefix
Route::redirect('/', "/p/{$slug}/login");

Route::prefix("p/{$slug}")
    ->as($namePrefix . '.')
    ->group(function () use ($namePrefix) {
        // Email verification (signed route, no session required)
        Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed'])
            ->name('auth.verify');

        // Public routes
        Route::get('/register', Register::class)->name('auth.register');
        Route::post('/register', [FallbackAuthController::class, 'register'])->name('auth.register.submit');

        Route::get('/login', Login::class)->name('auth.login');
        Route::post('/login', [FallbackAuthController::class, 'login'])->name('auth.login.submit');
        Route::post('/logout', [FallbackAuthController::class, 'logout'])->name('auth.logout');

        // Route for expired session
        Route::view('/session-expired', 'errors.session-expired')->name('errors.session-expired');

        // Fallback for GET logout (e.g. refresh) -> Redirect to session expired
        Route::get('/logout', function () use ($namePrefix) {
            return redirect()->route($namePrefix . '.errors.session-expired');
        });

        Route::get('/forgot-password', ForgotPassword::class)->name('auth.forgot-password');
        Route::get('/reset-password/{id}', ResetPassword::class)->name('auth.reset-password')->middleware('signed');

        // Errors and informational pages
        Route::get('/404', Err404::class)->name('errors.404');
        Route::get('/500', Err500::class)->name('errors.500');
        Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('marketing.upgrade-to-pro');

        // Private routes (authenticated)
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', Dashboard::class)->name('dashboard.index');
            Route::get('/profile', Profile::class)->name('profile.index');

            // Routes for convocation documents
            Route::get('/convocation-document/{id}', [ConvocationDocumentController::class, 'show'])->name('convocation-document.show');
            Route::get('/convocation-document/{id}/download', [ConvocationDocumentController::class, 'download'])->name('convocation-document.download');

            // Routes for institutional documents
            Route::get('/institutional-document/{id}', [InstitutionalDocumentController::class, 'show'])->name('institutional-document.show');
            Route::get('/institutional-document/{id}/download', [InstitutionalDocumentController::class, 'download'])->name('institutional-document.download');

            // Routes for step provided documents
            Route::get('/step-provided-document/{id}', [\App\Http\Controllers\StepProvidedDocumentController::class, 'show'])->name('step-provided-document.show');
            Route::get('/step-provided-document/{id}/download', [\App\Http\Controllers\StepProvidedDocumentController::class, 'download'])->name('step-provided-document.download');

            // Routes for request documents (uploaded by workers)
            Route::get('/request-document/{id}', [\App\Http\Controllers\Documents\RequestDocumentController::class, 'show'])->name('request-document.show');
            Route::get('/request-document/{id}/download', [\App\Http\Controllers\Documents\RequestDocumentController::class, 'download'])->name('request-document.download');

            // Frequently asked questions (shared among all roles)
            Route::get('/faq', Faq::class)->name('faq');

            // Privacy terms route (must be accessible before middleware check)
            Route::middleware(['role:worker'])->group(function () {
                Route::get('/worker/privacy-terms', AcceptPrivacyTerms::class)->name('worker.privacy-terms');
            });

            // Routes for workers (with privacy acceptance check)
            Route::middleware(['role:worker', \App\Http\Middleware\EnsureWorkerAcceptedPrivacy::class])->group(function () {
                Route::get('/available-procedures', AvailableProcedures::class)->name('worker.available-procedures');
                Route::get('/my-procedures', MyProcedures::class)->name('worker.my-procedures');
                Route::get('/procedure-detail/{id}', \App\Livewire\Worker\ProcedureDetail::class)->name('worker.procedure-detail');
                Route::get('/step-detail/{requestId}/{stepId}', \App\Livewire\Worker\StepDetail::class)->name('worker.step-detail');
                Route::get('/calls', CallsIndex::class)->name('worker.calls');
                Route::get('/convocations', CallsIndex::class)->name('worker.convocations');
                Route::get('/documents', \App\Livewire\Worker\DocumentsIndex::class)->name('worker.documents');
                Route::get('/worker-notifications', WorkerNotifications::class)->name('worker.notifications');
            });

            // Routes for secretaries/operators
            Route::middleware(['role:secretary'])->group(function () {
                // Secretary functions
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
                Route::get('/worker/procedure/{id}', \App\Livewire\Secretary\SecretaryProcedureDetail::class)->name('secretary.procedure-detail');
                Route::get('/worker/step/{requestId}/{stepId}', \App\Livewire\Secretary\SecretaryStepDetail::class)->name('secretary.step-detail');
            });

            // Routes for administrators (user and system management)
            Route::middleware(['role:admin'])->group(function () {
                Route::get('/configuration', Settings::class)->name('admin.configuration');
                Route::get('/activity-log', AuditLog::class)->name('admin.activity-log');
                Route::view('/alerts-preview', 'modules.admin.alerts-preview')->name('admin.alerts-preview');
            });

            // Shared routes: admin AND secretary (process management)
            Route::middleware(['role:admin,secretary'])->group(function () {
                Route::get('/create-process', CreateProcess::class)->name('admin.create-process');
                Route::get('/define-steps/{process_id?}', DefineSteps::class)->name('admin.define-steps');
                Route::get('/configure-flow/{process_id}', ConfigureFlow::class)->name('admin.configure-flow');
                Route::get('/create-step', CreateStep::class)->name('admin.create-step');
                Route::get('/edit-step/{step_id}', CreateStep::class)->name('admin.edit-step');
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
