<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Cardiology\Controllers\CardiologyController;

Route::middleware(['web'])->prefix('cardiology')->name('cardiology.')->group(function () {
    Route::get('/', [CardiologyController::class, 'index'])->name('index');
    Route::post('/store-exam', [CardiologyController::class, 'storeExam'])->name('store_exam');
});
