<?php

use App\Modules\Notification\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/count', [NotificationController::class, 'unreadCount'])->name('notifications.count');
    Route::post('/mark-read/{id}', [NotificationController::class, 'markRead'])->name('notifications.mark_read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark_all_read');
});
