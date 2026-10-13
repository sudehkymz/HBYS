<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Neurosurgery\Controllers\NeurosurgeryController;

Route::middleware(['web'])->prefix('neurosurgery')->name('neurosurgery.')->group(function () {
    Route::get('/', [NeurosurgeryController::class, 'index'])->name('index');
    Route::post('/store-exam', [NeurosurgeryController::class, 'storeExam'])->name('store_exam');
});
