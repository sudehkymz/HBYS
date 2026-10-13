<?php

use Illuminate\Support\Facades\Route;
use App\Modules\AerospaceMedicine\Controllers\AerospaceMedicineController;

Route::middleware(['web'])->prefix('aerospace-medicine')->name('aerospace_medicine.')->group(function () {
    Route::get('/', [AerospaceMedicineController::class, 'index'])->name('index');
    Route::post('/store-exam', [AerospaceMedicineController::class, 'storeExam'])->name('store_exam');
});
