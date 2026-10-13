<?php

namespace App\Modules\Pediatrics\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Pediatrics\Services\PediatricDosingService;
use App\Modules\Pediatrics\Services\PediatricGrowthService;
use App\Modules\Pediatrics\Services\PediatricVaccineService;
use App\Modules\Pediatrics\Services\PediatricPrivacyService;

class PediatricsController extends Controller
{
    protected PediatricDosingService $dosingService;
    protected PediatricGrowthService $growthService;
    protected PediatricVaccineService $vaccineService;
    protected PediatricPrivacyService $privacyService;

    public function __construct(
        PediatricDosingService $dosingService,
        PediatricGrowthService $growthService,
        PediatricVaccineService $vaccineService,
        PediatricPrivacyService $privacyService
    ) {
        $this->dosingService = $dosingService;
        $this->growthService = $growthService;
        $this->vaccineService = $vaccineService;
        $this->privacyService = $privacyService;
    }

    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatrics_general');
        return view('modules.pediatrics.subspecialties.general', $context);
    }

    public function neonatology(Request $request)
    {
        $context = $this->getPatientContext($request, 'neonatology');
        return view('modules.pediatrics.subspecialties.neonatology', $context);
    }

    public function neurology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_neurology');
        return view('modules.pediatrics.subspecialties.neurology', $context);
    }

    public function developmental(Request $request)
    {
        $context = $this->getPatientContext($request, 'developmental_pediatrics');
        return view('modules.pediatrics.subspecialties.developmental', $context);
    }

    public function hematologyOncology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_hematology_oncology');
        return view('modules.pediatrics.subspecialties.hematology_oncology', $context);
    }

    public function endocrinology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_endocrinology');
        return view('modules.pediatrics.subspecialties.endocrinology', $context);
    }

    public function metabolism(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_metabolism');
        return view('modules.pediatrics.subspecialties.metabolism', $context);
    }

    public function pulmonology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_pulmonology');
        return view('modules.pediatrics.subspecialties.pulmonology', $context);
    }

    public function allergyImmunology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_allergy_immunology');
        return view('modules.pediatrics.subspecialties.allergy_immunology', $context);
    }

    public function cardiology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_cardiology');
        return view('modules.pediatrics.subspecialties.cardiology', $context);
    }

    public function gastroenterology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_gastroenterology');
        return view('modules.pediatrics.subspecialties.gastroenterology', $context);
    }

    public function nephrology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_nephrology');
        return view('modules.pediatrics.subspecialties.nephrology', $context);
    }

    public function rheumatology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_rheumatology');
        return view('modules.pediatrics.subspecialties.rheumatology', $context);
    }

    public function infectious(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_infectious');
        return view('modules.pediatrics.subspecialties.infectious', $context);
    }

    public function genetics(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_genetics');
        return view('modules.pediatrics.subspecialties.genetics', $context);
    }

    public function surgery(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_surgery');
        return view('modules.pediatrics.subspecialties.surgery', $context);
    }

    public function cardiovascularSurgery(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_cardiovascular_surgery');
        return view('modules.pediatrics.subspecialties.cardiovascular_surgery', $context);
    }

    public function urology(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_urology');
        return view('modules.pediatrics.subspecialties.urology', $context);
    }

    public function psychiatry(Request $request)
    {
        $context = $this->getPatientContext($request, 'pediatric_psychiatry');
        return view('modules.pediatrics.subspecialties.psychiatry', $context);
    }

    public function storeTriage(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $weight = (float)$request->input('weight');
        $height = (float)$request->input('height');
        $headCirc = $request->input('head_circ') ? (float)$request->input('head_circ') : null;
        $temp = (float)$request->input('temp', 36.5);
        $pulse = (int)$request->input('pulse', 100);
        $bp = $request->input('bp', '95/60');

        $admissions = session('pediatric_admissions_data', []);
        foreach ($admissions as &$adm) {
            if ($adm['id'] == $admissionId) {
                $adm['triage'] = [
                    'weight' => $weight,
                    'height' => $height,
                    'head_circ' => $headCirc,
                    'temp' => $temp,
                    'pulse' => $pulse,
                    'bp' => $bp,
                    'completed' => true
                ];
                break;
            }
        }
        session(['pediatric_admissions_data' => $admissions]);

        $redirectRoute = $request->input('redirect_route', 'pediatrics.index');
        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Hemşire triyaj verileri (Kilo/Boy) başarıyla kaydedildi. Hekim reçete kilidi açıldı.');
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'pediatrics_general');
        $notes = $request->input('clinical_notes');
        $subSpecialtyData = $request->input('sub_specialty_data', []);

        $exams = session('pediatric_exams_data', []);
        $exams[] = [
            'id' => rand(1000, 9999),
            'admission_id' => $admissionId,
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'sub_specialty_data' => $subSpecialtyData,
            'created_at' => now()->toDateTimeString(),
            'physician' => auth()->user()->name ?? 'Dr. Pediatri Uzmanı'
        ];
        session(['pediatric_exams_data' => $exams]);

        $redirectRoute = $request->input('redirect_route', 'pediatrics.index');
        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Pediatrik muayene ve klinik detaylar başarıyla kaydedildi.');
    }

    public function calculateDose(Request $request)
    {
        $drug = $request->input('drug');
        $weight = (float)$request->input('weight');
        $height = (float)$request->input('height', 100);

        $calculation = $this->dosingService->calculateDose($drug, $weight, $height);
        return response()->json($calculation);
    }

    protected function getPatientContext(Request $request, string $activeSpecialtyKey): array
    {
        $defaultAdmissions = [
            [
                'id' => 701,
                'patient_name' => 'Caner Yılmaz',
                'age' => 4,
                'age_months' => 48,
                'gender' => 'Erkek',
                'national_id' => '10293847562',
                'service' => 'Çocuk Polikliniği',
                'room' => 'Poliklinik 2',
                'guardian' => [
                    'name' => 'Ayşe Yılmaz',
                    'relation' => 'Anne',
                    'tc' => '99887766554',
                    'phone' => '0532 111 2233',
                    'consent_signed' => true
                ],
                'triage' => [
                    'weight' => 16.5,
                    'height' => 102,
                    'head_circ' => 50,
                    'temp' => 36.8,
                    'pulse' => 98,
                    'bp' => '95/60',
                    'completed' => true
                ]
            ],
            [
                'id' => 702,
                'patient_name' => 'Zeynep Kaya',
                'age' => 1,
                'age_months' => 14,
                'gender' => 'Kız',
                'national_id' => '20485736192',
                'service' => 'Neonatoloji / Yenidoğan',
                'room' => 'Küvöz-4',
                'guardian' => [
                    'name' => 'Mehmet Kaya',
                    'relation' => 'Baba',
                    'tc' => '88776655443',
                    'phone' => '0544 222 3344',
                    'consent_signed' => true
                ],
                'triage' => [
                    'weight' => 9.2,
                    'height' => 75,
                    'head_circ' => 45,
                    'temp' => 37.1,
                    'pulse' => 115,
                    'bp' => '90/55',
                    'completed' => true
                ]
            ],
            [
                'id' => 703,
                'patient_name' => 'Ali Demir',
                'age' => 7,
                'age_months' => 84,
                'gender' => 'Erkek',
                'national_id' => '30948572611',
                'service' => 'Çocuk Nörolojisi',
                'room' => 'Poliklinik 5',
                'guardian' => [
                    'name' => 'Fatma Demir',
                    'relation' => 'Anne',
                    'tc' => '77665544332',
                    'phone' => '0555 333 4455',
                    'consent_signed' => false
                ],
                'triage' => [
                    'weight' => null,
                    'height' => null,
                    'head_circ' => null,
                    'temp' => null,
                    'pulse' => null,
                    'bp' => null,
                    'completed' => false
                ]
            ]
        ];

        if (!session()->has('pediatric_admissions_data')) {
            session(['pediatric_admissions_data' => $defaultAdmissions]);
        }

        $pediatricAdmissions = session('pediatric_admissions_data', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($pediatricAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($pediatricAdmissions) > 0) {
            $selectedAdmission = reset($pediatricAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $growthData = null;
        $vaccines = [];
        $bsaM2 = 0.0;

        if ($selectedAdmission) {
            $triage = $selectedAdmission['triage'];
            if (!empty($triage['weight']) && !empty($triage['height'])) {
                $growthData = $this->growthService->calculatePercentile(
                    (float)$triage['weight'],
                    (float)$triage['height'],
                    (float)($triage['head_circ'] ?? 0),
                    (int)$selectedAdmission['age'],
                    $selectedAdmission['gender']
                );
                $bsaM2 = $this->dosingService->calculateBSA((float)$triage['weight'], (float)$triage['height']);
            }
            $vaccines = $this->vaccineService->getVaccineMatrix((int)$selectedAdmission['age'], (int)($selectedAdmission['age_months'] % 12));
        }

        $triage = $selectedAdmission ? $selectedAdmission['triage'] : null;
        $guardian = $selectedAdmission ? $selectedAdmission['guardian'] : null;
        $pediatricExams = session('pediatric_exams_data', []);

        return compact(
            'pediatricAdmissions',
            'selectedAdmission',
            'selectedId',
            'triage',
            'guardian',
            'growthData',
            'bsaM2',
            'vaccines',
            'pediatricExams',
            'activeSpecialtyKey'
        );
    }
}
