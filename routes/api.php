<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ConvocationController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ProcessController;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\FaqController;

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

// Protected routes - SOLO PARA WORKERS (App Móvil)
Route::middleware(['auth:sanctum', 'role:worker'])->group(function () {
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

    // Trámites/Procesos - Catálogo
    Route::get('/processes', [ProcessController::class, 'index']);
    Route::get('/processes/{id}', [ProcessController::class, 'show']);

    // Mis Trámites/Solicitudes
    Route::get('/my-requests', [RequestController::class, 'index']);
    Route::post('/my-requests', [RequestController::class, 'store']);
    Route::get('/my-requests/{id}', [RequestController::class, 'show']);
    Route::post('/my-requests/{id}/next-step', [RequestController::class, 'nextStep']);
    Route::post('/my-requests/{id}/conditional-step', [RequestController::class, 'conditionalStep']);

    // Notificaciones (móvil)
    Route::get('/my-notifications', [NotificationController::class, 'index']);
    Route::post('/my-notifications/read', [NotificationController::class, 'markAsRead']);

    // FAQs - Preguntas Frecuentes
    Route::get('/faq-categories', [FaqController::class, 'getCategories']);
    Route::get('/faqs', [FaqController::class, 'getAllFaqs']);
    Route::get('/faqs/category/{categoryId}', [FaqController::class, 'getFaqsByCategory']);
    Route::get('/faqs/search', [FaqController::class, 'searchFaqs']);
    Route::get('/faqs/{faqId}', [FaqController::class, 'getFaqById']);
});
