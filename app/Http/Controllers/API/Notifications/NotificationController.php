<?php

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\RestfulController;
use App\Services\API\Notifications\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends RestfulController
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        return $this->notificationService->index($request);
    }

    public function markAsRead(Request $request)
    {
        return $this->notificationService->markAsRead($request);
    }
}
