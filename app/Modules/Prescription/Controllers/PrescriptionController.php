<?php

namespace App\Modules\Prescription\Controllers;

use App\Modules\ArtificialIntelligence\Services\Icd10CatalogService;
use App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider;
use App\Modules\Prescription\Models\Prescription;
use App\Modules\Prescription\Services\DrugSafetyService;
use App\Modules\Prescription\Services\PrescriptionService;
use Illuminate\Http\Request;

class PrescriptionController
{
    protected PrescriptionService $prescriptionService;
    protected DrugSafetyService $drugSafetyService;
    protected MockPatientDataProvider $patientDataProvider;
    protected Icd10CatalogService $icd10CatalogService;

    public function __construct(
        PrescriptionService $prescriptionService,
        DrugSafetyService $drugSafetyService,
        MockPatientDataProvider $patientDataProvider,
        Icd10CatalogService $icd10CatalogService
    ) {
        $this->prescriptionService = $prescriptionService;
        $this->drugSafetyService = $drugSafetyService;
        $this->patientDataProvider = $patientDataProvider;
        $this->icd10CatalogService = $icd10CatalogService;
    }

    public function index(Request $request)
    {
        if (auth()->check() && !auth()->user()->isAdmin() && !auth()->user()->isPhysician()) {
            abort(403, 'E-Reçete düzenleme ve reçete yazma paneline yalnızca Hekimler ve Sistem Yöneticileri erişebilir.');
        }
        $patientId = $request->input('patient_id');
        $searchQuery = trim($request->input('search_query', $request->input('search_patient', '')));
        $searchError = null;

        $patients = $this->patientDataProvider->getAllVirtualPatients();

        $activePatient = null;
        if (!is_null($patientId) && $patientId !== '' && isset($patients[(int)$patientId])) {
            $activePatient = $patients[(int)$patientId];
        }

        if (!empty($searchQuery)) {
            $searched = $this->patientDataProvider->searchPatientProfile($searchQuery);
            if ($searched) {
                $activePatient = $searched;
                $patients[$searched['patient_id']] = $searched;
            } else {
                $searchError = "Girdiğiniz \"{$searchQuery}\" kriteri ile eşleşen hasta kaydı bulunamadı.";
            }
        }

        $aiRecommendedDrugs = [];
        $activeDiagnosisCode = 'I10';
        $activeDiagnosisTitle = 'Tıbbi Muayene / Teşhis';

        if ($activePatient) {
            $rawDiagnosis = $activePatient['recent_encounters'][0]['diagnosis'] 
                ?? ($activePatient['chronic_diseases'][0] ?? 'I10 - Essansiyel Hipertansiyon');
            
            $activeDiagnosisTitle = $rawDiagnosis;

            // Extract ICD-10 code using regex
            if (preg_match('/([A-Z][0-9]{2}(?:\.[0-9]{1,2})?)/i', $rawDiagnosis, $matches)) {
                $activeDiagnosisCode = strtoupper($matches[1]);
            } else {
                // Check chronic diseases for ICD codes
                foreach ($activePatient['chronic_diseases'] ?? [] as $cd) {
                    if (preg_match('/([A-Z][0-9]{2}(?:\.[0-9]{1,2})?)/i', $cd, $cdMatches)) {
                        $activeDiagnosisCode = strtoupper($cdMatches[1]);
                        break;
                    }
                }
            }

            $aiRecommendedDrugs = $this->icd10CatalogService->getRecommendedDrugsForDiagnosis($activeDiagnosisCode);

            if (empty($aiRecommendedDrugs)) {
                $symptoms = array_merge(
                    [$rawDiagnosis],
                    $activePatient['chronic_diseases'] ?? []
                );
                $suggestions = $this->icd10CatalogService->suggestDiagnosisForSymptoms($symptoms);
                if (!empty($suggestions[0]['recommended_drugs'])) {
                    $aiRecommendedDrugs = $suggestions[0]['recommended_drugs'];
                    $activeDiagnosisCode = $suggestions[0]['code'] ?? $activeDiagnosisCode;
                }
            }
        }

        $prescriptions = Prescription::with('items')->latest()->get();

        return view('modules.prescription.index', compact(
            'prescriptions',
            'patients',
            'activePatient',
            'searchQuery',
            'searchError',
            'aiRecommendedDrugs',
            'activeDiagnosisCode',
            'activeDiagnosisTitle'
        ));
    }

    public function searchPatientsAjax(Request $request)
    {
        $query = trim($request->input('q', ''));
        $patients = $this->patientDataProvider->searchPatientProfilesMany($query);

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

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'items' => 'nullable|array',
            'drug_name' => 'nullable|string',
            'dosage' => 'nullable|string',
        ]);

        $items = [];
        if ($request->has('items') && is_array($request->input('items'))) {
            foreach ($request->input('items') as $rawItem) {
                if (!empty($rawItem['drug_name'])) {
                    $dosage = $rawItem['dosage'] ?? '1x1';
                    $items[] = [
                        'drug_name' => trim($rawItem['drug_name']),
                        'dosage' => $dosage,
                        'frequency' => $rawItem['frequency'] ?? $dosage,
                        'box_count' => max(1, (int)($rawItem['box_count'] ?? 1)),
                        'usage_route' => $rawItem['usage_route'] ?? 'oral'
                    ];
                }
            }
        }

        if (empty($items) && $request->filled('drug_name')) {
            $dosage = $request->input('dosage', '1x1');
            $items[] = [
                'drug_name' => trim($request->input('drug_name')),
                'dosage' => $dosage,
                'frequency' => $request->input('frequency', $dosage),
                'box_count' => max(1, (int)$request->input('box_count', 1)),
                'usage_route' => $request->input('usage_route', 'oral')
            ];
        }

        if (empty($items)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['items' => 'Lütfen reçeteye kaydedilecek en az 1 adet ilaç ekleyiniz.']);
        }

        $result = $this->prescriptionService->createPrescription([
            'patient_id' => $request->patient_id,
            'physician_id' => auth()->id() ?? 1,
            'diagnosis_code' => $request->input('diagnosis_code', 'I10 - Essansiyel Hipertansiyon'),
            'notes' => $request->input('notes', 'Hastanın klinik durumu doğrultusunda e-reçete düzenlendi.'),
            'items' => $items
        ]);

        $prescription = $result['prescription'];
        $warnings = $result['warnings'];

        // E-Reçete Kodunu otomatik oluştur ve onay durumuna geçir
        $ereceptaResult = $this->prescriptionService->sendToERecepta($prescription);

        $itemCount = count($items);
        $msg = "{$itemCount} adet kaleme ait E-Reçete başarıyla kaydedildi ve SGK Medula sistemine iletildi. Üretilen E-Reçete No: " . $ereceptaResult['erecepta_no'];

        if (!empty($warnings)) {
            return redirect()->route('prescription.index', ['patient_id' => $request->patient_id])
                ->with('success', $msg)
                ->with('safety_warnings', $warnings);
        }

        return redirect()->route('prescription.index', ['patient_id' => $request->patient_id])->with('success', $msg);
    }

    public function sendErecepta(Prescription $prescription)
    {
        $result = $this->prescriptionService->sendToERecepta($prescription);
        return redirect()->route('prescription.index')->with('success', 'E-Reçete onaylandı ve SGK sistemine gönderildi. Üretilen E-Reçete No: ' . $result['erecepta_no']);
    }

    public function query(Request $request)
    {
        $code = $request->input('query_code');
        if (empty($code)) {
            return redirect()->route('prescription.index')->with('error', 'Lütfen sorgulamak için bir E-Reçete No veya Reçete Kodu girin.');
        }

        $queryResult = $this->prescriptionService->queryERecepta($code);
        $prescriptions = Prescription::with('items')->latest()->get();
        $patients = [
            1 => ['first_name' => 'Ahmet', 'last_name' => 'Yılmaz', 'national_id' => '12345678901'],
            2 => ['first_name' => 'Ayşe', 'last_name' => 'Demir', 'national_id' => '98765432109']
        ];
        $activePatient = $this->patientDataProvider->getVirtualPatientProfile(1);

        return view('modules.prescription.index', compact('prescriptions', 'queryResult', 'code', 'patients', 'activePatient'));
    }

    public function checkSafety(Request $request)
    {
        $drugName = $request->input('drug_name', '');
        $patientId = (int) $request->input('patient_id', 1);

        if (empty($drugName)) {
            return response()->json(['has_warnings' => false, 'warnings' => []]);
        }

        $check = $this->drugSafetyService->checkDrugSafety($drugName, $patientId);
        return response()->json($check);
    }
}