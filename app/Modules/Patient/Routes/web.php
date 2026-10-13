<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Patient\Controllers\PatientController;

Route::prefix('patients')->name('patients.')->middleware('web')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('index');
    Route::get('/create', [PatientController::class, 'create'])->name('create');
    Route::post('/', [PatientController::class, 'store'])->name('store');
    Route::get('/{patient}', [PatientController::class, 'show'])->name('show');
    Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('edit');
    Route::put('/{patient}', [PatientController::class, 'update'])->name('update');
    Route::delete('/{patient}', [PatientController::class, 'destroy'])->name('destroy');
});
