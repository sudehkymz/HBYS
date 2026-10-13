<?php

namespace App\Modules\Neurosurgery\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NeurosurgeryController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 1501,
                'patient_name' => 'Burak Çeliker',
                'national_id' => '10293848031',
                'age' => 51,
                'gender' => 'Erkek',
                'room' => 'NŞR-101 (Nöroşirürji Ameliyathane)',
                'service' => 'Beyin ve Sinir Cerrahisi (Nöro-Onkoloji)',
                'diagnosis' => 'Sol Parieto-oksipital Glioblastoma (GBM) & Nöronavigasyonlu Kraniyotomi + Tümör Rezeksiyonu',
                'attending_physician' => 'Prof. Dr. İbrahim Ziyal',
                'gcs_score' => 'GCS Skoru: 15/15 (Oryante & Koopere)',
                'ionm_status' => 'İntraoperatif Nöromonitorizasyon (MEP / SSEP Amplitüdü %100 Stabil)',
                'icp_monitor' => 'İntrakraniyal Basınç (ICP): 11 mmHg (Normal Sınırda)',
                'neuronav' => 'Medtronic StealthStation Nöronavigasyon Rehberliğinde R0 Rezeksiyon'
            ],
            [
                'id' => 1502,
                'patient_name' => 'Zeynep Akman',
                'national_id' => '21039486142',
                'age' => 43,
                'gender' => 'Kadın',
                'room' => 'NŞR-102 (Omurga Cerrahisi Servisi)',
                'service' => 'Beyin ve Sinir Cerrahisi (Spinal Cerrahi)',
                'diagnosis' => 'L4-L5 Sol Sequestre Lomber Disk Hernisi & Mikrodiskektomi',
                'attending_physician' => 'Doç. Dr. Hakan Bozkurt',
                'gcs_score' => 'GCS Skoru: 15/15',
                'ionm_status' => 'Sol L5 Kök Derivasyonunda İntra-Op Serbestleşme Sağlandı',
                'icp_monitor' => 'Spinal Dren Konulmadı (Dura İntakt, BOS Kaçağı Yok)',
                'neuronav' => 'C-Kollu Skopi Rehberliğinde Minimal İnvaziv Mikroskopik Rezeksiyon'
            ],
            [
                'id' => 1503,
                'patient_name' => 'Kemal Savaş',
                'national_id' => '32140597253',
                'age' => 57,
                'gender' => 'Erkek',
                'room' => 'NŞR-103 (Nöro-Yoğun Bakım)',
                'service' => 'Beyin ve Sinir Cerrahisi (Nörovasküler)',
                'diagnosis' => 'Sol MCA Anevrizması Rüptürü (AUB Evre III) & Mikrocerrahi Anevrizma Kliplemesi',
                'attending_physician' => 'Prof. Dr. İbrahim Ziyal',
                'gcs_score' => 'GCS Skoru: 12/15 (E3M5V4 Konfüze)',
                'ionm_status' => 'Doppler Ultrasonografi İle Klip Sonrası Ana Damar Akımı Açık',
                'icp_monitor' => 'EVD (Eksternal Ventriküler Dren) İÇP: 14 mmHg (BOS Drenajı Aktif)'
            ],
            [
                'id' => 1504,
                'patient_name' => 'Deniz Şahin',
                'national_id' => '43251608364',
                'age' => 36,
                'gender' => 'Erkek',
                'room' => 'NŞR-104 (Servikal Omurga)',
                'service' => 'Beyin ve Sinir Cerrahisi (Spinal Cerrahi)',
                'diagnosis' => 'C5-C6 Servikal Disk Hernisi & Servikal Anterior Diskektomi ve Füzyon (ACDF)',
                'attending_physician' => 'Doç. Dr. Hakan Bozkurt',
                'gcs_score' => 'GCS Skoru: 15/15',
                'ionm_status' => 'Kord Kompresyonu Çözüldü, MEP / SSEP Yanıtı Güçlendi',
                'neuronav' => 'PEEK Kafes + Plak-Vida Sistemli Anterior Servikal Füzyon'
            ],
            [
                'id' => 1505,
                'patient_name' => 'Yasin Tunç',
                'national_id' => '54362719475',
                'age' => 29,
                'gender' => 'Erkek',
                'room' => 'NŞR-105 (Acil Travma)',
                'service' => 'Beyin ve Sinir Cerrahisi (Kafa Travması)',
                'diagnosis' => 'Sağ Temporal Epidural Hematom (Acil Travma) & Acil Kraniyotomi + Hematom Evakuasyonu',
                'attending_physician' => 'Uzm. Dr. Alp Kaynak',
                'gcs_score' => 'GCS Skoru: 14/15 (Pre-op 9/15 Post-op İyileşme Gösterdi)',
                'icp_monitor' => 'İntrakraniyal Basınç Monitoring (ICP 10 mmHg Normal)',
                'ionm_status' => 'Duramater Dikiş İle Asıldı (Kemiğin Geri Yerleştirilmesi Tamamlandı)'
            ]
        ];

        if (!session()->has('neurosurgery_admissions')) {
            session(['neurosurgery_admissions' => $defaultAdmissions]);
        }

        $nsAdmissions = session('neurosurgery_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($nsAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($nsAdmissions) > 0) {
            $selectedAdmission = reset($nsAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $nsExams = session('neurosurgery_exams', []);

        return view('modules.neurosurgery.index', compact(
            'nsAdmissions',
            'selectedAdmission',
            'selectedId',
            'nsExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('neurosurgery_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. İbrahim Ziyal',
            'date' => date('d.m.Y H:i')
        ];

        session(['neurosurgery_exams' => $exams]);

        return redirect()->route('neurosurgery.index', ['admission_id' => $admissionId])
            ->with('success', 'Beyin ve Sinir Cerrahisi (Nöroşirürji) operasyon ve nöromonitorizasyon kaydı kaydedildi.');
    }
}
