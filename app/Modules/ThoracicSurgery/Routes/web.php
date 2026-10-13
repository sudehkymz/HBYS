<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ThoracicSurgery\Controllers\ThoracicSurgeryController;

Route::middleware(['web'])->prefix('thoracic-surgery')->name('thoracic_surgery.')->group(function () {
    Route::get('/', [ThoracicSurgeryController::class, 'index'])->name('index');
    Route::post('/store-exam', [ThoracicSurgeryController::class, 'storeExam'])->name('store_exam');
});
