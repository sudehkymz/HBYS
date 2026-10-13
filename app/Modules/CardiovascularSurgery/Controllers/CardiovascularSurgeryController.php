<?php

namespace App\Modules\CardiovascularSurgery\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardiovascularSurgeryController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 2001,
                'patient_name' => 'Hikmet Yıldırım',
                'national_id' => '10293848581',
                'age' => 64,
                'gender' => 'Erkek',
                'room' => 'KDC-Ameliyathane 1',
                'service' => 'Kalp ve Damar Cerrahisi',
                'diagnosis' => 'Üç Damar Koroner Arter Hastalığı (CAD) & Açık Kalp CABG (Saphenous / LIMA Greft)',
                'attending_physician' => 'Prof. Dr. Tayfun Gürbüz',
                'bypass_metrics' => 'KPA Ekstrakorporeal Dolaşım: Klemens Zamanı 68 Dk, Perfüzyon Süresi 95 Dk',
                'graft_details' => 'LIMA -> LAD Grefti, Saphenous -> Cx ve RCA Greftleri (Flowmeter Kontrolü Uyumlu)',
                'post_op_icu' => 'KDC Yoğun Bakım Entübe Takip (Inotropik İntra-Aortik Balon Pompası IABP Standby)'
            ],
            [
                'id' => 2002,
                'patient_name' => 'Naciye Keskin',
                'national_id' => '21039486692',
                'age' => 72,
                'gender' => 'Kadın',
                'room' => 'KDC-Ameliyathane 2',
                'service' => 'Kalp ve Damar Cerrahisi',
                'diagnosis' => 'Şiddetli Aort Darlığı & Transkateter Aort Kapak İmplantasyonu (TAVI) / AVR',
                'attending_physician' => 'Prof. Dr. Tayfun Gürbüz',
                'valve_metrics' => 'Aort Kapak Gradiyenti: Peak 72 mmHg, Mean 44 mmHg (AVA: 0.65 cm²)',
                'tavi_procedure' => 'Femoral Yolla 26mm Biyoprotez Aort Kapak Başarıyla Yerleştirildi',
                'post_op_icu' => 'TAVI Sonrası Aort Yetersizliği / Kaçak Yok (Paravalvüler Leaksiz)'
            ]
        ];

        if (!session()->has('kdc_admissions')) {
            session(['kdc_admissions' => $defaultAdmissions]);
        }

        $kdcAdmissions = session('kdc_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($kdcAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($kdcAdmissions) > 0) {
            $selectedAdmission = reset($kdcAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $kdcExams = session('kdc_exams', []);

        return view('modules.cardiovascular_surgery.index', compact(
            'kdcAdmissions',
            'selectedAdmission',
            'selectedId',
            'kdcExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('kdc_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Tayfun Gürbüz',
            'date' => date('d.m.Y H:i')
        ];

        session(['kdc_exams' => $exams]);

        return redirect()->route('cardiovascular_surgery.index', ['admission_id' => $admissionId])
            ->with('success', 'Kalp ve Damar Cerrahisi ameliyat notu başarıyla kaydedildi.');
    }
}
