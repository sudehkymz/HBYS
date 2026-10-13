<?php

use App\Modules\ArtificialIntelligence\Controllers\AiAssistantController;
use App\Modules\ArtificialIntelligence\Controllers\LabAnalysisAiController;
use Illuminate\Support\Facades\Route;

Route::prefix('ai-assistant')->group(function () {
    Route::get('/', [AiAssistantController::class, 'index'])->name('ai.index');
    Route::post('/summarize-patient', [AiAssistantController::class, 'summarizePatient'])->name('ai.summarize_patient');
    Route::post('/clinical-note', [AiAssistantController::class, 'generateClinicalNote'])->name('ai.clinical_note');
    Route::post('/decision-support', [AiAssistantController::class, 'generateDecisionSupport'])->name('ai.decision_support');
    Route::post('/protocol', [AiAssistantController::class, 'getProtocol'])->name('ai.protocol');
    Route::post('/feedback', [AiAssistantController::class, 'submitFeedback'])->name('ai.feedback');
    Route::post('/generate-medical-report', [AiAssistantController::class, 'generateMedicalReport'])->name('ai.generate_medical_report');
    Route::get('/search-icd10', [AiAssistantController::class, 'searchIcd10'])->name('ai.search_icd10');
    Route::post('/diagnose-icd10', [AiAssistantController::class, 'diagnoseIcd10'])->name('ai.diagnose_icd10');

    // Yapay Zekâ Tıbbi Dosya & Lab Analiz Portalı Rotaları
    Route::get('/lab-analysis', [LabAnalysisAiController::class, 'index'])->name('ai.lab_analysis.index');
    Route::post('/lab-analysis/analyze', [LabAnalysisAiController::class, 'analyze'])->name('ai.lab_analysis.analyze');
    Route::post('/lab-analysis/export-summary', [LabAnalysisAiController::class, 'exportSummary'])->name('ai.lab_analysis.export_summary');
});