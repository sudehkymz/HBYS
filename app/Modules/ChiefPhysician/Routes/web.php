<?php

use App\Modules\ChiefPhysician\Controllers\ChiefPhysicianController;
use Illuminate\Support\Facades\Route;

Route::prefix('chief-physician')->group(function () {
    Route::get('/', [ChiefPhysicianController::class, 'index'])->name('chief_physician.index');
    Route::post('/report/{id}/approve', [ChiefPhysicianController::class, 'approveReport'])->name('chief_physician.approve_report');
    Route::post('/report/{id}/reject', [ChiefPhysicianController::class, 'rejectReport'])->name('chief_physician.reject_report');
});
