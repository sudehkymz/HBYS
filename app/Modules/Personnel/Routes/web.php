<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Personnel\Controllers\PersonnelController;
use App\Modules\Personnel\Controllers\DoctorController;

Route::prefix('personnel')->name('personnel.')->middleware('web')->group(function () {
    Route::resource('personnels', PersonnelController::class);
    Route::resource('doctors', DoctorController::class);
});
