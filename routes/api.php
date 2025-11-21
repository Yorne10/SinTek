<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/register', [AuthController::class, 'register']);

        // Users management (for API controllers to be created)
        Route::apiResource('users', 'API\UserController');
        Route::apiResource('positions', 'API\PositionController');
        Route::apiResource('processes', 'API\ProcessController');
        Route::apiResource('steps', 'API\StepController');
        Route::apiResource('convocations', 'API\ConvocationController');
        Route::apiResource('logs', 'API\LogController')->only(['index', 'show']);
    });

    // Admin and Secretary routes
    Route::middleware(['role:admin,secretary'])->group(function () {
        Route::apiResource('workers', 'API\WorkerController');
        Route::apiResource('requests', 'API\RequestController');
        Route::apiResource('request-steps', 'API\RequestStepController');
        Route::apiResource('documents', 'API\DocumentController');
        Route::apiResource('notifications', 'API\NotificationController');

        // Mark notification as read
        Route::patch('/notifications/{notification}/read', 'API\NotificationController@markAsRead');
    });

    // All authenticated users (including workers)
    Route::apiResource('faqs', 'API\FaqController')->only(['index', 'show']);

    // Worker specific routes
    Route::middleware(['role:worker'])->group(function () {
        Route::get('/my-requests', 'API\WorkerController@myRequests');
        Route::get('/my-documents', 'API\WorkerController@myDocuments');
        Route::get('/my-notifications', 'API\NotificationController@myNotifications');
        Route::get('/my-profile', 'API\WorkerController@myProfile');
        Route::put('/my-profile', 'API\WorkerController@updateProfile');
    });

    // Shared routes for admin, secretary
    Route::middleware(['role:admin,secretary'])->group(function () {
        // FAQ management
        Route::apiResource('faqs', 'API\FaqController')->except(['index', 'show']);
    });
});
