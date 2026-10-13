<?php

namespace App\Modules\Cardiology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardiologyController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 201,
                'patient_name' => 'Fehmi Özkan',
                'national_id' => '10928374651',
                'age' => 62,
                'gender' => 'Erkek',
                'room' => 'KRD-101 (Yoğun Bakım)',
                'service' => 'Kardiyoloji Polikliniği / Anjiyo Lab',
                'diagnosis' => 'Ön Duvar STEMI Post-Primer PCI (LAD Ortasına DES Stent) & DAPT Takibi',
                'attending_physician' => 'Prof. Dr. Murat Can',
                'lvef' => 'LVEF: %45 (Orta Düzey Sol Ventrikül Disfonksiyonu)',
                'troponin' => 'hs-Troponin I: 4850 ng/L (Kardiyak Enzim Yüksekliği)',
                'stent_info' => 'LAD Mid segment 3.5x24mm Drug-Eluting Stent (DES) İmplantasyonu'
            ],
            [
                'id' => 202,
                'patient_name' => 'Nebahat Arslan',
                'national_id' => '21039485762',
                'age' => 74,
                'gender' => 'Kadın',
                'room' => 'KRD-102',
                'service' => 'Kardiyoloji Polikliniği',
                'diagnosis' => 'Kronik Kalp Yetersizliği (Düşük EF - HFrEF NYHA Evre III) & CRT-D Pil Takibi',
                'attending_physician' => 'Doç. Dr. Deniz Alp',
                'lvef' => 'LVEF: %32 (Ağır Düşük Ejeksiyon Fraksiyonu)',
                'nt_probnp' => 'NT-proBNP: 6400 pg/mL (Dekompanse Kalp Yetersizliği)',
                'icd_check' => 'CRT-D Kalp Pili Batarya Voltajı Uygun, %98 Ventriküler Pacing'
            ],
            [
                'id' => 203,
                'patient_name' => 'Kemal Soylu',
                'national_id' => '32140596873',
                'age' => 68,
                'gender' => 'Erkek',
                'room' => 'KRD-103',
                'service' => 'Kardiyoloji Polikliniği',
                'diagnosis' => 'Paroksismal Atriyal Fibrilasyon (AF) & CHA2DS2-VASc Puanlaması (Oral Antikoagülan)',
                'attending_physician' => 'Prof. Dr. Murat Can',
                'cha2ds2_score' => 'CHA2DS2-VASc Skoru: 4 Puan (Yüksek İnme Riski)',
                'holter_result' => '24h EKG Holter: Toplam 42 AF Atak Süresi (En Uzun Atak 48 Dk)',
                'anticoagulant' => 'DOAC Antikoagülan (Apiksaban 5mg 2x1)'
            ],
            [
                'id' => 204,
                'patient_name' => 'Şerife Yıldız',
                'national_id' => '43251607984',
                'age' => 79,
                'gender' => 'Kadın',
                'room' => 'KRD-104',
                'service' => 'Kardiyoloji Polikliniği',
                'diagnosis' => 'Ağır Degeneratif Aort Darlığı (Aort Kapak Alanı AVA < 1.0 cm²) & TAVI Konseyi',
                'attending_physician' => 'Uzm. Dr. Burak Kaya',
                'eko_ava' => 'EKO Aort Kapak Alanı (AVA): 0.75 cm², Ortalama Gradyan: 48 mmHg',
                'pasps' => 'Patojik Pulmoner Arter Basıncı (PASP): 45 mmHg',
                'tavi_decision' => 'Transkateter Aort Kapak İmplantasyonu (TAVI) Konsey Kararı Alındı'
            ],
            [
                'id' => 205,
                'patient_name' => 'Turgut Efe',
                'national_id' => '54362718095',
                'age' => 55,
                'gender' => 'Erkek',
                'room' => 'KRD-105',
                'service' => 'Kardiyoloji Polikliniği',
                'diagnosis' => 'Dirençli Esansiyel Hipertansiyon & 24 Saatlik Tansiyon Holter Monitorizasyonu',
                'attending_physician' => 'Doç. Dr. Deniz Alp',
                'abpm_result' => '24h Tansiyon Holter Ortam: 158/98 mmHg (Non-Dipper Profili)',
                'medication' => 'Üçlü Kombinasyon Antihipertansif (Olmesartan/Amlodipin/HCTZ)'
            ]
        ];

        if (!session()->has('cardiology_admissions')) {
            session(['cardiology_admissions' => $defaultAdmissions]);
        }

        $cardAdmissions = session('cardiology_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($cardAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($cardAdmissions) > 0) {
            $selectedAdmission = reset($cardAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $cardExams = session('cardiology_exams', []);

        return view('modules.cardiology.index', compact(
            'cardAdmissions',
            'selectedAdmission',
            'selectedId',
            'cardExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('cardiology_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Murat Can',
            'date' => date('d.m.Y H:i')
        ];

        session(['cardiology_exams' => $exams]);

        return redirect()->route('cardiology.index', ['admission_id' => $admissionId])
            ->with('success', 'Kardiyoloji muayene kaydı, EKO ölçümleri ve anjiyografi bulguları kaydedildi.');
    }
}
