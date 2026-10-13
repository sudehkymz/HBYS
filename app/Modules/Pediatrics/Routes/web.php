<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Pediatrics\Controllers\PediatricsController;

Route::middleware(['web'])->prefix('pediatrics')->name('pediatrics.')->group(function () {
    Route::get('/', [PediatricsController::class, 'index'])->name('index');
    Route::get('/neonatology', [PediatricsController::class, 'neonatology'])->name('neonatology');
    Route::get('/neurology', [PediatricsController::class, 'neurology'])->name('neurology');
    Route::get('/developmental', [PediatricsController::class, 'developmental'])->name('developmental');
    Route::get('/hematology-oncology', [PediatricsController::class, 'hematologyOncology'])->name('hematology_oncology');
    Route::get('/endocrinology', [PediatricsController::class, 'endocrinology'])->name('endocrinology');
    Route::get('/metabolism', [PediatricsController::class, 'metabolism'])->name('metabolism');
    Route::get('/pulmonology', [PediatricsController::class, 'pulmonology'])->name('pulmonology');
    Route::get('/allergy-immunology', [PediatricsController::class, 'allergyImmunology'])->name('allergy_immunology');
    Route::get('/cardiology', [PediatricsController::class, 'cardiology'])->name('cardiology');
    Route::get('/gastroenterology', [PediatricsController::class, 'gastroenterology'])->name('gastroenterology');
    Route::get('/nephrology', [PediatricsController::class, 'nephrology'])->name('nephrology');
    Route::get('/rheumatology', [PediatricsController::class, 'rheumatology'])->name('rheumatology');
    Route::get('/infectious', [PediatricsController::class, 'infectious'])->name('infectious');
    Route::get('/genetics', [PediatricsController::class, 'genetics'])->name('genetics');
    Route::get('/surgery', [PediatricsController::class, 'surgery'])->name('surgery');
    Route::get('/cardiovascular-surgery', [PediatricsController::class, 'cardiovascularSurgery'])->name('cardiovascular_surgery');
    Route::get('/urology', [PediatricsController::class, 'urology'])->name('urology');
    Route::get('/psychiatry', [PediatricsController::class, 'psychiatry'])->name('psychiatry');

    Route::post('/store-triage', [PediatricsController::class, 'storeTriage'])->name('store_triage');
    Route::post('/store-exam', [PediatricsController::class, 'storeExam'])->name('store_exam');
    Route::post('/calculate-dose', [PediatricsController::class, 'calculateDose'])->name('calculate_dose');
});
