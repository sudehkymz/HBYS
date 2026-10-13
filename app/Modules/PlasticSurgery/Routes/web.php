<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PlasticSurgery\Controllers\PlasticSurgeryController;

Route::middleware(['web'])->prefix('plastic-surgery')->name('plastic_surgery.')->group(function () {
    Route::get('/', [PlasticSurgeryController::class, 'index'])->name('index');
    Route::get('/hand-surgery', [PlasticSurgeryController::class, 'handSurgery'])->name('hand_surgery');
    Route::post('/store-exam', [PlasticSurgeryController::class, 'storeExam'])->name('store_exam');
});
