<?php

namespace App\Modules\InternalMedicine\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InternalMedicineController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.internal_medicine.subspecialties.general', $context);
    }

    public function endocrinology(Request $request)
    {
        $context = $this->getPatientContext($request, 'endocrinology');
        return view('modules.internal_medicine.subspecialties.endocrinology', $context);
    }

    public function gastroenterology(Request $request)
    {
        $context = $this->getPatientContext($request, 'gastroenterology');
        return view('modules.internal_medicine.subspecialties.gastroenterology', $context);
    }

    public function geriatrics(Request $request)
    {
        $context = $this->getPatientContext($request, 'geriatrics');
        return view('modules.internal_medicine.subspecialties.geriatrics', $context);
    }

    public function hematology(Request $request)
    {
        $context = $this->getPatientContext($request, 'hematology');
        return view('modules.internal_medicine.subspecialties.hematology', $context);
    }

    public function allergyImmunology(Request $request)
    {
        $context = $this->getPatientContext($request, 'allergy_immunology');
        return view('modules.internal_medicine.subspecialties.allergy_immunology', $context);
    }

    public function occupational(Request $request)
    {
        $context = $this->getPatientContext($request, 'occupational');
        return view('modules.internal_medicine.subspecialties.occupational', $context);
    }

    public function nephrology(Request $request)
    {
        $context = $this->getPatientContext($request, 'nephrology');
        return view('modules.internal_medicine.subspecialties.nephrology', $context);
    }

    public function rheumatology(Request $request)
    {
        $context = $this->getPatientContext($request, 'rheumatology');
        return view('modules.internal_medicine.subspecialties.rheumatology', $context);
    }

    public function oncology(Request $request)
    {
        $context = $this->getPatientContext($request, 'oncology');
        return view('modules.internal_medicine.subspecialties.oncology', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);

        $exams = session('internal_medicine_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'sub_specialty_data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Ahmet Yılmaz',
            'date' => date('d.m.Y H:i')
        ];

        session(['internal_medicine_exams' => $exams]);

        $redirectRoute = $request->input('redirect_route', 'internal_medicine.index');
        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Dahili tıp muayene kaydı ve poliklinik parametreleri kaydedildi.');
    }

    protected function getPatientContext(Request $request, string $activeSubKey): array
    {
        $defaultAdmissions = [
            [
                'id' => 801,
                'patient_name' => 'Mustafa Demir',
                'national_id' => '12345678901',
                'age' => 54,
                'gender' => 'Erkek',
                'room' => 'DH-101',
                'service' => 'İç Hastalıkları (Dahiliye)',
                'diagnosis' => 'Tip 2 Diabetes Mellitus & Esansiyel Hipertansiyon',
                'attending_physician' => 'Prof. Dr. Ahmet Yılmaz',
                'hba1c' => 8.4,
                'blood_pressure' => '145/90 mmHg',
                'glucose' => 186
            ],
            [
                'id' => 802,
                'patient_name' => 'Ayşe Kaya',
                'national_id' => '23456789012',
                'age' => 42,
                'gender' => 'Kadın',
                'room' => 'DH-102',
                'service' => 'Endokrinoloji ve Metabolizma',
                'diagnosis' => 'Hashimoto Tiroiditi & İnsülin Direnci (HOMA-IR High)',
                'attending_physician' => 'Doç. Dr. Zeynep Şahin',
                'hba1c' => 6.1,
                'tsh' => 8.2,
                'fasting_insulin' => 22
            ],
            [
                'id' => 803,
                'patient_name' => 'Mehmet Özkan',
                'national_id' => '34567890123',
                'age' => 61,
                'gender' => 'Erkek',
                'room' => 'DH-103',
                'service' => 'Gastroenteroloji',
                'diagnosis' => 'Dispepsi & Gastroözofageal Reflü (LA Evre B)',
                'attending_physician' => 'Prof. Dr. Caner Öztürk',
                'alt' => 48,
                'ast' => 42,
                'endoscopy_date' => '02.08.2026'
            ],
            [
                'id' => 804,
                'patient_name' => 'Fatma Yılmaz (82 Yaş)',
                'national_id' => '45678901234',
                'age' => 82,
                'gender' => 'Kadın',
                'room' => 'DH-104',
                'service' => 'Geriatri',
                'diagnosis' => 'Kırılganlık Sendromu (Frailty) & Osteoporoz',
                'attending_physician' => 'Doç. Dr. Selin Arslan',
                'mmse_score' => 24,
                'katz_score' => 5
            ],
            [
                'id' => 805,
                'patient_name' => 'Hasan Çelik',
                'national_id' => '56789012345',
                'age' => 38,
                'gender' => 'Erkek',
                'room' => 'DH-105',
                'service' => 'Hematoloji',
                'diagnosis' => 'Demir Eksikliği Anemisi & Trombositoz',
                'attending_physician' => 'Prof. Dr. Burak Güven',
                'hgb' => 9.2,
                'ferritin' => 6,
                'wbc' => 7.8
            ],
            [
                'id' => 806,
                'patient_name' => 'Elif Doğan',
                'national_id' => '67890123456',
                'age' => 29,
                'gender' => 'Kadın',
                'room' => 'DH-106',
                'service' => 'İmmünoloji ve Alerji',
                'diagnosis' => 'Kronik Spontan Ürtiker & Spesifik Alerjik Rinit',
                'attending_physician' => 'Uzm. Dr. Merve Tunç',
                'total_ige' => 340,
                'prick_positive' => 'Akar & Poleni'
            ],
            [
                'id' => 807,
                'patient_name' => 'Ali Şahin (Maden İşçisi)',
                'national_id' => '78901234567',
                'age' => 47,
                'gender' => 'Erkek',
                'room' => 'DH-107',
                'service' => 'İş ve Meslek Hastalıkları',
                'diagnosis' => 'Silikozis Şüphesi & ILO Pnömokonyoz Evreleme',
                'attending_physician' => 'Uzm. Dr. Kemal Vural',
                'ilo_category' => '1/1 q/t',
                'fev1_fvc' => 68
            ],
            [
                'id' => 808,
                'patient_name' => 'Emine Aktaş',
                'national_id' => '89012345678',
                'age' => 66,
                'gender' => 'Kadın',
                'room' => 'DH-108',
                'service' => 'Nefroloji',
                'diagnosis' => 'Evre 3B Kronik Böbrek Hastalığı (CKD-EPI eGFR 42)',
                'attending_physician' => 'Prof. Dr. Murat Tekin',
                'creatinine' => 1.8,
                'egfr' => 42,
                'proteinuria' => '850 mg/24h'
            ],
            [
                'id' => 809,
                'patient_name' => 'Veli Eren',
                'national_id' => '90123456789',
                'age' => 51,
                'gender' => 'Erkek',
                'room' => 'DH-109',
                'service' => 'Romatoloji',
                'diagnosis' => 'Seropozitif Romatoid Artrit (DAS28: 4.8 Yüksek Aktivite)',
                'attending_physician' => 'Prof. Dr. Hande Köse',
                'das28' => 4.8,
                'anti_ccp' => '>200 U/mL',
                'esr' => 45
            ],
            [
                'id' => 810,
                'patient_name' => 'Süleyman Karaca',
                'national_id' => '01234567890',
                'age' => 59,
                'gender' => 'Erkek',
                'room' => 'DH-110',
                'service' => 'Tıbbi Onkoloji',
                'diagnosis' => 'Kolorektal Ca (Stage III - pT3N1M0) Kemoterapi',
                'attending_physician' => 'Prof. Dr. İbrahim Yıldız',
                'ecog' => 1,
                'chemo_cycle' => 'FOLFOX6 4. Kür'
            ]
        ];

        if (!session()->has('internal_medicine_admissions')) {
            session(['internal_medicine_admissions' => $defaultAdmissions]);
        }

        $internalAdmissions = session('internal_medicine_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($internalAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($internalAdmissions) > 0) {
            $selectedAdmission = reset($internalAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $internalExams = session('internal_medicine_exams', []);

        return compact(
            'internalAdmissions',
            'selectedAdmission',
            'selectedId',
            'internalExams',
            'activeSubKey'
        );
    }
}
