<?php

namespace App\Modules\PhysicalRehab\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhysicalRehabController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 401,
                'patient_name' => 'Hikmet Yıldırım',
                'national_id' => '19028374615',
                'age' => 64,
                'gender' => 'Erkek',
                'room' => 'FTR-101',
                'service' => 'Fiziksel Tıp ve Rehabilitasyon',
                'diagnosis' => 'Serebrovasküler Olay Sonrası Sağ Serebral Hemipleji & Robotik Yürüme (Lokomat)',
                'attending_physician' => 'Prof. Dr. Filiz Öztürk',
                'brunnstrom_stage' => 'Brunnstrom Evre 4 (Sinerji Dışı Hareket Başlangıcı)',
                'fim_score' => 'FIM Skoru: 78 / 126 (Orta Düzey Bağımsızlık)',
                'ftr_sessions' => '12. Seans / 30 Seans Robotik Yürüme + Fizyoterapi'
            ],
            [
                'id' => 402,
                'patient_name' => 'Şükran Şahin',
                'national_id' => '20192837461',
                'age' => 52,
                'gender' => 'Kadın',
                'room' => 'FTR-102',
                'service' => 'Fiziksel Tıp ve Rehabilitasyon',
                'diagnosis' => 'Lumbal Disk Hernisi (L4-L5) & Şiddetli Bel Ağrısı (VAS: 8/10)',
                'attending_physician' => 'Doç. Dr. Engin Demir',
                'vas_pain' => 'VAS Ağrı Skoru: 8 / 10 (Şiddetli Radiküler Ağrı)',
                'ftr_modalities' => 'TENS + Hot Pack + Ultrason 1.5 Watt/cm² + Bel Traksiyonu',
                'ftr_sessions' => '5. Seans / 15 Seans FTR Protokolü'
            ],
            [
                'id' => 403,
                'patient_name' => 'Cemalettin Aksoy',
                'national_id' => '31203948572',
                'age' => 69,
                'gender' => 'Erkek',
                'room' => 'FTR-103',
                'service' => 'Fiziksel Tıp ve Rehabilitasyon',
                'diagnosis' => 'Bilateral Diz Gonartrozu (Evre 3 Kellgren-Lawrence) & PRP Enjeksiyonu',
                'attending_physician' => 'Prof. Dr. Filiz Öztürk',
                'barthel_index' => 'Barthel İndeksi: 85 / 100 (Hafif Bağımlı)',
                'infiltration' => 'Diz İçi PRP (Trombositten Zengin Plazma) 2. Doz Enjeksiyonu Yapıldı',
                'ftr_sessions' => 'Diz Egzersiz & Kinesiotaping Protokolü'
            ],
            [
                'id' => 404,
                'patient_name' => 'Selma Yılmaz',
                'national_id' => '42314059683',
                'age' => 37,
                'gender' => 'Kadın',
                'room' => 'FTR-104',
                'service' => 'Fiziksel Tıp ve Rehabilitasyon',
                'diagnosis' => 'Servikal Diskopatı & Miyofasiyal Ağrı Sendromu (Tetik Nokta Enjeksiyonu)',
                'attending_physician' => 'Uzm. Dr. Aylin Sever',
                'trigger_point' => 'Bilateral M.Trapezius Üst Liflerinde 4 Adet Aktif Tetik Nokta',
                'infiltration' => 'Lokal Anestezik (Lidokain %1) Tetik Nokta Enjeksiyonu Yapıldı',
                'vas_pain' => 'VAS Ağrı Skoru Enjeksiyon Sonrası 3/10\'a Geriledi'
            ],
            [
                'id' => 405,
                'patient_name' => 'Kaan Arslan (12 Yaş)',
                'national_id' => '53425160794',
                'age' => 12,
                'gender' => 'Erkek',
                'room' => 'FTR-105 (Pediatrik FTR)',
                'service' => 'Pediatrik Fiziksel Rehabilitasyon',
                'diagnosis' => 'Spastik Serebral Palsi (Diparezi) & Botulinum Toksin (Botox) Uygulaması',
                'attending_physician' => 'Doç. Dr. Engin Demir',
                'ashworth_scale' => 'Modifiye Ashworth Skoru: Evre 3 (Gastroknemius Spastisitesi)',
                'botox_dose' => 'Gastrocnemius & Hamstring Kasına Toplam 200 Ünite Botox Enjeksiyonu',
                'orthosis' => 'Rigid AFO (Ankle Foot Orthosis) Reçete Edildi'
            ]
        ];

        if (!session()->has('physical_admissions')) {
            session(['physical_admissions' => $defaultAdmissions]);
        }

        $ftrAdmissions = session('physical_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($ftrAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($ftrAdmissions) > 0) {
            $selectedAdmission = reset($ftrAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $ftrExams = session('physical_exams', []);

        return view('modules.physical_rehab.index', compact(
            'ftrAdmissions',
            'selectedAdmission',
            'selectedId',
            'ftrExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('physical_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Filiz Öztürk',
            'date' => date('d.m.Y H:i')
        ];

        session(['physical_exams' => $exams]);

        return redirect()->route('physical_rehab.index', ['admission_id' => $admissionId])
            ->with('success', 'Fiziksel Tıp ve Rehabilitasyon muayene kaydı, seans planı ve skala değerlendirmesi kaydedildi.');
    }
}
