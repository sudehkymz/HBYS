<?php

namespace App\Modules\RadiationOncology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RadiationOncologyController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 901,
                'patient_name' => 'Kadir Alkan',
                'national_id' => '10293847591',
                'age' => 58,
                'gender' => 'Erkek',
                'room' => 'RAD-101 (LINAC 1)',
                'service' => 'Radyasyon Onkolojisi (VMAT / IMRT)',
                'diagnosis' => 'Evre III Yassı Hücreli Baş-Boyun Ca & Eş Zamanlı Kemoradyoterapi (70 Gy VMAT)',
                'attending_physician' => 'Prof. Dr. Tayfun Özcan',
                'linac_dose' => '22. Fraksiyon / 35 Fraksiyon (Toplam 70 Gy, 2 Gy/Fraksiyon)',
                'technique' => 'VMAT (Volumetric Modulated Arc Therapy) + Termoplastik Maske Fiksasyonu',
                'toxicity' => 'Grade 2 Mukozit & Derece 1 Radyodermatit (Topikal Krem Protokolü)'
            ],
            [
                'id' => 902,
                'patient_name' => 'Fizze Toprak',
                'national_id' => '21039485702',
                'age' => 64,
                'gender' => 'Kadın',
                'room' => 'RAD-102 (CyberKnife)',
                'service' => 'Radyasyon Onkolojisi (SRS / CyberKnife)',
                'diagnosis' => 'Sol Parietal Glioblastoma (GBM) Tekrarlayan Soliter Lezyon & CyberKnife SRS',
                'attending_physician' => 'Doç. Dr. Pınar Solmaz',
                'linac_dose' => 'Stereotaktik Radyocerrahi (SRS 24 Gy Tek Doz / CyberKnife)',
                'technique' => 'Sub-Milimetrik CyberKnife Hedefleme (GTV: 14.2 cm³)',
                'oar_constraints' => 'Optik Kiazma Dmax < 8 Gy (Güvenlik Sınırı Korundu)'
            ],
            [
                'id' => 903,
                'patient_name' => 'Harun Demirci',
                'national_id' => '32140596813',
                'age' => 71,
                'gender' => 'Erkek',
                'room' => 'RAD-103 (SBRT)',
                'service' => 'Radyasyon Onkolojisi (SBRT)',
                'diagnosis' => 'Evre I Akciğer Karsinomu (Periferik Nodül) & SBRT (Hipofraksiyone Radyoterapi)',
                'attending_physician' => 'Prof. Dr. Tayfun Özcan',
                'linac_dose' => '3. Fraksiyon / 5 Fraksiyon (Toplam 50 Gy, 10 Gy/Fraksiyon)',
                'technique' => 'SBRT (Stereotactic Body Radiation Therapy) + 4D-BT Solunum Kapısı',
                'oar_constraints' => 'Göğüs Duvarı V30 < 30 cm³ (Kot Kırığı Riski Düşük)'
            ],
            [
                'id' => 904,
                'patient_name' => 'Leman Şen',
                'national_id' => '43251607924',
                'age' => 52,
                'gender' => 'Kadın',
                'room' => 'RAD-104 (Brakiterapi)',
                'service' => 'Radyasyon Onkolojisi (HDR Brakiterapi)',
                'diagnosis' => 'Evre IIB Serviks Karsinomu & Yüksek Doz Hızlı (HDR) Brakiterapi',
                'attending_physician' => 'Uzm. Dr. Melis Eren',
                'brachy_dose' => '3. Seans / 4 Seans HDR Brakiterapi (7 Gy / Seans Ir-192 Kaynak)',
                'technique' => 'Tandem-Ring Aplikatör Simülasyonu & 3D-BT Dozimetre',
                'oar_constraints' => 'Rektum D2cc < 65 Gy, Mesane D2cc < 75 Gy'
            ],
            [
                'id' => 905,
                'patient_name' => 'Refik Karaca',
                'national_id' => '54362718035',
                'age' => 69,
                'gender' => 'Erkek',
                'room' => 'RAD-105',
                'service' => 'Radyasyon Onkolojisi (Prostat IMRT)',
                'diagnosis' => 'Orta Risk Prostat Adenokarsinomu & Hipofraksiyone IMRT Radyoterapi',
                'attending_physician' => 'Doç. Dr. Pınar Solmaz',
                'linac_dose' => '18. Fraksiyon / 20 Fraksiyon (Toplam 60 Gy, 3 Gy/Fraksiyon)',
                'technique' => 'IGRT (Image-Guided Radiotherapy) + Altın Markör İşaretleme',
                'toxicity' => 'Grade 1 İdrar Sıkışması (Ürolojik Semptomsuz)'
            ]
        ];

        if (!session()->has('radiation_admissions')) {
            session(['radiation_admissions' => $defaultAdmissions]);
        }

        $radAdmissions = session('radiation_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($radAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($radAdmissions) > 0) {
            $selectedAdmission = reset($radAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $radExams = session('radiation_exams', []);

        return view('modules.radiation_oncology.index', compact(
            'radAdmissions',
            'selectedAdmission',
            'selectedId',
            'radExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('radiation_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Tayfun Özcan',
            'date' => date('d.m.Y H:i')
        ];

        session(['radiation_exams' => $exams]);

        return redirect()->route('radiation_oncology.index', ['admission_id' => $admissionId])
            ->with('success', 'Radyasyon Onkolojisi muayene kaydı, LINAC fraksiyon dozu ve simülasyon planı kaydedildi.');
    }
}
