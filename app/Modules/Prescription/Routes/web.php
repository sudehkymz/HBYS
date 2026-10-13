<?php

use App\Modules\Prescription\Controllers\PrescriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('prescription')->group(function () {
    Route::get('/', [PrescriptionController::class, 'index'])->name('prescription.index');
    Route::get('/search-patients-ajax', [PrescriptionController::class, 'searchPatientsAjax'])->name('prescription.search_patients_ajax');
    Route::post('/store', [PrescriptionController::class, 'store'])->name('prescription.store');
    Route::post('/{prescription}/send-erecepta', [PrescriptionController::class, 'sendErecepta'])->name('prescription.send_erecepta');
    Route::post('/query', [PrescriptionController::class, 'query'])->name('prescription.query');
    Route::post('/check-safety', [PrescriptionController::class, 'checkSafety'])->name('prescription.check_safety');
});