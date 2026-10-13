<?php

namespace App\Modules\ArtificialIntelligence\Controllers;

use App\Modules\ArtificialIntelligence\Models\AiPhysicianFeedback;
use App\Modules\ArtificialIntelligence\Models\AiResponse;
use App\Modules\ArtificialIntelligence\Services\AiGatewayService;
use App\Modules\ArtificialIntelligence\Services\ClinicalProtocolService;
use App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider;
use Illuminate\Http\Request;

class AiAssistantController
{
    protected AiGatewayService $aiGatewayService;
    protected ClinicalProtocolService $protocolService;
    protected MockPatientDataProvider $patientDataProvider;
    protected Icd10CatalogService $icd10CatalogService;

    public function __construct(
        AiGatewayService $aiGatewayService,
        ClinicalProtocolService $protocolService,
        MockPatientDataProvider $patientDataProvider,
        Icd10CatalogService $icd10CatalogService
    ) {
        $this->aiGatewayService = $aiGatewayService;
        $this->protocolService = $protocolService;
        $this->patientDataProvider = $patientDataProvider;
        $this->icd10CatalogService = $icd10CatalogService;
    }

    public function index()
    {
        return redirect()->route('medical_report.chief_physician');
    }

    public function searchIcd10(Request $request)
    {
        $query = (string) $request->input('q', '');
        if (trim($query) === '') {
            $results = $this->icd10CatalogService->getAll();
        } else {
            $results = $this->icd10CatalogService->search($query, 200);
        }

        foreach ($results as &$item) {
            $item['recommended_drugs'] = $this->icd10CatalogService->getRecommendedDrugsForDiagnosis($item['code']);
        }

        return response()->json([
            'status' => 'success',
            'query' => $query,
            'results_count' => count($results),
            'catalog_source' => 'T.C. Sağlık Bakanlığı Sağlık Bilgi Sistemleri Genel Müdürlüğü ICD-10 Kataloğu',
            'data' => $results
        ]);
    }

    public function diagnoseIcd10(Request $request)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $patientData = $this->patientDataProvider->getVirtualPatientProfile($patientId);
        
        $suggestions = $this->icd10CatalogService->suggestDiagnosisForSymptoms($patientData);

        return response()->json([
            'status' => 'success',
            'patient_id' => $patientId,
            'patient_name' => trim(($patientData['first_name'] ?? '') . ' ' . ($patientData['last_name'] ?? '')),
            'icd10_diagnosis_suggestions' => $suggestions,
            'catalog_source' => 'T.C. Sağlık Bakanlığı Sağlık Bilgi Sistemleri Genel Müdürlüğü ICD-10 Kataloğu'
        ]);
    }

    public function getProtocol(Request $request)
    {
        $icdCode = $request->input('icd_code', 'I10');
        $protocol = $this->protocolService->getProtocolForDiagnosis($icdCode);

        return response()->json($protocol);
    }

    public function summarizePatient(Request $request)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $patientData = $this->patientDataProvider->getVirtualPatientProfile($patientId);

        $summary = $this->aiGatewayService->generatePatientSummary($patientData, 1, $patientId);
        return response()->json($summary);
    }

    public function generateMedicalReport(Request $request)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $result = $this->aiGatewayService->generateMedicalReportDraft($request->all(), 1, $patientId);

        return response()->json($result);
    }

    public function generateClinicalNote(Request $request)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $patientData = $this->patientDataProvider->getVirtualPatientProfile($patientId);

        $draft = $this->aiGatewayService->generateClinicalNote($patientData, 1, $patientId);
        return response()->json($draft);
    }

    public function generateDecisionSupport(Request $request)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $patientData = $this->patientDataProvider->getVirtualPatientProfile($patientId);

        $support = $this->aiGatewayService->generateDecisionSupport($patientData, 1, $patientId);
        return response()->json($support);
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'ai_response_id' => 'required|exists:ai_responses,id',
            'action' => 'required|in:accepted,edited,rejected',
            'feedback_notes' => 'nullable|string'
        ]);

        $feedback = AiPhysicianFeedback::create([
            'ai_response_id' => $request->ai_response_id,
            'physician_id' => 1,
            'action' => $request->action,
            'feedback_notes' => $request->feedback_notes
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Doktor geribildirimi başarıyla kaydedildi.',
            'feedback' => $feedback
        ]);
    }
}
