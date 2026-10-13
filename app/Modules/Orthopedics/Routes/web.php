<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Orthopedics\Controllers\OrthopedicsController;

Route::middleware(['web'])->prefix('orthopedics')->name('orthopedics.')->group(function () {
    Route::get('/', [OrthopedicsController::class, 'index'])->name('index');
    Route::get('/hand-surgery', [OrthopedicsController::class, 'handSurgery'])->name('hand_surgery');
    Route::post('/store-exam', [OrthopedicsController::class, 'storeExam'])->name('store_exam');
});
