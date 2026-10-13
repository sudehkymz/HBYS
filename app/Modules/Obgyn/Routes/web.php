<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Obgyn\Controllers\ObgynController;

Route::middleware(['web'])->prefix('obgyn')->name('obgyn.')->group(function () {
    Route::get('/', [ObgynController::class, 'index'])->name('index');
    Route::get('/perinatology', [ObgynController::class, 'perinatology'])->name('perinatology');
    Route::get('/gyn-oncology', [ObgynController::class, 'gynOncology'])->name('gyn_oncology');
    Route::get('/ivf', [ObgynController::class, 'ivf'])->name('ivf');
    Route::post('/store-exam', [ObgynController::class, 'storeExam'])->name('store_exam');
});
