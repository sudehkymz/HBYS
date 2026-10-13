<?php

use Illuminate\Support\Facades\Route;
use App\Modules\MedicalEcology\Controllers\MedicalEcologyController;

Route::middleware(['web'])->prefix('medical-ecology')->name('medical_ecology.')->group(function () {
    Route::get('/', [MedicalEcologyController::class, 'index'])->name('index');
    Route::post('/store-exam', [MedicalEcologyController::class, 'storeExam'])->name('store_exam');
});
