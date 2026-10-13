<?php

namespace App\Modules\Neurology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NeurologyController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.neurology.subspecialties.general', $context);
    }

    public function neurophysiology(Request $request)
    {
        $context = $this->getPatientContext($request, 'neurophysiology');
        return view('modules.neurology.subspecialties.neurophysiology', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);
        $redirectRoute = $request->input('redirect_route', 'neurology.index');

        $exams = session('neurology_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Zafer Kara',
            'date' => date('d.m.Y H:i')
        ];

        session(['neurology_exams' => $exams]);

        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Nöroloji muayene kaydı ve nörofizyolojik test parametreleri kaydedildi.');
    }

    private function getPatientContext(Request $request, string $activeSubKey)
    {
        $defaultAdmissions = [
            [
                'id' => 101,
                'patient_name' => 'Adnan Sezgin',
                'national_id' => '10293847101',
                'age' => 65,
                'gender' => 'Erkek',
                'room' => 'NRL-101 (İnme Ünitesi)',
                'service' => 'Nöroloji Polikliniği (İnme Merkezi)',
                'diagnosis' => 'Sol MCA Akut İskemik İnme & IV tPA Trombolitik Tedavi Takibi',
                'attending_physician' => 'Prof. Dr. Zafer Kara',
                'nihss_score' => 'NIHSS Skoru: 14 Puan (Orta-Şiddetli Nörolojik Defisit)',
                'mri_brain' => 'Beyin MR: Sol Sol Kapsula İnterna & Basal Ganglion Akut İskemik Enfarkt',
                'tpa_dosing' => 'IV Alteplase (tPA) 0.9 mg/kg (İnfüzyon Sonrası NIHSS 6\'ya Geriledi)'
            ],
            [
                'id' => 102,
                'patient_name' => 'Zeynep Solmaz',
                'national_id' => '21039485212',
                'age' => 32,
                'gender' => 'Kadın',
                'room' => 'NRL-102',
                'service' => 'Nöroloji Polikliniği (MS Polikliniği)',
                'diagnosis' => 'Relapsing-Remitting Multipl Skleroz (RRMS) & EDSS Özürlülük Takibi',
                'attending_physician' => 'Doç. Dr. Feride Aydın',
                'edss_score' => 'EDSS Skoru: 3.5 (Orta Derece Piramidal & Serebellar Yeti Yitimi)',
                'mri_lesion' => 'Kranial MR: Periventriküler & Subkortikal 14 Adet T2/FLAIR Hiperintens Plak',
                'dmt_treatment' => 'Hastalık Modifiye Edici Tedavi (Ocrelizumab 600mg İnfazı)'
            ],
            [
                'id' => 103,
                'patient_name' => 'Hamdi Eren',
                'national_id' => '32140596323',
                'age' => 28,
                'gender' => 'Erkek',
                'room' => 'NRL-103 (Nörofizyoloji Lab)',
                'service' => 'Klinik Nörofizyoloji Laboratuvarı',
                'diagnosis' => 'Dirençli Temporal Lob Epilepsisi & 32 Kanallı Video-EEG Monitorizasyonu',
                'attending_physician' => 'Prof. Dr. Zafer Kara',
                'eeg_result' => 'Video-EEG: Sol Anterior Temporal Keskin-Yavaş Dalga Paroksizm Dizilimi',
                'aed_level' => 'Levetirasetam Serum Düzeyi: 32 µg/mL (Terapötik Aralıkta)',
                'mri_epilepsy' => 'Epilepsi Protokol MR: Sol Hipokampal Skleroz (MHS)'
            ],
            [
                'id' => 104,
                'patient_name' => 'Fikret Yılmaz',
                'national_id' => '43251607434',
                'age' => 59,
                'gender' => 'Erkek',
                'room' => 'NRL-104 (EMG Lab)',
                'service' => 'Klinik Nörofizyoloji (EMG Birimi)',
                'diagnosis' => 'Diyabetik Distal Simetrik Polinöropati & EMG Sinir İletim Çalışması',
                'attending_physician' => 'Uzm. Dr. Burcu Şen',
                'emg_ncs' => 'EMG KSK: Bilateral N.Peroneus & N.Tibialis Motor İletim Hızı 34 m/s (Yavaşlamış)',
                'rns_mg' => 'Tek Lif EMG / RNS Repetitif Uyarım: Myasitnik Dekresendo Yanıt Yok',
                'vep_p100' => 'VEP P100 Latansı: 104 ms (Normal Optik İletim)'
            ],
            [
                'id' => 105,
                'patient_name' => 'Şükrü Balcı',
                'national_id' => '54362718545',
                'age' => 71,
                'gender' => 'Erkek',
                'room' => 'NRL-105',
                'service' => 'Nöroloji (Hareket Bozuklukları Poli)',
                'diagnosis' => 'Parkinson Hastalığı & UPDRS Motor Skorlama (Levodopa Yanıtı)',
                'attending_physician' => 'Doç. Dr. Feride Aydın',
                'updrs_score' => 'UPDRS Motor Skoru: 26 / 108 (ON Dönemi)',
                'tremor_rigidity' => 'Sağ Üst Ekstremitede İstirahat Tremoru & Dişli Çark Rigiditesi',
                'parkinson_med' => 'Levodopa/Benserazid 100/25mg 4x1 + Pramipeksol 1 mg/gün'
            ]
        ];

        if (!session()->has('neurology_admissions')) {
            session(['neurology_admissions' => $defaultAdmissions]);
        }

        $neuroAdmissions = session('neurology_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($neuroAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($neuroAdmissions) > 0) {
            $selectedAdmission = reset($neuroAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $neuroExams = session('neurology_exams', []);

        return compact(
            'neuroAdmissions',
            'selectedAdmission',
            'selectedId',
            'neuroExams',
            'activeSubKey'
        );
    }
}
