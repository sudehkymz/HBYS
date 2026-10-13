<?php

namespace App\Modules\SpecializedClinics\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecializedClinicsController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'health_board_adult');
        return view('modules.specialized_clinics.subspecialties.health_board_adult', $context);
    }

    public function cozger(Request $request)
    {
        $context = $this->getPatientContext($request, 'health_board_cozger');
        return view('modules.specialized_clinics.subspecialties.health_board_cozger', $context);
    }

    public function genetics(Request $request)
    {
        $context = $this->getPatientContext($request, 'medical_genetics');
        return view('modules.specialized_clinics.subspecialties.genetics', $context);
    }

    public function nuclearMedicine(Request $request)
    {
        $context = $this->getPatientContext($request, 'nuclear_medicine');
        return view('modules.specialized_clinics.subspecialties.nuclear_medicine', $context);
    }

    public function radiology(Request $request)
    {
        $context = $this->getPatientContext($request, 'radiology_diagnostic');
        return view('modules.specialized_clinics.subspecialties.radiology', $context);
    }

    public function smokingCessation(Request $request)
    {
        $context = $this->getPatientContext($request, 'smoking_cessation');
        return view('modules.specialized_clinics.subspecialties.smoking_cessation', $context);
    }

    public function sleep(Request $request)
    {
        $context = $this->getPatientContext($request, 'sleep_clinic');
        return view('modules.specialized_clinics.subspecialties.sleep', $context);
    }

    public function getat(Request $request)
    {
        $context = $this->getPatientContext($request, 'getat_unit');
        return view('modules.specialized_clinics.subspecialties.getat', $context);
    }

    public function hyperbaric(Request $request)
    {
        $context = $this->getPatientContext($request, 'hyperbaric_medicine');
        return view('modules.specialized_clinics.subspecialties.hyperbaric', $context);
    }

    public function storeReport(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $unit = $request->input('unit', 'health_board_adult');
        $findings = $request->input('findings');
        $statusScore = $request->input('status_score');
        $subSpecialtyData = $request->input('sub_specialty_data', []);

        $reports = session('specialized_reports', []);
        $reports[$admissionId] = [
            'unit' => $unit,
            'status_score' => $statusScore ?? 'Tamamlandı',
            'findings' => $findings,
            'sub_specialty_data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Harun Tekin',
            'date' => date('d.m.Y H:i')
        ];

        session(['specialized_reports' => $reports]);

        $redirectRoute = $request->input('redirect_route', 'specialized.index');
        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Özel poliklinik / kurul değerlendirme raporu ve parametreleri kaydedildi.');
    }

    protected function getPatientContext(Request $request, string $activeUnitKey): array
    {
        $defaultAdmissions = [
            [
                'id' => 901,
                'patient_name' => 'Kemal Öztürk',
                'national_id' => '99887766554',
                'age' => 52,
                'gender' => 'Erkek',
                'room' => 'ÖZ-301',
                'service' => 'Sağlık Kurulu Erişkin',
                'diagnosis' => 'Engellilik Oranı & Maluliyet Heyet Raporu İstemi',
                'attending_physician' => 'Sağlık Kurulu Başkanı Prof. Dr. Harun Tekin'
            ],
            [
                'id' => 902,
                'patient_name' => 'Efe Yıldırım (Çocuk)',
                'national_id' => '88776655443',
                'age' => 6,
                'gender' => 'Erkek',
                'room' => 'ÖZ-302',
                'service' => 'Sağlık Kurulu ÇÖZGER',
                'diagnosis' => 'ÇÖZGER (Çocuk Özel Gereksinim Raporu - Özel Eğitim İstem)',
                'attending_physician' => 'Doç. Dr. Nesrin Aydın'
            ],
            [
                'id' => 903,
                'patient_name' => 'Fatma Şahin',
                'national_id' => '77665544332',
                'age' => 41,
                'gender' => 'Kadın',
                'room' => 'ÖZ-303',
                'service' => 'Sigarayı Bıraktırma Kliniği',
                'diagnosis' => 'Şiddetli Nikotin Bağımlılığı (Fagerström Skoru: 8/10)',
                'attending_physician' => 'Uzm. Dr. Serkan Bulut'
            ],
            [
                'id' => 904,
                'patient_name' => 'Osman Akman',
                'national_id' => '66554433221',
                'age' => 58,
                'gender' => 'Erkek',
                'room' => 'ÖZ-304',
                'service' => 'Uyku Polikliniği',
                'diagnosis' => 'Obstrüktif Uyku Apnesi Şüphesi & PSG (Polisomnografi) İstemi',
                'attending_physician' => 'Prof. Dr. Zafer Yılmaz'
            ],
            [
                'id' => 905,
                'patient_name' => 'Nevin Erdem',
                'national_id' => '55443322110',
                'age' => 49,
                'gender' => 'Kadın',
                'room' => 'ÖZ-305',
                'service' => 'Geleneksel Tamamlayıcı Tıp (GETAT)',
                'diagnosis' => 'Kronik Bel Ağrısı - Akupunktur & Kupa Terapi Planlaması',
                'attending_physician' => 'Dr. Mehmet Taş (GETAT Sertifikalı)'
            ],
            [
                'id' => 906,
                'patient_name' => 'İbrahim Kaya',
                'national_id' => '44332211009',
                'age' => 63,
                'gender' => 'Erkek',
                'room' => 'ÖZ-306',
                'service' => 'Sualtı Hekimliği ve Hiperbarik Tıp',
                'diagnosis' => 'Diyabetik Ayak Yara Tedavisi & Hiperbarik Oksijen (HBOT)',
                'attending_physician' => 'Uzm. Dr. Barış Güven'
            ]
        ];

        if (!session()->has('specialized_admissions')) {
            session(['specialized_admissions' => $defaultAdmissions]);
        }

        $specializedAdmissions = session('specialized_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($specializedAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($specializedAdmissions) > 0) {
            $selectedAdmission = reset($specializedAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $specializedReports = session('specialized_reports', []);

        return compact(
            'specializedAdmissions',
            'selectedAdmission',
            'selectedId',
            'specializedReports',
            'activeUnitKey'
        );
    }
}
