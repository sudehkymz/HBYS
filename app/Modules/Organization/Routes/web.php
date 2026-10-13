<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Organization\Controllers\BuildingController;
use App\Modules\Organization\Controllers\FloorController;
use App\Modules\Organization\Controllers\ClinicController;
use App\Modules\Organization\Controllers\PoliklinikController;
use App\Modules\Organization\Controllers\ExaminationRoomController;

Route::middleware(['web', 'auth'])->prefix('organization')->name('organization.')->group(function () {
    Route::resource('buildings', BuildingController::class);
    Route::resource('floors', FloorController::class);
    Route::resource('clinics', ClinicController::class);
    Route::resource('polikliniks', PoliklinikController::class);
    Route::resource('examination-rooms', ExaminationRoomController::class);
});
