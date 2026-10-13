<?php

use Illuminate\Support\Facades\Route;
use App\Modules\FamilyMedicine\Controllers\FamilyMedicineController;

Route::middleware(['web'])->prefix('family-medicine')->name('family_medicine.')->group(function () {
    Route::get('/', [FamilyMedicineController::class, 'index'])->name('index');
    Route::post('/store-exam', [FamilyMedicineController::class, 'storeExam'])->name('store_exam');
});
