<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Nursing\Controllers\NursingController;

Route::group(['prefix' => 'nursing', 'as' => 'nursing.'], function () {
    Route::get('/', [NursingController::class, 'index'])->name('index');
    Route::post('/observe', [NursingController::class, 'observe'])->name('observe');
    Route::post('/medicate', [NursingController::class, 'medicate'])->name('medicate');
    Route::post('/note', [NursingController::class, 'note'])->name('note');
});
