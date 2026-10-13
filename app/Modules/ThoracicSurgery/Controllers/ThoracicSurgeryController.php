<?php

namespace App\Modules\ThoracicSurgery\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThoracicSurgeryController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 1601,
                'patient_name' => 'Turgut Özkan',
                'national_id' => '10293848141',
                'age' => 64,
                'gender' => 'Erkek',
                'room' => 'GĞS-101 (VATS Ameliyathane)',
                'service' => 'Göğüs Cerrahisi (Akciğer Onkolojisi)',
                'diagnosis' => 'Sağ Üst Lob Akciğer Adenokarsinomu & VATS Anatomi Lobektomi + Sistemik Mediastinal Lenf Nodu Dissection',
                'attending_physician' => 'Prof. Dr. Semih Halezeroğlu',
                'vats_technique' => 'VATS (Video-Assisted Thoracoscopic Surgery) 2 Port Minimal İnvaziv',
                'chest_tube' => 'Göğüs Tüpü (Bülau Dren): 120 ml/gün Seröz Mayi',
                'air_leak' => 'Su Sualtı Drenajı Hava Kaçağı: Yok (Grade 0 Derece Kaçak Sızdırmaz)',
                'fev1_score' => 'Pre-op SFT FEV1: %82 (Kardiyopulmoner Rezeksiyon Toleransı İyi)'
            ],
            [
                'id' => 1602,
                'patient_name' => 'Caner Güneş',
                'national_id' => '21039486252',
                'age' => 22,
                'gender' => 'Erkek',
                'room' => 'GĞS-102 (Acil Göğüs Servisi)',
                'service' => 'Göğüs Cerrahisi (Acil Toraks)',
                'diagnosis' => 'Primer Spontan Pnömotoraks (Sağ Akciğer Kollapsı %60) & Göğüs Tüpü Torakostomi',
                'attending_physician' => 'Doç. Dr. Erkan Kaba',
                'vats_technique' => 'Açık Göğüs Tüpü Torakostomi (28 Fr Silikon Bülau Dren)',
                'chest_tube' => 'Su Altı Drenaj Şişesi Serbest Akışta',
                'air_leak' => 'Hava Kaçağı: Grade 1 (Öksürmekle Minimal Bubbling Var)',
                'fev1_score' => 'Akciğer Expande Oldu (Akciğer Parankimi Göğüs Duvarına Yapışık)'
            ],
            [
                'id' => 1603,
                'patient_name' => 'Fizze Soylu',
                'national_id' => '32140597363',
                'age' => 38,
                'gender' => 'Kadın',
                'room' => 'GĞS-103 (Mediastinal Cerrahi)',
                'service' => 'Göğüs Cerrahisi (Mediasten)',
                'diagnosis' => 'Anterior Mediastinal Timoma & RATS (Robotik Göğüs Cerrahisi) Total Timektomi',
                'attending_physician' => 'Prof. Dr. Semih Halezeroğlu',
                'vats_technique' => 'RATS (Robot-Assisted Thoracoscopic Surgery) da Vinci Xi Robotik Sistem',
                'chest_tube' => 'Sol Plevral Dren: 50 ml/gün (Berrak)',
                'air_leak' => 'Hava Kaçağı: Yok (Pnömotoraks Yok)',
                'fev1_score' => 'Myasthenia Gravis Semptomlarında Gerileme Sağlandı'
            ],
            [
                'id' => 1604,
                'patient_name' => 'Kadir Alkan',
                'national_id' => '43251608474',
                'age' => 58,
                'gender' => 'Erkek',
                'room' => 'GĞS-104 (Plevra & Empiyem)',
                'service' => 'Göğüs Cerrahisi (Plevral Hastalıklar)',
                'diagnosis' => 'Organize Plevral Empiyem (Fibrinopürülan Evre) & VATS Plevral Dekortikasyon',
                'attending_physician' => 'Doç. Dr. Erkan Kaba',
                'vats_technique' => 'VATS Plevral Dekortikasyon & Plevra Yıkaması',
                'chest_tube' => '2 Adet Göğüs Tüpü (Apikal & Bazal): 180 ml/gün Seropürülan',
                'air_leak' => 'Hava Kaçağı: Minimal (Ekspansiyon Tam)'
            ],
            [
                'id' => 1605,
                'patient_name' => 'Nihat Arslan',
                'national_id' => '54362719585',
                'age' => 67,
                'gender' => 'Erkek',
                'room' => 'GĞS-105 (Bronkoskopi Ünitesi)',
                'service' => 'Göğüs Cerrahisi (Girişimsel Bronkoskopi)',
                'diagnosis' => 'Sağ Ana Bronş Tümöral Obstrüksiyon & Rijit Bronkoskopi Kriyoterapi + Y-Stent',
                'attending_physician' => 'Uzm. Dr. Burak Göksel',
                'vats_technique' => 'Rijit Bronkoskopi + Kriyorezeksiyon & Silikon Hava Yolu Stenti',
                'chest_tube' => 'Göğüs Tüpü Gerekmedi (Endobronşiyal Müdahale)',
                'air_leak' => 'Hava Yolu Açıklığı %90 Sağlandı'
            ]
        ];

        if (!session()->has('thoracic_admissions')) {
            session(['thoracic_admissions' => $defaultAdmissions]);
        }

        $tsAdmissions = session('thoracic_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($tsAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($tsAdmissions) > 0) {
            $selectedAdmission = reset($tsAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $tsExams = session('thoracic_exams', []);

        return view('modules.thoracic_surgery.index', compact(
            'tsAdmissions',
            'selectedAdmission',
            'selectedId',
            'tsExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('thoracic_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Semih Halezeroğlu',
            'date' => date('d.m.Y H:i')
        ];

        session(['thoracic_exams' => $exams]);

        return redirect()->route('thoracic_surgery.index', ['admission_id' => $admissionId])
            ->with('success', 'Göğüs Cerrahisi operasyon ve göğüs tüpü hava kaçağı takibi onaylandı.');
    }
}
