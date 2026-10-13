<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ElectronicHealthRecord\Controllers\EhrController;

Route::middleware(['web'])->group(function () {
    Route::get('/ehr/{patient}', [EhrController::class, 'show'])->name('ehr.show');
    Route::post('/ehr/{patient}/vitals', [EhrController::class, 'storeVitals'])->name('ehr.vitals.store');
    Route::get('/ehr/{patient}/print', [EhrController::class, 'printSummary'])->name('ehr.print');
});
