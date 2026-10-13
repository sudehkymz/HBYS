<?php

use Illuminate\Support\Facades\Route;
use App\Modules\GeneralSurgery\Controllers\GeneralSurgeryController;

Route::middleware(['web'])->prefix('general-surgery')->name('general_surgery.')->group(function () {
    Route::get('/', [GeneralSurgeryController::class, 'index'])->name('index');
    Route::get('/surgical-oncology', [GeneralSurgeryController::class, 'surgicalOncology'])->name('surgical_oncology');
    Route::get('/gi-surgery', [GeneralSurgeryController::class, 'giSurgery'])->name('gi_surgery');
    Route::post('/store-exam', [GeneralSurgeryController::class, 'storeExam'])->name('store_exam');
});
