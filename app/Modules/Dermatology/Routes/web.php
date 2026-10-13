<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Dermatology\Controllers\DermatologyController;

Route::middleware(['web'])->prefix('dermatology')->name('dermatology.')->group(function () {
    Route::get('/', [DermatologyController::class, 'index'])->name('index');
    Route::post('/store-exam', [DermatologyController::class, 'storeExam'])->name('store_exam');
});
