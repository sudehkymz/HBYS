<?php

namespace App\Modules\Psychiatry\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PsychiatryController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.psychiatry.subspecialties.general', $context);
    }

    public function amatem(Request $request)
    {
        $context = $this->getPatientContext($request, 'amatem');
        return view('modules.psychiatry.subspecialties.amatem', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);
        $redirectRoute = $request->input('redirect_route', 'psychiatry.index');

        $exams = session('psychiatry_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Evren Şimşek',
            'date' => date('d.m.Y H:i')
        ];

        session(['psychiatry_exams' => $exams]);

        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Psikiyatri / AMATEM muayene kaydı ve skalaları başarıyla kaydedildi.');
    }

    private function getPatientContext(Request $request, string $activeSubKey)
    {
        $defaultAdmissions = [
            [
                'id' => 801,
                'patient_name' => 'Bora Alpman',
                'national_id' => '10293847501',
                'age' => 41,
                'gender' => 'Erkek',
                'room' => 'PSK-101',
                'service' => 'Ruh Sağlığı ve Hastalıkları (Psikiyatri)',
                'diagnosis' => 'Dirençli Major Depresif Bozukluk & HAM-D Skoru / rTMS Nöromodülasyon',
                'attending_physician' => 'Prof. Dr. Evren Şimşek',
                'hamd_score' => 'HAM-D Skoru: 26 / 52 (Şiddetli Depresif Nöbet)',
                'rtms_session' => '12. Seans Sol DLPFC rTMS (Tekrarlayan Transkraniyal Manyetik Uyarım)',
                'psychiatry_med' => 'Vortioksetin 20mg 1x1 + Lityum 300mg 2x1 (Kan Düzeyi: 0.7 mEq/L)'
            ],
            [
                'id' => 802,
                'patient_name' => 'Selen Güler',
                'national_id' => '21039485612',
                'age' => 29,
                'gender' => 'Kadın',
                'room' => 'PSK-102',
                'service' => 'Ruh Sağlığı ve Hastalıkları (Psikiyatri)',
                'diagnosis' => 'Bipolar Bozukluk Tip 1 (Mani Nöbeti) & Elektrokonvülsif Terapi (EKT)',
                'attending_physician' => 'Doç. Dr. Nesrin Dağ',
                'panss_score' => 'PANSS Skoru: 84 (Pozitif Alevlenme)',
                'ect_session' => '6. Seans Bilateral EKT (Elektroşok Terapi) Başarıyla Uygulandı',
                'psychiatry_med' => 'Olanzapin 15mg/gün + Valproik Asit 1000mg/gün'
            ],
            [
                'id' => 803,
                'patient_name' => 'Zafer Tunç',
                'national_id' => '32140596723',
                'age' => 38,
                'gender' => 'Erkek',
                'room' => 'AMT-101 (AMATEM Servisi)',
                'service' => 'AMATEM (Alkol ve Madde Bağımlılığı Özel Birimi)',
                'diagnosis' => 'Alkol Kullanım Bozukluğu & CIWA-Ar Yoksunluk Taraması / Naltrekson',
                'attending_physician' => 'Prof. Dr. Evren Şimşek',
                'ciwa_score' => 'CIWA-Ar Skoru: 18 (Orta-Şiddetli Alkol Yoksunluğu)',
                'toxicology_panel' => 'İdrar Toksikoloji: Alkol Pozitif, Uyuşturucu Panel Negatif',
                'amatem_med' => 'Naltrekson (Vivitrol 380mg Aylık İntramüsküler Enjeksiyon)'
            ],
            [
                'id' => 804,
                'patient_name' => 'Tarık Keskin',
                'national_id' => '43251607834',
                'age' => 33,
                'gender' => 'Erkek',
                'room' => 'AMT-102 (AMATEM Poliklinik)',
                'service' => 'AMATEM (Alkol ve Madde Bağımlılığı Özel Birimi)',
                'diagnosis' => 'Opiyat Kullanım Bozukluğu & Buprenorfin/Nalokson (Suboxone) İdamesi',
                'attending_physician' => 'Uzm. Dr. Serkan Demir',
                'cows_score' => 'COWS Opiyat Yoksunluk Skoru: 14 (Orta Düzey)',
                'suboxone_dose' => 'Buprenorfın/Nalokson 8mg/2mg Dil Altı Tablet (Günlük 1x1)',
                'court_probation' => 'Denetimli Serbestlik Kararı Kapsamında İdrar Kontrolü Onaylı'
            ],
            [
                'id' => 805,
                'patient_name' => 'Büşra Yıldız',
                'national_id' => '54362718945',
                'age' => 26,
                'gender' => 'Kadın',
                'room' => 'PSK-105',
                'service' => 'Ruh Sağlığı ve Hastalıkları (Yaygın Anksiyete)',
                'diagnosis' => 'Yaygın Anksiyete Bozukluğu (YAB) & Panic Disorder / Bilişsel Davranışçı Terapi',
                'attending_physician' => 'Doç. Dr. Nesrin Dağ',
                'hama_score' => 'HAM-A Anksiyete Skoru: 28 / 56 (Şiddetli Anksiyete)',
                'psychotherapy' => 'Bilişsel Davranışçı Terapi (BDT) 8. Seans Maruz Bırakma Protokolü',
                'psychiatry_med' => 'Escitalopram 20mg 1x1 + Alprazolam 0.5mg (İhtiyaç Halinde)'
            ]
        ];

        if (!session()->has('psychiatry_admissions')) {
            session(['psychiatry_admissions' => $defaultAdmissions]);
        }

        $psychAdmissions = session('psychiatry_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($psychAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($psychAdmissions) > 0) {
            $selectedAdmission = reset($psychAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $psychExams = session('psychiatry_exams', []);

        return compact(
            'psychAdmissions',
            'selectedAdmission',
            'selectedId',
            'psychExams',
            'activeSubKey'
        );
    }
}
