<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PhysicalRehab\Controllers\PhysicalRehabController;

Route::middleware(['web'])->prefix('physical-rehab')->name('physical_rehab.')->group(function () {
    Route::get('/', [PhysicalRehabController::class, 'index'])->name('index');
    Route::post('/store-exam', [PhysicalRehabController::class, 'storeExam'])->name('store_exam');
});
