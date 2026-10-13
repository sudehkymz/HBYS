<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Dietetics\Controllers\DieteticsController;

Route::middleware(['web'])->prefix('dietetics')->name('dietetics.')->group(function () {
    Route::get('/', [DieteticsController::class, 'index'])->name('index');
    Route::post('/store-exam', [DieteticsController::class, 'storeExam'])->name('store_exam');
});
