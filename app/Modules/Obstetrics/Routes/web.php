<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Obstetrics\Controllers\ObstetricsController;

Route::group(['prefix' => 'obstetrics', 'as' => 'obstetrics.'], function () {
    Route::get('/', [ObstetricsController::class, 'index'])->name('index');
    Route::post('/pregnancy', [ObstetricsController::class, 'pregnancy'])->name('pregnancy');
    Route::post('/delivery', [ObstetricsController::class, 'delivery'])->name('delivery');
});