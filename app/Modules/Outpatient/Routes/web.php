<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Outpatient\Controllers\OutpatientController;

Route::middleware(['web'])->group(function () {
    Route::get('/outpatient', [OutpatientController::class, 'index'])->name('outpatient.index');
    Route::get('/outpatient/examine/{patient}', [OutpatientController::class, 'examine'])->name('outpatient.examine');
    Route::post('/outpatient/start', [OutpatientController::class, 'start'])->name('outpatient.start');
    Route::post('/outpatient/{examination}/complete', [OutpatientController::class, 'complete'])->name('outpatient.complete');
});