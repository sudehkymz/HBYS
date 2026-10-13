<?php

use Illuminate\Support\Facades\Route;
use App\Modules\CardiovascularSurgery\Controllers\CardiovascularSurgeryController;

Route::middleware(['web'])->prefix('cardiovascular-surgery')->name('cardiovascular_surgery.')->group(function () {
    Route::get('/', [CardiovascularSurgeryController::class, 'index'])->name('index');
    Route::post('/store-exam', [CardiovascularSurgeryController::class, 'storeExam'])->name('store_exam');
});
