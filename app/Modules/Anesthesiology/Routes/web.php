<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Anesthesiology\Controllers\AnesthesiologyController;

Route::middleware(['web'])->prefix('anesthesiology')->name('anesthesiology.')->group(function () {
    Route::get('/', [AnesthesiologyController::class, 'index'])->name('index');
    Route::get('/algology', [AnesthesiologyController::class, 'algology'])->name('algology');
    Route::post('/store-exam', [AnesthesiologyController::class, 'storeExam'])->name('store_exam');
});
