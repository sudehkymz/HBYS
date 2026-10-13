<?php

namespace App\Modules\MedicalEcology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicalEcologyController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 1301,
                'patient_name' => 'Fikriye Çetin',
                'national_id' => '10293847811',
                'age' => 58,
                'gender' => 'Kadın',
                'room' => 'EKOL-101 (Kaplıca Kürü)',
                'service' => 'Tıbbi Ekoloji ve Hidroklimatoloji (Balneoterapi)',
                'diagnosis' => 'Ankilozan Spondilit & Termomineral Su Kaplıca Kürü (Sülfürlü & Bikarbonatlı Su)',
                'attending_physician' => 'Prof. Dr. Nuran Yazıcı',
                'water_composition' => 'Sodyum-Bikarbonatlı Kükürtlü Termal Su (TDS: 2800 mg/L, Sıcaklık: 39.5°C)',
                'cure_protocol' => '12. Seans / 21 Seans Daldırma Banyosu (Günde 1 Seans 20 Dk)',
                'spa_approval' => 'Kaplıca Kürü Termoregülasyon & Kardiyovasküler Ekarte Onaylı'
            ],
            [
                'id' => 1302,
                'patient_name' => 'Naci Erdem',
                'national_id' => '21039485922',
                'age' => 63,
                'gender' => 'Erkek',
                'room' => 'EKOL-102 (Peloidoterapi)',
                'service' => 'Tıbbi Ekoloji ve Hidroklimatoloji (Çamur Ünitesi)',
                'diagnosis' => 'Bilateral Diz Gonartrozu (Kellgren-Lawrence Evre 3) & Peloidoterapi (Tıbbi Çamur)',
                'attending_physician' => 'Doç. Dr. Kaan Soyer',
                'peloid_temp' => 'Tıbbi Peloid (Organik Şifalı Çamur) Uygulama Sıcaklığı: 43°C',
                'cure_protocol' => '8. Seans Diz & Bel Bölgesi Çamur Paketi (Günde 1 Seans 30 Dk)',
                'spa_approval' => 'Lokal Peloid Sıcaklık Uygulaması Tolere Edildi (Vasküler Basınç Normal)'
            ],
            [
                'id' => 1303,
                'patient_name' => 'Remzi Akman',
                'national_id' => '32140597033',
                'age' => 51,
                'gender' => 'Erkek',
                'room' => 'EKOL-103 (Speleoterapi Odası)',
                'service' => 'Tıbbi Ekoloji (Klimatoterapi)',
                'diagnosis' => 'Persiste Astma Bronşiyale & Speleoterapi (Mikroklima Tuz Odası İnhalasyonu)',
                'attending_physician' => 'Prof. Dr. Nuran Yazıcı',
                'cave_microclimate' => 'Tuz Odası Mikrokliması (Bağıl Nem: %55, Hava Saflığı %99.8, NaCl Aerosol)',
                'cure_protocol' => '10. Seans Speleoterapi İnhalasyon Odası (Günde 45 Dk)',
                'spa_approval' => 'Bronşiyal Aşırı Duyarlılık Azaldı, SFT FEV1 %12 İyileşme Gösterdi'
            ],
            [
                'id' => 1304,
                'patient_name' => 'Belgin Yılmaz',
                'national_id' => '43251608144',
                'age' => 45,
                'gender' => 'Kadın',
                'room' => 'EKOL-104 (Talassoterapi)',
                'service' => 'Tıbbi Ekoloji (Talassoterapi)',
                'diagnosis' => 'Psoriatik Artrit & Isıtılmış Deniz Suyu Talassoterapi / Mineral Banyosu',
                'attending_physician' => 'Uzm. Dr. Burak Keskin',
                'water_composition' => 'Isıtılmış Isotonic Deniz Suyu (Sıcaklık: 37°C, Magnezyum & İyot Zengin)',
                'cure_protocol' => '14. Seans Talassoterapi Hidromasaj Havuzu + UV Klimatoterapi',
                'spa_approval' => 'PASI Sedef Skoru ve Eklem Ağrısı Belirgin Geriledi'
            ],
            [
                'id' => 1305,
                'patient_name' => 'Hasan Çelik',
                'national_id' => '54362719255',
                'age' => 69,
                'gender' => 'Erkek',
                'room' => 'EKOL-105 (Inhalasyon Ünitesi)',
                'service' => 'Tıbbi Ekoloji ve Hidroklimatoloji',
                'diagnosis' => 'Kronik Obstrüktif Akciğer Hastalığı (KOAH) & Radon/Termal Su İnhalasyon Kürü',
                'attending_physician' => 'Doç. Dr. Kaan Soyer',
                'cure_protocol' => '15. Seans Mineral Buhar İnhalasyonu & Nazal Lavaj (21 Günlük Kür)',
                'spa_approval' => 'Ekspektorasyon Kolaylaştı, Balneolojik Kür Tamamlandı Raporu Onaylı'
            ]
        ];

        if (!session()->has('ecology_admissions')) {
            session(['ecology_admissions' => $defaultAdmissions]);
        }

        $ecoAdmissions = session('ecology_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($ecoAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($ecoAdmissions) > 0) {
            $selectedAdmission = reset($ecoAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $ecoExams = session('ecology_exams', []);

        return view('modules.medical_ecology.index', compact(
            'ecoAdmissions',
            'selectedAdmission',
            'selectedId',
            'ecoExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('ecology_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Nuran Yazıcı',
            'date' => date('d.m.Y H:i')
        ];

        session(['ecology_exams' => $exams]);

        return redirect()->route('medical_ecology.index', ['admission_id' => $admissionId])
            ->with('success', 'Tıbbi Ekoloji ve Hidroklimatoloji muayene kaydı ve balneoterapi kür raporu kaydedildi.');
    }
}
