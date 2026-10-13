<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Surgery\Controllers\SurgeryController;

Route::group(['prefix' => 'surgery', 'as' => 'surgery.'], function () {
    Route::get('/', [SurgeryController::class, 'index'])->name('index');
    Route::post('/schedule', [SurgeryController::class, 'schedule'])->name('schedule');
    Route::post('/anesthetize', [SurgeryController::class, 'anesthetize'])->name('anesthetize');
    Route::post('/report', [SurgeryController::class, 'report'])->name('report');
});
