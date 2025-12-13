<?php
/**
 * Company: CETAM
 * Project: ST
 * File: NotificationController.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\RestfulController;
use App\Services\API\Notifications\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends RestfulController
{
    protected NotificationService $notificationService;

    /**

     * Create a new instance.

     *

     * @param NotificationService $notificationService

     */

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**

     * List all resources.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function index(Request $request)
    {
        return $this->notificationService->index($request);
    }

    /**

     * Mark as read.

     *

     * @param Request $request

     *

     * @return void

     */

    public function markAsRead(Request $request)
    {
        return $this->notificationService->markAsRead($request);
    }
}
