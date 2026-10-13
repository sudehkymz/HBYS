<?php

namespace App\Modules\Obgyn\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObgynController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.obgyn.subspecialties.general', $context);
    }

    public function perinatology(Request $request)
    {
        $context = $this->getPatientContext($request, 'perinatology');
        return view('modules.obgyn.subspecialties.perinatology', $context);
    }

    public function gynOncology(Request $request)
    {
        $context = $this->getPatientContext($request, 'gyn_oncology');
        return view('modules.obgyn.subspecialties.gyn_oncology', $context);
    }

    public function ivf(Request $request)
    {
        $context = $this->getPatientContext($request, 'ivf');
        return view('modules.obgyn.subspecialties.ivf', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);
        $redirectRoute = $request->input('redirect_route', 'obgyn.index');

        $exams = session('obgyn_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Ayşe Şevket',
            'date' => date('d.m.Y H:i')
        ];

        session(['obgyn_exams' => $exams]);

        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Kadın Hastalıkları ve Doğum muayenesi ve ultrason takibi kaydedildi.');
    }

    private function getPatientContext(Request $request, string $activeSubKey)
    {
        $defaultAdmissions = [
            [
                'id' => 1801,
                'patient_name' => 'Gamze Aksoy',
                'national_id' => '10293848361',
                'age' => 29,
                'gender' => 'Kadın',
                'room' => 'KDG-101 (Obstetrik USG)',
                'service' => 'Kadın Hastalıkları ve Doğum (Ana Branş)',
                'diagnosis' => '32. Haftalık Gebelik Takibi & Obstetrik USG Biometri (EFW 1950gr, NST Reaktif)',
                'attending_physician' => 'Prof. Dr. Ayşe Şevket',
                'ga_weeks' => 'Gestasyonel Hafta: 32 Hafta 4 Gün (Son Adet Tarihi SAT Uyumlu)',
                'usg_metrics' => 'BPD: 82mm, FL: 61mm, AC: 278mm (EFW Tahmini Bebek Ağırlığı: 1950 gram)',
                'nst_status' => 'NST (Non-Stres Test): Reaktif (Fetal Kalp Hızı 142 atım/dk, Akselerasyon +)'
            ],
            [
                'id' => 1802,
                'patient_name' => 'Merve Karaca',
                'national_id' => '21039486472',
                'age' => 34,
                'gender' => 'Kadın',
                'room' => 'KDG-102 (Perinatoloji Birimi)',
                'service' => 'Perinatoloji (Riskli Gebelik)',
                'diagnosis' => 'Preeklampsi & Fetal Büyüme Kısıtlılığı (IUGR) Doppler USG İncelemesi',
                'attending_physician' => 'Prof. Dr. Ayşe Şevket',
                'doppler_usg' => 'Uterin & Umbilikal Arter Doppler: Pulsatilite İndeksi (PI) Artmış, Diastolik Akım Açık',
                'bp_monitoring' => 'Kan Basıncı: 150/95 mmHg (24 Saatlik İdrarda Proteinüri: 450 mg/gün)',
                'nst_status' => 'Günde 2 Kez NST & Biyofizik Profil (BPP Skoru: 8/10)'
            ],
            [
                'id' => 1803,
                'patient_name' => 'Fatma Özkan',
                'national_id' => '32140597583',
                'age' => 52,
                'gender' => 'Kadın',
                'room' => 'KDG-103 (Jinekolojik Onkoloji)',
                'service' => 'Jinekolojik Onkoloji Cerrahisi',
                'diagnosis' => 'Endometrium Adenokarsinomu (Evre IA) & Laparoskopik Total Abdominal Histerektomi (TAH-BSO)',
                'attending_physician' => 'Doç. Dr. Selen Turgut',
                'pap_smear' => 'Biyopsi: Endometrioid Tip Adenokarsinom (Grade 1)',
                'surgical_plan' => 'Laparoskopik TAH + Bilateral Salpingo-Ooforektomi + Pelvik Lenf Nodu Biyopsisi',
                'tumor_markers' => 'CA-125: 22 U/mL (Normal)'
            ],
            [
                'id' => 1804,
                'patient_name' => 'Zeynep Yıldız',
                'national_id' => '43251608694',
                'age' => 31,
                'gender' => 'Kadın',
                'room' => 'KDG-104 (Tüp Bebek Ünitesi)',
                'service' => 'Tüp Bebek & İnfertilite (IVF)',
                'diagnosis' => 'Primer İnfertilite & İntrasitoplazmik Sperm Enjeksiyonu (ICSI) Yumurta Toplama (OPU)',
                'attending_physician' => 'Uzm. Dr. Burcu Ekin',
                'ivf_follicles' => 'Ultrason Matür Folikül Sayısı: Bilateral 14 Folikül (18-22mm)',
                'opu_retrieval' => 'OPU (Oocyte Pick-Up) İşleminde 12 Matür Oosit Toplandı',
                'embryo_transfer' => '5. Gün Blastokist Embriyo Transferi Planlandı'
            ]
        ];

        if (!session()->has('obgyn_admissions')) {
            session(['obgyn_admissions' => $defaultAdmissions]);
        }

        $obgynAdmissions = session('obgyn_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($obgynAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($obgynAdmissions) > 0) {
            $selectedAdmission = reset($obgynAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $obgynExams = session('obgyn_exams', []);

        return compact(
            'obgynAdmissions',
            'selectedAdmission',
            'selectedId',
            'obgynExams',
            'activeSubKey'
        );
    }
}
