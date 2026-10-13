<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Psychiatry\Controllers\PsychiatryController;

Route::middleware(['web'])->prefix('psychiatry')->name('psychiatry.')->group(function () {
    Route::get('/', [PsychiatryController::class, 'index'])->name('index');
    Route::get('/amatem', [PsychiatryController::class, 'amatem'])->name('amatem');
    Route::post('/store-exam', [PsychiatryController::class, 'storeExam'])->name('store_exam');
});
