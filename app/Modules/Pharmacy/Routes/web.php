<?php

use App\Modules\Pharmacy\Controllers\PharmacyController;
use Illuminate\Support\Facades\Route;

Route::prefix('pharmacy')->group(function () {
    Route::get('/', [PharmacyController::class, 'index'])->name('pharmacy.index');
    Route::get('/inpatient', [PharmacyController::class, 'inpatient'])->name('pharmacy.inpatient');
    Route::get('/search-inpatient-ajax', [PharmacyController::class, 'searchInpatientAjax'])->name('pharmacy.search_inpatient_ajax');
    Route::get('/inventory', [PharmacyController::class, 'inventory'])->name('pharmacy.inventory');
    Route::post('/pharmacist-query', [PharmacyController::class, 'pharmacistQuery'])->name('pharmacy.query');
    Route::post('/query', [PharmacyController::class, 'pharmacistQuery'])->name('pharmacy.pharmacist_query');
    Route::post('/dispense', [PharmacyController::class, 'dispense'])->name('pharmacy.dispense');
});
