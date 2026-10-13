<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Nutrition\Controllers\NutritionController;

Route::group(['prefix' => 'nutrition', 'as' => 'nutrition.'], function () {
    Route::get('/', [NutritionController::class, 'index'])->name('index');
    Route::post('/assign', [NutritionController::class, 'assign'])->name('assign');
});
