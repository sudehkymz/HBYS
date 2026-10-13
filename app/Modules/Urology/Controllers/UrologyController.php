<?php

namespace App\Modules\Urology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UrologyController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 2401,
                'patient_name' => 'İsmail Tekin',
                'national_id' => '10293848925',
                'age' => 59,
                'gender' => 'Erkek',
                'room' => 'ÜRO-101 (Endoüroloji)',
                'service' => 'Üroloji Polikliniği & Cerrahi',
                'diagnosis' => 'Sol Böbrek Üst Kaliks 18mm Taş & Retrograd İntrarenal Cerrahi (RIRC / Holmiyum Lazer)',
                'attending_physician' => 'Prof. Dr. Birol Yanık',
                'urolithiasis_metrics' => 'BT Ürografi: Sol Böbrek Üst Kalikste 18x12mm 1150 HU Sertlikte Taş',
                'laser_lithotripsy' => 'Fleksibil Üreterorenoskop (f-URS) + Holmiyum:YAG Lazer Dusting (Tozlama) 0.6J / 20Hz',
                'stent_placement' => 'Sol Böbreğe 6 Fr 26 cm Double-J (DJ) Stent Başarıyla Takıldı'
            ],
            [
                'id' => 2402,
                'patient_name' => 'Turgut Sönmez',
                'national_id' => '21039487036',
                'age' => 68,
                'gender' => 'Erkek',
                'room' => 'ÜRO-102 (Robotik Üroloji)',
                'service' => 'Üroloji Polikliniği & Cerrahi',
                'diagnosis' => 'BPH Benign Prostat Hiperplazisi & HoLEP (Holmiyum Lazer Enükleasyonu) / TUR-P',
                'attending_physician' => 'Prof. Dr. Birol Yanık',
                'prostate_metrics' => 'Prostat Hacmi: 95 gram (Serum PSA: 2.8 ng/mL Normal), Qmax Akım: 6.2 mL/sn',
                'holep_procedure' => 'Enükle Edilen Prostat Dokusu: 72 gram Morselasyon İle Dışarı Alındı',
                'post_op_catheter' => '3 Yollu 24 Fr Foley Kateter Yıkamalı Takip (Berrak İdrar Çıkışı)'
            ]
        ];

        if (!session()->has('uro_admissions')) {
            session(['uro_admissions' => $defaultAdmissions]);
        }

        $uroAdmissions = session('uro_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($uroAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($uroAdmissions) > 0) {
            $selectedAdmission = reset($uroAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $uroExams = session('urology_exams', []);

        return view('modules.urology.index', compact(
            'uroAdmissions',
            'selectedAdmission',
            'selectedId',
            'uroExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('urology_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Birol Yanık',
            'date' => date('d.m.Y H:i')
        ];

        session(['urology_exams' => $exams]);

        return redirect()->route('urology.index', ['admission_id' => $admissionId])
            ->with('success', 'Üroloji muayenesi ve endoürolojik ameliyat kaydı başarıyla kaydedildi.');
    }
}
