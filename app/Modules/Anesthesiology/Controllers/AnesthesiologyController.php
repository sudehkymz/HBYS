<?php

namespace App\Modules\Anesthesiology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnesthesiologyController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.anesthesiology.subspecialties.general', $context);
    }

    public function algology(Request $request)
    {
        $context = $this->getPatientContext($request, 'algology');
        return view('modules.anesthesiology.subspecialties.algology', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);
        $redirectRoute = $request->input('redirect_route', 'anesthesiology.index');

        $exams = session('anesthesiology_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Vedat Orhan',
            'date' => date('d.m.Y H:i')
        ];

        session(['anesthesiology_exams' => $exams]);

        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Anesteziyoloji pre-op değerlendirmesi veya Algoloji ağrı bloğu başarıyla kaydedildi.');
    }

    private function getPatientContext(Request $request, string $activeSubKey)
    {
        $defaultAdmissions = [
            [
                'id' => 2501,
                'patient_name' => 'Şükrü Arslan',
                'national_id' => '10293849036',
                'age' => 58,
                'gender' => 'Erkek',
                'room' => 'ANS-101 (Pre-Op Anestezi)',
                'service' => 'Anesteziyoloji ve Reanimasyon (Ana Branş)',
                'diagnosis' => 'Pre-Op Anesteziyolojik Değerlendirme (ASA III Skoru, Zor Havayolu Mallampati 3)',
                'attending_physician' => 'Prof. Dr. Vedat Orhan',
                'asa_score' => 'ASA III (Sistemik Şiddetli Hastalık: DM + HT + Geçirilmiş MI)',
                'airway_eval' => 'Mallampati Skoru: Evre 3 (Tiromental Mesafe: 5.5 cm - Videolaringoskop Hazırlandı)',
                'anesthesia_plan' => 'Kombine Genel Anestezi + Endotrakeal Entübasyon & Ultrason Rehberliğinde TAP Blok'
            ],
            [
                'id' => 2502,
                'patient_name' => 'Hamide Korkmaz',
                'national_id' => '21039487147',
                'age' => 66,
                'gender' => 'Kadın',
                'room' => 'ANS-102 (Algoloji Ağrı Klinigi)',
                'service' => 'Algoloji (Ağrı Polikliniği - Yan Dal)',
                'diagnosis' => 'Kronik Bel ve Bacak Ağrısı (L5-S1 Radikülopati) & Skopi Rehberliğinde Transforaminal Epidural Enjeksiyon',
                'attending_physician' => 'Doç. Dr. Nesrin Başar (Algoloji Uzmanı)',
                'pain_score' => 'Görsel Ağrı Skalası (VAS): 8/10 (Şiddetli Nöropatik Ağrı)',
                'algology_procedure' => 'C-Kollu Skopi Altında Sol L5-S1 Transforaminal Epidural Steroid + Lokal Anestezi Blokajı',
                'radiofrequency' => 'L4-L5 Facet Eklem Radyofrekans Termokoagülasyon (RF Rizoctomy) Uygulandı'
            ]
        ];

        if (!session()->has('ans_admissions')) {
            session(['ans_admissions' => $defaultAdmissions]);
        }

        $ansAdmissions = session('ans_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($ansAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($ansAdmissions) > 0) {
            $selectedAdmission = reset($ansAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $ansExams = session('anesthesiology_exams', []);

        return compact(
            'ansAdmissions',
            'selectedAdmission',
            'selectedId',
            'ansExams',
            'activeSubKey'
        );
    }
}
