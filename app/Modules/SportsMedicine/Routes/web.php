<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SportsMedicine\Controllers\SportsMedicineController;

Route::middleware(['web'])->prefix('sports-medicine')->name('sports_medicine.')->group(function () {
    Route::get('/', [SportsMedicineController::class, 'index'])->name('index');
    Route::post('/store-exam', [SportsMedicineController::class, 'storeExam'])->name('store_exam');
});
