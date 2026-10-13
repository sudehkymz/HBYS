<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Inpatient\Controllers\AdmissionController;
use App\Modules\Inpatient\Controllers\DischargeController;

Route::group(['prefix' => 'inpatient', 'as' => 'inpatient.'], function () {
    // Admission Routes
    Route::get('/admission', [AdmissionController::class, 'index'])->name('admission.index');
    Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');
    Route::post('/admission/transfer', [AdmissionController::class, 'transfer'])->name('admission.transfer');

    // Discharge Routes
    Route::get('/discharge/{id?}', [DischargeController::class, 'index'])->name('discharge.index');
    Route::post('/discharge', [DischargeController::class, 'store'])->name('discharge.store');

    // Bed Routes
    Route::post('/beds', [AdmissionController::class, 'addBed'])->name('beds.store');
    Route::post('/beds/status', [AdmissionController::class, 'updateBedStatus'])->name('beds.status.update');

    // Timeline Route
    Route::get('/timeline', [AdmissionController::class, 'timeline'])->name('timeline');
});