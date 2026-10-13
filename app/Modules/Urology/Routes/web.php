<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Urology\Controllers\UrologyController;

Route::middleware(['web'])->prefix('urology')->name('urology.')->group(function () {
    Route::get('/', [UrologyController::class, 'index'])->name('index');
    Route::post('/store-exam', [UrologyController::class, 'storeExam'])->name('store_exam');
});
