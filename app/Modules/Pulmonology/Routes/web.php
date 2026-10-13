<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Pulmonology\Controllers\PulmonologyController;

Route::middleware(['web'])->prefix('pulmonology')->name('pulmonology.')->group(function () {
    Route::get('/', [PulmonologyController::class, 'index'])->name('index');
    Route::post('/store-exam', [PulmonologyController::class, 'storeExam'])->name('store_exam');
});
