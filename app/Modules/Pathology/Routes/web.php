<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Pathology\Controllers\PathologyController;

Route::group(['prefix' => 'pathology', 'as' => 'pathology.'], function () {
    Route::get('/', [PathologyController::class, 'index'])->name('index');
    Route::post('/request', [PathologyController::class, 'requestTest'])->name('request');
    Route::post('/result', [PathologyController::class, 'saveResult'])->name('result');
});
