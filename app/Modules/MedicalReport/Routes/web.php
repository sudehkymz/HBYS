<?php

use App\Modules\MedicalReport\Controllers\MedicalReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('medical-report')->group(function () {
    Route::get('/', [MedicalReportController::class, 'index'])->name('medical_report.index');
    Route::get('/chief-physician', [MedicalReportController::class, 'chiefPhysicianDashboard'])->name('medical_report.chief_physician');
    Route::get('/search-patients-ajax', [MedicalReportController::class, 'searchPatientsAjax'])->name('medical_report.search_patients_ajax');
    Route::get('/icd10-search', [MedicalReportController::class, 'searchIcd10'])->name('medical_report.icd10_search');
    Route::get('/patient-ai-support', [MedicalReportController::class, 'getPatientAiSupport'])->name('medical_report.patient_ai_support');
    Route::post('/ai-draft', [MedicalReportController::class, 'generateAiDraft'])->name('medical_report.ai_draft');
    Route::post('/ai-autofill', [MedicalReportController::class, 'generateAiDraft'])->name('medical_report.ai_autofill');
    Route::post('/accept-ai-recommendation', [MedicalReportController::class, 'acceptAiRecommendation'])->name('medical_report.accept_ai_recommendation');
    Route::post('/store', [MedicalReportController::class, 'store'])->name('medical_report.store');
    Route::post('/{report}/sign', [MedicalReportController::class, 'sign'])->name('medical_report.sign');
    Route::post('/{report}/approve', [MedicalReportController::class, 'approve'])->name('medical_report.approve');
    Route::post('/{report}/reject', [MedicalReportController::class, 'reject'])->name('medical_report.reject');
});
