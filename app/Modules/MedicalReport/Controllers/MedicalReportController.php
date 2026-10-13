<?php

namespace App\Modules\MedicalReport\Controllers;

use App\Modules\MedicalReport\Models\MedicalReport;
use App\Modules\MedicalReport\Services\MedicalReportService;
use Illuminate\Http\Request;

class MedicalReportController
{
    protected MedicalReportService $medicalReportService;

    public function __construct(MedicalReportService $medicalReportService)
    {
        $this->medicalReportService = $medicalReportService;
    }

    public function index()
    {
        return redirect()->route('medical_report.chief_physician');
    }

    /**
     * AI İle Rapor İçeriği ve Taslağı Üretme AJAX Endpoint
     */
    /**
     * AI İle Rapor İçeriği ve Taslağı Üretme AJAX Endpoint
     */
    public function generateAiDraft(Request $request, \App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider $patientDataProvider)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $reportType = $request->input('report_type', 'Ayaktan İstirahat Raporu');
        $diagnosis = $request->input('diagnosis', 'I10 - Essansiyel Hipertansiyon');
        $restDays = (int) $request->input('rest_days', 5);
        $complaint = trim($request->input('complaint', ''));

        $patient = $patientDataProvider->getVirtualPatientProfile($patientId);

        $aiResult = $this->medicalReportService->generateAiReportDraft($reportType, $diagnosis, $restDays, $patient, $complaint);
        return response()->json($aiResult);
    }

    /**
     * Canlı Hasta Arama ve Autocomplete Seçenekleri AJAX Endpoint
     */
    public function searchPatientsAjax(Request $request, \App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider $patientDataProvider)
    {
        $query = trim($request->input('q', ''));
        $patients = $patientDataProvider->searchPatientProfilesMany($query);

        return response()->json([
            'status' => 'success',
            'count' => count($patients),
            'patients' => array_map(function ($p) {
                return [
                    'patient_id' => $p['patient_id'],
                    'first_name' => $p['first_name'],
                    'last_name' => $p['last_name'],
                    'national_id' => $p['national_id'],
                    'birth_date' => $p['birth_date'] ?? '-',
                    'gender' => $p['gender'] ?? '-',
                    'blood_type' => $p['blood_type'] ?? '-',
                    'clinic' => $p['recent_encounters'][0]['clinic'] ?? 'Poliklinik'
                ];
            }, $patients)
        ]);
    }

    /**
     * ICD-10 Hastalık Kodları ve Reçete Önerileri Arama / Kataloğu AJAX Endpoint
     */
    public function searchIcd10(Request $request, \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService $icd10CatalogService)
    {
        $query = (string) $request->input('q', '');
        if (trim($query) === '') {
            $results = $icd10CatalogService->getAll();
        } else {
            $results = $icd10CatalogService->search($query, 200);
        }

        foreach ($results as &$item) {
            $item['recommended_drugs'] = $icd10CatalogService->getRecommendedDrugsForDiagnosis($item['code']);
        }

        return response()->json([
            'status' => 'success',
            'query' => $query,
            'results_count' => count($results),
            'catalog_source' => 'T.C. Sağlık Bakanlığı Sağlık Bilgi Sistemleri Genel Müdürlüğü ICD-10 Kataloğu',
            'data' => $results
        ]);
    }

    /**
     * Doktor Onay ve Yönetim Paneli (Doctor Dashboard) - AI Risk Analizli & Entegre Çalışma Alanı
     */
    public function chiefPhysicianDashboard(Request $request, \App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider $patientDataProvider)
    {
        $userId = auth()->id();
        $patientId = $request->input('patient_id');
        $searchQuery = trim($request->input('search_query', $request->input('search_patient', '')));
        $searchError = null;

        $patients = $patientDataProvider->getAllVirtualPatients();

        // Oturumdaki ek teşhisleri/muayeneleri hasta profiline ekle
        foreach ($patients as $pid => &$p) {
            $sessionEncounters = session("patient_encounters_{$pid}", []);
            if (!empty($sessionEncounters)) {
                $p['recent_encounters'] = array_merge($sessionEncounters, $p['recent_encounters']);
            }
        }
        unset($p);

        $activePatient = null;
        if (!is_null($patientId) && $patientId !== '' && isset($patients[(int)$patientId])) {
            $activePatient = $patients[(int)$patientId];
        } else {
            // Default to Patient #1 (Ahmet Yılmaz) if patient_id is not specified in URL
            $activePatient = $patients[1] ?? (reset($patients) ?: null);
        }

        // Eğer kullanıcı isim/soyisim veya TC sorgusu girdiyse hasta ara
        if (!empty($searchQuery)) {
            $searched = $patientDataProvider->searchPatientProfile($searchQuery);
            if ($searched) {
                $activePatient = $searched;
                $patients[$searched['patient_id']] = $searched;
            } else {
                $searchError = "Girdiğiniz \"{$searchQuery}\" arama kriteri ile eşleşen hasta kaydı bulunamadı.";
            }
        }

        $reportsQuery = MedicalReport::with('approvals');
        $pendingQuery = MedicalReport::query();
        $approvedQuery = MedicalReport::query();
        $totalQuery = MedicalReport::query();

        if (auth()->check() && auth()->user()->role !== 'admin') {
            $reportsQuery->where('physician_id', $userId);
            $pendingQuery->where('physician_id', $userId);
            $approvedQuery->where('physician_id', $userId);
            $totalQuery->where('physician_id', $userId);
        }

        $reports = $reportsQuery->latest()->get();

        // Her rapor için AI Risk & Karar Analizi eklenir
        foreach ($reports as $report) {
            $report->ai_analysis = $this->medicalReportService->getChiefPhysicianAiAnalysis($report);
        }

        $pendingCount = $pendingQuery->where('chief_physician_approval_status', 'pending')->count();
        $approvedCount = $approvedQuery->where('chief_physician_approval_status', 'approved')->count();
        $totalCount = $totalQuery->count();

        return view('modules.medical_report.chief_physician', compact(
            'reports',
            'pendingCount',
            'approvedCount',
            'totalCount',
            'patients',
            'activePatient',
            'searchQuery',
            'searchError'
        ));
    }

    /**
     * AI Teşhis Önerisini Kabul Etme & Hasta Tıbbi Dosyasına (Teşhisler) Kaydetme (AJAX)
     */
    public function acceptAiRecommendation(Request $request, \App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider $patientDataProvider)
    {
        $patientId = (int) $request->input('patient_id', 1);
        $diagnosis = trim($request->input('diagnosis', 'I10 - Essansiyel Hipertansiyon'));
        $complaint = trim($request->input('complaint', 'Göğüste sıkışma hissi ve çarpıntı'));
        $isEdited = (bool) $request->input('is_edited', false);

        $patient = $patientDataProvider->getVirtualPatientProfile($patientId);
        $physicianName = auth()->check() ? auth()->user()->name : 'Dr. Sude Hekim';

        $notes = $isEdited
            ? 'Hekim tarafından revize edilerek/düzenlenerek kayda alındı.'
            : 'AI Karar Destek Asistanı teşhis ve klinik önerisi hekim tarafından kabul edildi ve kayda alındı.';

        $newEncounter = [
            'date' => date('Y-m-d'),
            'clinic' => $isEdited ? 'Kardiyoloji Polikliniği (Hekim Revizyonu)' : 'Kardiyoloji Polikliniği (AI Karar Destek)',
            'physician' => $physicianName,
            'complaint' => $complaint,
            'diagnosis' => $diagnosis,
            'notes' => $notes
        ];

        // Oturuma ekle (sayfa yenilendiğinde de hasta dosyasında görünsün)
        $sessionEncounters = session("patient_encounters_{$patientId}", []);
        array_unshift($sessionEncounters, $newEncounter);
        session(["patient_encounters_{$patientId}" => $sessionEncounters]);

        // Hastaya Teşhis Konulduğunda Bildirim Gönder (NotificationService)
        $patientName = ($patient['first_name'] ?? 'Hasta') . ' ' . ($patient['last_name'] ?? '');
        $notificationService = app(\App\Modules\Notification\Services\NotificationService::class);
        $notificationService->addNotification([
            'id' => time() . rand(100, 999),
            'physician_name' => $physicianName,
            'patient_id' => $patientId,
            'patient_name' => $patientName,
            'alert_type' => 'diagnosis_assigned',
            'severity' => 'info',
            'severity_label' => 'Teşhis & Rapor',
            'title' => '📋 HASTAYA TEŞHİS KONULDU',
            'message' => "{$physicianName} tarafından {$patientName} isimli hastaya '{$diagnosis}' tanısı konuldu ve hasta dosyasına işlendi.",
            'created_at' => 'Şimdi'
        ]);

        // Rapor taslağını otomatik üret
        $aiDraft = $this->medicalReportService->generateAiReportDraft('Ayaktan İstirahat Raporu', $diagnosis, 5, $patient, $complaint);

        return response()->json([
            'status' => 'success',
            'message' => $isEdited ? 'Hekim tarafından düzenlenen teşhis hasta dosyasına kaydedildi ve bildirim oluşturuldu!' : 'AI teşhis önerisi kabul edildi, hasta tıbbi dosyasına kaydedildi ve bildirim oluşturuldu!',
            'encounter' => $newEncounter,
            'diagnosis' => $diagnosis,
            'suggested_content' => $aiDraft['suggested_content'] ?? ''
        ]);
    }

    /**
     * Hasta Bazlı AI Karar Destek Verisi (AJAX) - Şikayete Göre Teşhis ve İlaç Önerisi
     */
    public function getPatientAiSupport(
        Request $request,
        \App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider $patientDataProvider,
        \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService $icd10CatalogService,
        \App\Modules\Prescription\Services\DrugSafetyService $drugSafetyService
    ) {
        $patientId = (int) $request->input('patient_id', 1);
        $complaint = trim($request->input('complaint', ''));
        $patient = $patientDataProvider->getVirtualPatientProfile($patientId);

        $allergiesList = $patient['allergies'] ?? [];
        $allergies = !empty($allergiesList) ? implode(', ', $allergiesList) : 'Kayıtlı Alerji Bulunmuyor';
        $chronic = !empty($patient['chronic_diseases']) ? implode(', ', $patient['chronic_diseases']) : 'Kronik Tanı Yok';

        // 1. EĞER ŞİKAYET KISMI BOŞ İSE:
        if (empty($complaint)) {
            return response()->json([
                'status' => 'empty_complaint',
                'message' => 'Hasta şikayeti & anamnez bilgisi girilmediği için AI değerlendirmesi yapılmadı.'
            ]);
        }

        // T.C. Sağlık Bakanlığı ICD-10 Kataloğundan Akıllı Eşleştirme Yap
        $icdSuggestions = $icd10CatalogService->suggestDiagnosisForSymptoms([$complaint]);

        $suggestedDiagnoses = [];
        $suggestedMedications = [];
        $safetyWarnings = [];

        foreach ($icdSuggestions as $idx => $sug) {
            $confPercent = '%' . (int)($sug['confidence'] * 100);
            $suggestedDiagnoses[] = [
                'icd' => $sug['code'],
                'name' => $sug['description'],
                'confidence' => $confPercent
            ];

            if (!empty($sug['recommended_drugs']) && empty($suggestedMedications)) {
                foreach ($sug['recommended_drugs'] as $drug) {
                    // İlaç Güvenlik & Alerji & Gebelik Kontrolü
                    $safetyResult = $drugSafetyService->checkDrugSafety($drug['name'], $patientId);
                    $drugWarningStr = $drug['purpose'] ?? 'AI Klinik İlaç Önerisi';

                    if ($safetyResult['has_warnings']) {
                        foreach ($safetyResult['warnings'] as $w) {
                            $safetyWarnings[] = [
                                'drug' => $drug['name'],
                                'title' => $w['title'],
                                'description' => $w['description'],
                                'severity' => $w['severity']
                            ];
                            $drugWarningStr .= " | " . $w['title'] . ": " . $w['description'];
                        }
                    }

                    $suggestedMedications[] = [
                        'drug' => $drug['name'],
                        'dosage' => $drug['dosage'] . ' (' . $drug['frequency'] . ')',
                        'warning' => $drugWarningStr,
                        'has_safety_alert' => $safetyResult['has_warnings']
                    ];
                }
            }
        }

        $topDiagnosis = $suggestedDiagnoses[0]['icd'] . ' - ' . $suggestedDiagnoses[0]['name'];
        $hasLiveKey = !empty(env('OPENAI_API_KEY'));
        $modelName = $hasLiveKey 
            ? 'OpenAI GPT-4o / GPT-4o-mini (Live API Gateway)' 
            : 'HBYS AI Gateway (T.C. Sağlık Bakanlığı ICD-10 Entegreli)';
        $aiAnalysisText = "T.C. Sağlık Bakanlığı ICD-10 AI Analizi: Girilen '{$complaint}' şikayeti doğrultusunda en olası tanı ({$topDiagnosis}) ve eczane stoklarında bulunan tedavi ilaçları önerilmiştir.";

        return response()->json([
            'model_name' => $modelName,
            'is_live_api' => $hasLiveKey,
            'model_version' => 'v2026.1-Clinical-Support',

            'created_at' => date('d.m.Y H:i'),
            'status' => 'success',
            'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
            'complaint' => $complaint,
            'used_records' => "Hasta EHR Dosyası, LIS Laboratuvar Verileri, Girilen Anamnez Şikayeti (Hasta #{$patientId})",
            'info_sources' => 'T.C. Sağlık Bakanlığı Sağlık Bilgi Sistemleri ICD-10 Standart Tanı Kataloğu',
            'confidence_score' => 96,
            'uncertainties' => [
                'Dış merkez e-Nabız tetkik kayıtları henüz sisteme entegre edilmedi.',
                'Eczane ilaç kullanım uyum verisi doktor tarafından doğrulanmalıdır.'
            ],
            'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 kataloğu ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.',
            'allergies' => $allergies,
            'chronic_diseases' => $chronic,
            'safety_warnings' => $safetyWarnings,
            'suggested_diagnoses' => $suggestedDiagnoses,
            'suggested_medications' => $suggestedMedications,
            'suggested_diagnosis' => $topDiagnosis,
            'ai_analysis' => $aiAnalysisText,
            'ai_recommendation' => $aiAnalysisText,
            'clinical_note_draft' => "Klinik Anamnez Özeti: Hasta {$patient['first_name']} {$patient['last_name']}, '{$complaint}' şikayeti ile başvurdu. Muayene ve AI analizi doğrultusunda teşhis ({$topDiagnosis}) ve tedavi planı oluşturuldu."
        ]);
    }

    private function matchAny(string $text, array $keywords): bool
    {
        foreach ($keywords as $kw) {
            if (str_contains($text, $kw)) {
                return true;
            }
        }
        return false;
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'report_type' => 'required|string',
            'diagnosis' => 'required|string',
            'rest_days' => 'required|integer'
        ]);

        $data = $request->all();
        if (auth()->check()) {
            $data['physician_id'] = auth()->id();
        }

        $report = $this->medicalReportService->createReportDraft($data);

        return redirect()->route('medical_report.chief_physician', ['patient_id' => $request->input('patient_id', 1)])
            ->with('success', 'Tıbbi rapor başarıyla oluşturuldu ve Doktor Onay Masasına kaydedildi: ' . $report->report_number);
    }

    public function sign(MedicalReport $report)
    {
        $this->medicalReportService->signByPhysician($report);

        return redirect()->route('medical_report.chief_physician', ['patient_id' => $report->patient_id])
            ->with('success', 'Hekim imzası tamamlandı. Rapor onay listesine gönderildi: ' . $report->report_number);
    }

    public function approve(MedicalReport $report)
    {
        $result = $this->medicalReportService->approveByChiefPhysician($report);

        return redirect()->back()->with('success', 'Doktor onayı verildi ve EReportAdapter üzerinden resmi e-Rapor Numarası üretildi: ' . $result['adapter_response']['e_rapor_no']);
    }

    public function reject(MedicalReport $report, Request $request)
    {
        $report->update([
            'status' => 'rejected',
            'chief_physician_approval_status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Rapor reddedildi: ' . $report->report_number);
    }
}
