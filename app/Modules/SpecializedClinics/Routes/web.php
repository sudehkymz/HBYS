<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SpecializedClinics\Controllers\SpecializedClinicsController;

Route::middleware(['web'])->prefix('specialized')->name('specialized.')->group(function () {
    Route::get('/', [SpecializedClinicsController::class, 'index'])->name('index');
    Route::get('/cozger', [SpecializedClinicsController::class, 'cozger'])->name('cozger');
    Route::get('/genetics', [SpecializedClinicsController::class, 'genetics'])->name('genetics');
    Route::get('/nuclear-medicine', [SpecializedClinicsController::class, 'nuclearMedicine'])->name('nuclear_medicine');
    Route::get('/radiology', [SpecializedClinicsController::class, 'radiology'])->name('radiology');
    Route::get('/smoking-cessation', [SpecializedClinicsController::class, 'smokingCessation'])->name('smoking_cessation');
    Route::get('/sleep', [SpecializedClinicsController::class, 'sleep'])->name('sleep');
    Route::get('/getat', [SpecializedClinicsController::class, 'getat'])->name('getat');
    Route::get('/hyperbaric', [SpecializedClinicsController::class, 'hyperbaric'])->name('hyperbaric');

    Route::post('/store-report', [SpecializedClinicsController::class, 'storeReport'])->name('store_report');
});
