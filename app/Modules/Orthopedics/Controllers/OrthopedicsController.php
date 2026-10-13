<?php

namespace App\Modules\Orthopedics\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrthopedicsController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.orthopedics.subspecialties.general', $context);
    }

    public function handSurgery(Request $request)
    {
        $context = $this->getPatientContext($request, 'hand_surgery');
        return view('modules.orthopedics.subspecialties.hand_surgery', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);
        $redirectRoute = $request->input('redirect_route', 'orthopedics.index');

        $exams = session('orthopedics_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Zafer Alp',
            'date' => date('d.m.Y H:i')
        ];

        session(['orthopedics_exams' => $exams]);

        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Ortopedi ve Travmatoloji muayene ve cerrahi kaydı kaydedildi.');
    }

    private function getPatientContext(Request $request, string $activeSubKey)
    {
        $defaultAdmissions = [
            [
                'id' => 2201,
                'patient_name' => 'Ahmet Çelik',
                'national_id' => '10293848703',
                'age' => 62,
                'gender' => 'Erkek',
                'room' => 'ORT-101 (Arthroplasty)',
                'service' => 'Ortopedi ve Travmatoloji (Ana Branş)',
                'diagnosis' => 'Primer İleri Evre Gonartroz & Total Diz Protezi (TKA Arthroplasty)',
                'attending_physician' => 'Prof. Dr. Zafer Alp',
                'xray_metrics' => 'Direkt Grafi: Kellgren-Lawrence Evre 4 Eklem Aralığı Daralması & Osteofitler',
                'implant_detail' => 'Çimentolu Posterior Stabilize (PS) Total Diz Protezi İmplantasyonu',
                'rehab_status' => 'Post-Op 1. Gün CPM (Continuous Passive Motion) 0-90° ve Yürüteç İle Mobilizasyon'
            ],
            [
                'id' => 2202,
                'patient_name' => 'Mustafa Avcı',
                'national_id' => '21039486814',
                'age' => 31,
                'gender' => 'Erkek',
                'room' => 'ORT-102 (El Cerrahisi Birimi)',
                'service' => 'El Cerrahisi (Ortak Yan Dal)',
                'diagnosis' => 'Akut Sağ 2. ve 3. Parmak Tam Dijital Amputasyon & Mikrovasküler Replantasyon Cerrahisi',
                'attending_physician' => 'Doç. Dr. Barış Soner (El Cerrahisi Uzmanı)',
                'microsurgery_metrics' => 'Mikroskop Altında Dijital Arter & Ven Anastomozu (10-0 Prolene) + Dijital Sinir Tamiri',
                'bone_fixation' => 'K-Teli (Kirschner) İle Aksiyel Kemik Fiksasyonu + Fleksör Tendon Primer Sütürü',
                'capillary_refill' => 'Kapiller Geri Dolum Süresi: 1.5 sn (Pembeden Kanama Pozitif, Canlı)'
            ]
        ];

        if (!session()->has('ortho_admissions')) {
            session(['ortho_admissions' => $defaultAdmissions]);
        }

        $orthoAdmissions = session('ortho_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($orthoAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($orthoAdmissions) > 0) {
            $selectedAdmission = reset($orthoAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $orthoExams = session('orthopedics_exams', []);

        return compact(
            'orthoAdmissions',
            'selectedAdmission',
            'selectedId',
            'orthoExams',
            'activeSubKey'
        );
    }
}
