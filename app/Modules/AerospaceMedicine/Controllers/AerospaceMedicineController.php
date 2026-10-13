<?php

namespace App\Modules\AerospaceMedicine\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AerospaceMedicineController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 1201,
                'patient_name' => 'Hv.Plt.Bçvş. Alperen Yılmaz (F-16 Pilotu)',
                'national_id' => '10293847701',
                'age' => 31,
                'gender' => 'Erkek',
                'room' => 'HUZ-101 (Santrifüj & Hipobarik Lab)',
                'service' => 'Hava ve Uzay Hekimliği (Uçuş Fizyolojisi)',
                'diagnosis' => 'Yüksek Performanslı Jet Pilotu +9Gz Santrifüj İrtifa Dayanıklılık Taraması & AGSM',
                'attending_physician' => 'Prof. Dr. Erkan Göksu',
                'centrifuge_gz' => '+9Gz Tolerans Testi: 15 Saniye Dayanıklılık (G-LOC Yok, AGSM Başarılı)',
                'hypobaric_chamber' => '25.000 Feet Hipobarik İrtifa Kamarası (Hipoksi Farkındalık TUC: 4 Dk 12 Sn)',
                'flight_cert' => 'Sivil Havacılık (SHGM) & Askeri Sınıf 1 Jet Uçuş Lisansı Onaylandı'
            ],
            [
                'id' => 1202,
                'patient_name' => 'Ece Sezgin (Havayolu Kaptan Pilotu)',
                'national_id' => '21039485812',
                'age' => 42,
                'gender' => 'Kadın',
                'room' => 'HUZ-102 (SHGM Lisans Masası)',
                'service' => 'Hava ve Uzay Hekimliği (SHGM Muayene Merkezi)',
                'diagnosis' => 'EASA / SHGM Sınıf 1 Periyodik Pilot Sağlık Sertifikası Yenileme Muayenesi',
                'attending_physician' => 'Doç. Dr. Banu Güven',
                'vision_test' => 'Görme Keskinliği: Bilateral 6/6 (Renk Görmesi Ishihara 38/38 Tam)',
                'audiometry' => 'Saf Ses Odyometri: 500-4000 Hz İletim <15 dB (Mükemmel İşitme)',
                'flight_cert' => 'SHGM Class 1 Medical Certificate (12 Ay Geçerli Unrestricted)'
            ],
            [
                'id' => 1203,
                'patient_name' => 'Turgut Yaman (Derin Deniz / İrtifa Dalgıcı)',
                'national_id' => '32140596923',
                'age' => 37,
                'gender' => 'Erkek',
                'room' => 'HUZ-103 (Hiperbarik Oksijen HBO)',
                'service' => 'Hava ve Uzay Hekimliği (Hiperbarik / Vurgun Ünitesi)',
                'diagnosis' => 'Tip II Dekompresyon Hastalığı (Vurgun / DCS) & 2.8 ATA Hiperbarik Oksijen Tedavisi',
                'attending_physician' => 'Prof. Dr. Erkan Göksu',
                'hbo_protocol' => 'US Navy Treatment Table 6 (2.8 ATA %100 Oksijen 4 Saatsel Seans)',
                'barotrauma' => 'Östaki Borusu Fonksiyonu ve Timpanometri Tip A (Normal)',
                'flight_cert' => 'Dekompresyon Semptomları Tamamen Geriledi (İyileşme Başarılı)'
            ],
            [
                'id' => 1204,
                'patient_name' => 'Nazlı Erdem (Kabin Memuru / Purser)',
                'national_id' => '43251608034',
                'age' => 28,
                'gender' => 'Kadın',
                'room' => 'HUZ-104',
                'service' => 'Hava ve Uzay Hekimliği (Kabin Ekibi Poli)',
                'diagnosis' => 'Uçuş Esnasında Kulak Barotravması & Uzun Mesafeli Jet Lag Circadian Ritim Bozukluğu',
                'attending_physician' => 'Uzm. Dr. Selin Akman',
                'barotrauma' => 'Sol Kulak Zarı Grad 1 Barotravmatik Otit (Vasalva Manevra Eğitimi)',
                'flight_cert' => '7 Gün İstirahat Sonrası Kabin Ekibi Sağlık Sertifikası Yenilenecek'
            ],
            [
                'id' => 1205,
                'patient_name' => 'Uz.Astronot Tayfun Yıldız',
                'national_id' => '54362719145',
                'age' => 39,
                'gender' => 'Erkek',
                'room' => 'HUZ-105 (Uzay Fizyolojisi Lab)',
                'service' => 'Uzay Hekimliği & Mikrogravite Araştırma Merkezi',
                'diagnosis' => 'Uzay Görevi Sonrası Mikrogravite Uyum Eğitimi & Ortostatik Tolerans Testi',
                'attending_physician' => 'Prof. Dr. Erkan Göksu',
                'microgravity' => 'LBNP (Lower Body Negative Pressure) & Eğik Masa (Tilt Table) Testi Stabil',
                'bone_density' => 'DEXA Uzay Görevi Kemiği Mineral Yoğunluk Kaybı <%1.2 (Minimal)',
                'flight_cert' => 'Uzay Uçuşu Sonrası Yerçekimi Yeniden Adaptasyon Protokolü Başarıyla Tamamlandı'
            ]
        ];

        if (!session()->has('aerospace_admissions')) {
            session(['aerospace_admissions' => $defaultAdmissions]);
        }

        $aeroAdmissions = session('aerospace_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($aeroAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($aeroAdmissions) > 0) {
            $selectedAdmission = reset($aeroAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $aeroExams = session('aerospace_exams', []);

        return view('modules.aerospace_medicine.index', compact(
            'aeroAdmissions',
            'selectedAdmission',
            'selectedId',
            'aeroExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('aerospace_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Erkan Göksu',
            'date' => date('d.m.Y H:i')
        ];

        session(['aerospace_exams' => $exams]);

        return redirect()->route('aerospace_medicine.index', ['admission_id' => $admissionId])
            ->with('success', 'Hava ve Uzay Hekimliği uçuş muayene kaydı ve SHGM lisans onay raporu kaydedildi.');
    }
}
