<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Laboratory\Controllers\DiagnosticsController;

Route::group(['prefix' => 'diagnostics', 'as' => 'diagnostics.'], function () {
    Route::get('/', [DiagnosticsController::class, 'index'])->name('index');
    Route::post('/request', [DiagnosticsController::class, 'requestTest'])->name('request');
    Route::post('/result', [DiagnosticsController::class, 'saveResult'])->name('result');
});