<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Ent\Controllers\EntController;

Route::middleware(['web'])->prefix('ent')->name('ent.')->group(function () {
    Route::get('/', [EntController::class, 'index'])->name('index');
    Route::post('/store-exam', [EntController::class, 'storeExam'])->name('store_exam');
});
