<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ConvocationController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ProcessController;

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

    // Convocatorias
    Route::get('/convocations', [ConvocationController::class, 'index']);
    Route::get('/convocations/{id}', [ConvocationController::class, 'show']);
    Route::get('/convocation-documents/{id}', [ConvocationController::class, 'downloadDocument'])->name('api.convocation-document.show');

    // Trámites/Procesos
    Route::get('/processes', [ProcessController::class, 'index']);
    Route::get('/processes/{id}', [ProcessController::class, 'show']);

    // Notificaciones (móvil)
    Route::get('/my-notifications', [NotificationController::class, 'index']);
    Route::post('/my-notifications/read', [NotificationController::class, 'markAsRead']);

    // TODO: Agregar más endpoints para workers
    // Route::get('/my-requests', 'API\WorkerController@myRequests');
    // Route::get('/my-documents', 'API\WorkerController@myDocuments');
    // Route::apiResource('faqs', 'API\FaqController')->only(['index', 'show']);
});
