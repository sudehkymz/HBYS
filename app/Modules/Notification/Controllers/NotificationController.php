<?php

namespace App\Modules\Notification\Controllers;

use App\Modules\Notification\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $patientId = (int) $request->input('patient_id', 0);

        $alerts = $this->notificationService->getActiveClinicalAlerts($patientId, $user);
        $stats = $this->notificationService->getNotificationStats($patientId, $user);

        return view('modules.notification.index', compact('alerts', 'stats'));
    }

    public function markRead($id)
    {
        $user = auth()->user();
        $this->notificationService->markAsRead($id);
        $unreadCount = $this->notificationService->getUnreadCount(0, $user);
        $stats = $this->notificationService->getNotificationStats(0, $user);

        return response()->json([
            'status' => 'success',
            'message' => 'Bildirim okundu olarak işaretlendi.',
            'unread_count' => $unreadCount,
            'stats' => $stats
        ]);
    }

    public function markAllRead()
    {
        $user = auth()->user();
        $this->notificationService->markAllAsRead($user);
        $unreadCount = $this->notificationService->getUnreadCount(0, $user);
        $stats = $this->notificationService->getNotificationStats(0, $user);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tüm bildirimler okundu olarak işaretlendi.',
                'unread_count' => $unreadCount,
                'stats' => $stats
            ]);
        }
        return redirect()->back()->with('success', 'Tüm bildirimler okundu olarak işaretlendi.');
    }

    public function unreadCount()
    {
        $user = auth()->user();
        $count = $this->notificationService->getUnreadCount(0, $user);
        return response()->json([
            'status' => 'success',
            'unread_count' => $count
        ]);
    }
}
