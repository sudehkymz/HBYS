<?php

use Illuminate\Support\Facades\Route;
use App\Modules\InfectiousDiseases\Controllers\InfectiousDiseasesController;

Route::middleware(['web'])->prefix('infectious-diseases')->name('infectious_diseases.')->group(function () {
    Route::get('/', [InfectiousDiseasesController::class, 'index'])->name('index');
    Route::post('/store-exam', [InfectiousDiseasesController::class, 'storeExam'])->name('store_exam');
});
