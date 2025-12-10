<?php

namespace App\Services\API\Notifications;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class NotificationService
{
    public function index(Request $request)
    {
        $userId = $request->user()->users_id;

        $request->validate([
            'since' => 'nullable|date',
            'unread_only' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Notification::where('user_id', $userId)->orderByDesc('created_at');

        if ($request->boolean('unread_only')) {
            $query->whereNull('read_at');
        }

        if ($request->filled('since')) {
            $since = Carbon::parse($request->get('since'));
            $query->where('created_at', '>', $since);
        }

        $notifications = $query->paginate($request->integer('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    public function markAsRead(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:notifications,notification_id',
        ]);

        $userId = $request->user()->users_id;

        // Get notifications before updating to log them
        $notifications = Notification::where('user_id', $userId)
            ->whereIn('notification_id', $validated['ids'])
            ->whereNull('read_at')
            ->get();

        // Update notifications
        Notification::where('user_id', $userId)
            ->whereIn('notification_id', $validated['ids'])
            ->update(['read_at' => now()]);

        // Log activity for each notification - SAME MESSAGE AS WEB
        foreach ($notifications as $notification) {
            ActivityLogger::log(
                'notificacion.marcar_leida',
                "Notificación marcada como leída: '{$notification->tittle}'",
                $userId
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Notificaciones marcadas como leídas.',
        ]);
    }
}

