<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Dental\Controllers\DentalController;

Route::middleware(['web'])->prefix('dental')->name('dental.')->group(function () {
    Route::get('/', [DentalController::class, 'index'])->name('index');
    Route::get('/surgery', [DentalController::class, 'surgery'])->name('surgery');
    Route::get('/radiology', [DentalController::class, 'radiology'])->name('radiology');
    Route::get('/pedodontics', [DentalController::class, 'pedodontics'])->name('pedodontics');
    Route::get('/endodontics', [DentalController::class, 'endodontics'])->name('endodontics');
    Route::get('/orthodontics', [DentalController::class, 'orthodontics'])->name('orthodontics');
    Route::get('/periodontics', [DentalController::class, 'periodontics'])->name('periodontics');
    Route::get('/prosthodontics', [DentalController::class, 'prosthodontics'])->name('prosthodontics');
    Route::get('/restorative', [DentalController::class, 'restorative'])->name('restorative');

    Route::post('/store-exam', [DentalController::class, 'storeExam'])->name('store_exam');
});
