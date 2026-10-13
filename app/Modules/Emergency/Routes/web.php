<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Emergency\Controllers\EmergencyController;

Route::middleware(['web'])->group(function () {
    Route::get('/emergency', [EmergencyController::class, 'index'])->name('emergency.index');
    Route::get('/emergency/create', [EmergencyController::class, 'create'])->name('emergency.create');
    Route::post('/emergency', [EmergencyController::class, 'store'])->name('emergency.store');
    Route::post('/emergency/{triage}/status', [EmergencyController::class, 'updateStatus'])->name('emergency.status');
});