<?php

namespace App\Modules\Pulmonology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PulmonologyController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 301,
                'patient_name' => 'Kazım Aydan',
                'national_id' => '10293847192',
                'age' => 67,
                'gender' => 'Erkek',
                'room' => 'GH-101 (NIV Odası)',
                'service' => 'Göğüs Hastalıkları Polikliniği',
                'diagnosis' => 'Evre 3 Ağır KOAH (GOLD Grubu E) Akut Atak & BiPAP Solunum Desteği',
                'attending_physician' => 'Prof. Dr. Ahmet Bilgin',
                'sft_fev1' => 'FEV1: %42 Beklenen, FEV1/FVC: %54 (Ağır Obstrüksiyon)',
                'blood_gas' => 'pH: 7.31, PaCO2: 58 mmHg, PaO2: 56 mmHg, SaO2: %88 (Tip 2 Solunum Yetmezliği)',
                'niv_setting' => 'BiPAP (IPAP: 14 cmH2O, EPAP: 5 cmH2O, FiO2: %35)'
            ],
            [
                'id' => 302,
                'patient_name' => 'Elif Demir',
                'national_id' => '21304958203',
                'age' => 31,
                'gender' => 'Kadın',
                'room' => 'GH-102',
                'service' => 'Göğüs Hastalıkları Polikliniği',
                'diagnosis' => 'Orta Derece Persiste Astım & Bronkodilatör Reverzibilite Testi',
                'attending_physician' => 'Doç. Dr. Sibel Aslan',
                'reversibility' => 'Post-Salbutamol FEV1 Artışı: +340 mL (+%18 Artış - Reverzibilite Pozitif)',
                'act_score' => 'Astım Kontrol Testi (ACT): 14 / 25 (Kontrolsüz Astım)',
                'inhaler_med' => 'ICS/LABA (Budesonid/Formoterol 200/6 mcg 2x2)'
            ],
            [
                'id' => 303,
                'patient_name' => 'Celal Varol',
                'national_id' => '32415069314',
                'age' => 54,
                'gender' => 'Erkek',
                'room' => 'GH-103 (Uyku Lab)',
                'service' => 'Göğüs Hastalıkları (Uyku Laboratuvarı)',
                'diagnosis' => 'Ağır Obstrüktif Uyku Apne Sendromu (OSAS) & CPAP Titrasyonu',
                'attending_physician' => 'Prof. Dr. Ahmet Bilgin',
                'ahi_score' => 'Apne-Hipopne İndeksi (AHİ): 38.4 / Saat (Şiddetli OSAS)',
                'desaturation' => 'En Düşük SpO2: %74, Gece Boyu Desatürasyon Süresi: 48 Dk',
                'cpap_pressure' => 'Optimum CPAP Basıncı: 9.5 cmH2O (Auto-CPAP Önerildi)'
            ],
            [
                'id' => 304,
                'patient_name' => 'Muzaffer Çelik',
                'national_id' => '43526170425',
                'age' => 61,
                'gender' => 'Erkek',
                'room' => 'GH-104',
                'service' => 'Göğüs Hastalıkları Polikliniği',
                'diagnosis' => 'Eksuda Niteliğinde Plevral Efüzyon & Diagnostik Torasentez İşlemi',
                'attending_physician' => 'Uzm. Dr. Kemal Tunç',
                'pleural_fluid' => 'Plevra Sıvısı/Serum Protein: 0.68, LDH: 340 U/L (Light Kriterleri Exudate)',
                'ada_level' => 'Plevra Sıvısı ADA (Adenozin Deaminaz): 18 U/L (Tüberküloz Ekarte Edildi)',
                'cytology' => 'Lenfosit Dominant Sıvı (Sitolojik Malignite Araştırması Sürüyor)'
            ],
            [
                'id' => 305,
                'patient_name' => 'Rukiye Kaya',
                'national_id' => '54637281536',
                'age' => 58,
                'gender' => 'Kadın',
                'room' => 'GH-105',
                'service' => 'Göğüs Hastalıkları (Sigara Bırakma Poli)',
                'diagnosis' => 'İdiyopatik Pulmoner Fibrozis (İPF) & Sigara Bırakma Poliklinik Takibi',
                'attending_physician' => 'Doç. Dr. Sibel Aslan',
                'dlco_score' => 'DLCO (Diffüzyon Kapasitesi): %48 Beklenen (Ağır Restriksiyon)',
                'fagerstrom' => 'Fagerström Nikotin Bağımlılık Skoru: 7 / 10 (Yüksek Bağımlılık)',
                'antifibrotic' => 'Antifibrotik Tedavi (Pirfenidon 267mg 3x3)'
            ]
        ];

        if (!session()->has('pulmonology_admissions')) {
            session(['pulmonology_admissions' => $defaultAdmissions]);
        }

        $pulmAdmissions = session('pulmonology_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($pulmAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($pulmAdmissions) > 0) {
            $selectedAdmission = reset($pulmAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $pulmExams = session('pulmonology_exams', []);

        return view('modules.pulmonology.index', compact(
            'pulmAdmissions',
            'selectedAdmission',
            'selectedId',
            'pulmExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('pulmonology_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Ahmet Bilgin',
            'date' => date('d.m.Y H:i')
        ];

        session(['pulmonology_exams' => $exams]);

        return redirect()->route('pulmonology.index', ['admission_id' => $admissionId])
            ->with('success', 'Göğüs Hastalıkları muayene kaydı, SFT değerleri ve kan gazı analizi kaydedildi.');
    }
}
