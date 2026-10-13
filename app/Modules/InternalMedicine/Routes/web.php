<?php

use Illuminate\Support\Facades\Route;
use App\Modules\InternalMedicine\Controllers\InternalMedicineController;

Route::middleware(['web'])->prefix('internal-medicine')->name('internal_medicine.')->group(function () {
    Route::get('/', [InternalMedicineController::class, 'index'])->name('index');
    Route::get('/endocrinology', [InternalMedicineController::class, 'endocrinology'])->name('endocrinology');
    Route::get('/gastroenterology', [InternalMedicineController::class, 'gastroenterology'])->name('gastroenterology');
    Route::get('/geriatrics', [InternalMedicineController::class, 'geriatrics'])->name('geriatrics');
    Route::get('/hematology', [InternalMedicineController::class, 'hematology'])->name('hematology');
    Route::get('/allergy-immunology', [InternalMedicineController::class, 'allergyImmunology'])->name('allergy_immunology');
    Route::get('/occupational', [InternalMedicineController::class, 'occupational'])->name('occupational');
    Route::get('/nephrology', [InternalMedicineController::class, 'nephrology'])->name('nephrology');
    Route::get('/rheumatology', [InternalMedicineController::class, 'rheumatology'])->name('rheumatology');
    Route::get('/oncology', [InternalMedicineController::class, 'oncology'])->name('oncology');

    Route::post('/store-exam', [InternalMedicineController::class, 'storeExam'])->name('store_exam');
});
