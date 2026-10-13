<?php

namespace App\Modules\ArtificialIntelligence\Controllers;

use App\Modules\ArtificialIntelligence\Services\LabAnalysisAiService;
use App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider;
use Illuminate\Http\Request;

class LabAnalysisAiController
{
    protected LabAnalysisAiService $labAiService;
    protected MockPatientDataProvider $patientDataProvider;

    public function __construct(
        LabAnalysisAiService $labAiService,
        MockPatientDataProvider $patientDataProvider
    ) {
        $this->labAiService = $labAiService;
        $this->patientDataProvider = $patientDataProvider;
    }

    public function index(Request $request)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $patient = $this->patientDataProvider->getVirtualPatientProfile($patientId);
        $initialAnalysis = $this->labAiService->analyzePatientLabResults($patientId);

        return view('modules.ai.lab_analysis', compact('patient', 'patientId', 'initialAnalysis'));
    }

    public function analyze(Request $request)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $customLabs = $request->input('custom_labs', []);

        $analysis = $this->labAiService->analyzePatientLabResults($patientId, $customLabs);

        return response()->json($analysis);
    }

    public function exportSummary(Request $request)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $analysis = $this->labAiService->analyzePatientLabResults($patientId);

        $p = $analysis['patient_info'];
        $text = "====================================================\n";
        $text .= "YAPAY ZEKÂ TIBBİ DOSYA & LAB ANALİZ ÖZET RAPORU\n";
        $text .= "====================================================\n";
        $text .= "Hasta: {$p['name']} (Yaş: {$p['age']}, Cinsiyet: {$p['gender']})\n";
        $text .= "Tarih: {$analysis['timestamp']} | Analiz ID: {$analysis['analysis_id']}\n";
        $text .= "Taranan Lab Sayısı: {$analysis['scanned_labs_count']} | Anormal Parametre: {$analysis['abnormal_labs_count']}\n\n";

        $text .= "1. MEVCUT OLASI HASTALIKLAR & TEŞHİSLER:\n";
        foreach ($analysis['current_diagnoses'] as $d) {
            $text .= "- [ICD-10: {$d['icd10']}] {$d['disease']} (%{$d['probability']} Olasılık)\n";
            $text .= "  Gerekçe: {$d['clinical_summary']}\n";
        }

        $text .= "\n2. GELECEKTE OLUŞABİLECEK HASTALIK & KOMPLİKASYON RİSKLERİ:\n";
        foreach ($analysis['future_risks'] as $r) {
            $text .= "- {$r['condition']} ({$r['timeline']} - Risk Skoru: %{$r['risk_score']})\n";
            $text .= "  Etkilenen Organ: {$r['impact_organ']}\n";
            $text .= "  Açıklama: {$r['description']}\n";
        }

        $text .= "\n3. DEĞERLERİ DÜZELTME & İYİLEŞTİRME ÖNERİLERİ:\n";
        $text .= "A) Medikal / İlaç Revizyon Önerileri:\n";
        foreach ($analysis['improvement_recommendations']['medical_adjustments'] as $m) {
            $text .= "  * {$m['title']}: {$m['detail']}\n";
        }
        $text .= "B) Beslenme & Yaşam Tarzı Tavsiyeleri:\n";
        foreach ($analysis['improvement_recommendations']['lifestyle_and_nutrition'] as $l) {
            $text .= "  * {$l['title']}: {$l['detail']}\n";
        }
        $text .= "C) Takip & İleri Tetkik Takvimi:\n";
        foreach ($analysis['improvement_recommendations']['followup_schedule'] as $f) {
            $text .= "  * {$f['title']}: {$f['detail']}\n";
        }

        $text .= "\n----------------------------------------------------\n";
        $text .= $analysis['disclaimer'] . "\n";

        return response()->json([
            'status' => 'success',
            'summary_text' => $text
        ]);
    }
}
