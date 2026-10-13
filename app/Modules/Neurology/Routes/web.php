<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Neurology\Controllers\NeurologyController;

Route::middleware(['web'])->prefix('neurology')->name('neurology.')->group(function () {
    Route::get('/', [NeurologyController::class, 'index'])->name('index');
    Route::get('/neurophysiology', [NeurologyController::class, 'neurophysiology'])->name('neurophysiology');
    Route::post('/store-exam', [NeurologyController::class, 'storeExam'])->name('store_exam');
});
