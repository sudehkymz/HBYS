<?php

use Illuminate\Support\Facades\Route;
use App\Modules\RadiationOncology\Controllers\RadiationOncologyController;

Route::middleware(['web'])->prefix('radiation-oncology')->name('radiation_oncology.')->group(function () {
    Route::get('/', [RadiationOncologyController::class, 'index'])->name('index');
    Route::post('/store-exam', [RadiationOncologyController::class, 'storeExam'])->name('store_exam');
});
