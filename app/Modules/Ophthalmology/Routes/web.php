<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Ophthalmology\Controllers\OphthalmologyController;

Route::middleware(['web'])->prefix('ophthalmology')->name('ophthalmology.')->group(function () {
    Route::get('/', [OphthalmologyController::class, 'index'])->name('index');
    Route::get('/glaucoma', [OphthalmologyController::class, 'glaucoma'])->name('glaucoma');
    Route::get('/retina', [OphthalmologyController::class, 'retina'])->name('retina');
    Route::get('/strabismus', [OphthalmologyController::class, 'strabismus'])->name('strabismus');
    Route::get('/uvea', [OphthalmologyController::class, 'uvea'])->name('uvea');
    Route::get('/cornea', [OphthalmologyController::class, 'cornea'])->name('cornea');
    Route::get('/oculoplastics', [OphthalmologyController::class, 'oculoplastics'])->name('oculoplastics');
    Route::post('/store-exam', [OphthalmologyController::class, 'storeExam'])->name('store_exam');
});
