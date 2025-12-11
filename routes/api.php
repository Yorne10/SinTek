<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Profiles\ProfileController;
use App\Http\Controllers\API\Convocations\ConvocationController;
use App\Http\Controllers\API\Notifications\NotificationController;
use App\Http\Controllers\API\Processes\ProcessController;
use App\Http\Controllers\API\Requests\RequestController;
use App\Http\Controllers\API\Faq\FaqController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/worker', [AuthController::class, 'registerWorker']);

// Protected routes - SOLO PARA WORKERS (App mvil)
Route::middleware(['auth:sanctum', 'role:worker', 'log.api'])->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Profile routes
    Route::get('/my-profile', [ProfileController::class, 'show']);
    Route::put('/my-profile', [ProfileController::class, 'update']);
    Route::patch('/my-profile', [ProfileController::class, 'update']);
    Route::put('/my-profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/my-profile/photo', [ProfileController::class, 'updatePhoto']);
    Route::delete('/my-profile/photo', [ProfileController::class, 'deletePhoto']);

    // Convocatorias
    Route::get('/convocations', [ConvocationController::class, 'index']);
    Route::get('/convocations/{id}', [ConvocationController::class, 'show']);
    Route::get('/convocation-documents/{id}', [ConvocationController::class, 'downloadDocument'])->name('api.convocation-document.show');

    // Trmites/Procesos - Catlogo
    Route::get('/processes', [ProcessController::class, 'index']);
    Route::get('/processes/{id}', [ProcessController::class, 'show']);

    // Mis Trmites/Solicitudes
    Route::get('/my-requests', [RequestController::class, 'index']);
    Route::post('/my-requests', [RequestController::class, 'store']);
    Route::get('/my-requests/{id}', [RequestController::class, 'show']);
    Route::post('/my-requests/{id}/next-step', [RequestController::class, 'nextStep']);
    Route::post('/my-requests/{id}/conditional-step', [RequestController::class, 'conditionalStep']);
    Route::post('/my-requests/{id}/upload-document', [RequestController::class, 'uploadDocument']);
    Route::post('/my-requests/{id}/cancel', [RequestController::class, 'cancel']);

    // Notificaciones (mvil)
    Route::get('/my-notifications', [NotificationController::class, 'index']);
    Route::post('/my-notifications/read', [NotificationController::class, 'markAsRead']);

    // FAQs - Preguntas Frecuentes
    Route::get('/faq-categories', [FaqController::class, 'getCategories']);
    Route::get('/faqs', [FaqController::class, 'getAllFaqs']);
    Route::get('/faqs/category/{categoryId}', [FaqController::class, 'getFaqsByCategory']);
    Route::get('/faqs/search', [FaqController::class, 'searchFaqs']);
    Route::get('/faqs/{faqId}', [FaqController::class, 'getFaqById']);
});
