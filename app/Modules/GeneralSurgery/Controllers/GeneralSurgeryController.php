<?php

namespace App\Modules\GeneralSurgery\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralSurgeryController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.general_surgery.subspecialties.general', $context);
    }

    public function surgicalOncology(Request $request)
    {
        $context = $this->getPatientContext($request, 'surgical_oncology');
        return view('modules.general_surgery.subspecialties.surgical_oncology', $context);
    }

    public function giSurgery(Request $request)
    {
        $context = $this->getPatientContext($request, 'gi_surgery');
        return view('modules.general_surgery.subspecialties.gi_surgery', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);
        $redirectRoute = $request->input('redirect_route', 'general_surgery.index');

        $exams = session('general_surgery_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Cemalettin Ertekin',
            'date' => date('d.m.Y H:i')
        ];

        session(['general_surgery_exams' => $exams]);

        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Cerrahi muayene kaydı, operasyon ve dren takip raporu kaydedildi.');
    }

    private function getPatientContext(Request $request, string $activeSubKey)
    {
        $defaultAdmissions = [
            [
                'id' => 1401,
                'patient_name' => 'Ahmet Selim Korkmaz',
                'national_id' => '10293847921',
                'age' => 46,
                'gender' => 'Erkek',
                'room' => 'CRH-101 (Ameliyathane Salon 3)',
                'service' => 'Genel Cerrahi (Laparoskopik Cerrahi)',
                'diagnosis' => 'Semptomatik Kolelitiazis & Laparoskopik Kolesistektomi (ASA II)',
                'attending_physician' => 'Prof. Dr. Cemalettin Ertekin',
                'asa_score' => 'ASA Class II (Kontrollü Hipertansiyon)',
                'surgical_procedure' => 'Laparoskopik Kolesistektomi (4 Port Tekniği, Calot Üçgeni Diseksiyonu)',
                'postop_drain' => 'Jackson-Pratt Dren: 30 ml/gün Seröz Mayi (Temiz)',
                'npo_status' => 'Post-op 1. Gün Berrak Sıvı Diyet Başlandı'
            ],
            [
                'id' => 1402,
                'patient_name' => 'Elif Yıldırım',
                'national_id' => '21039486032',
                'age' => 27,
                'gender' => 'Kadın',
                'room' => 'CRH-102 (Acil Cerrahi Servisi)',
                'service' => 'Genel Cerrahi (Acil Cerrahi)',
                'diagnosis' => 'Akut Flegmonöz Apandisit & Laparoskopik Apandektomi',
                'attending_physician' => 'Doç. Dr. Serkan Uysal',
                'asa_score' => 'ASA Class I E (Acil Vaka)',
                'surgical_procedure' => 'Laparoskopik Apandektomi (Endoloop İle Apendiks Kökü Bağlandı)',
                'postop_drain' => 'Dren Konulmadı (Abdomen Yıkama & Aspirasyon)',
                'npo_status' => 'Oral Alım Açık (Şifa İle Taburculuk Planlanıyor)'
            ],
            [
                'id' => 1403,
                'patient_name' => 'Metin Barut',
                'national_id' => '32140597143',
                'age' => 62,
                'gender' => 'Erkek',
                'room' => 'CRH-103 (Cerrahi Onkoloji Servisi)',
                'service' => 'Cerrahi Onkolojisi (Yan Dal)',
                'diagnosis' => 'Periton Karsinomatoz & Sitoredüktif Cerrahi (CRS) + Sıcak Kemoterapi (HIPEC)',
                'attending_physician' => 'Prof. Dr. Cemalettin Ertekin',
                'hipec_protocol' => 'HIPEC Sıcak Kemoterapi: 42°C Mitomisin-C 90 Dk İntraperitoneal Perfüzyon',
                'surgical_procedure' => 'Peritonektomi + Omentektomi (Peritoneal Karsinomatozis İndeksi PCI: 12)',
                'postop_drain' => 'Abdominal 4 Adet Silikon Dren: Toplam 220 ml/gün Seröz'
            ],
            [
                'id' => 1404,
                'patient_name' => 'Kemal Öztürk',
                'national_id' => '43251608254',
                'age' => 59,
                'gender' => 'Erkek',
                'room' => 'CRH-104 (Gastroenteroloji Cerrahi)',
                'service' => 'Gastroenteroloji Cerrahisi (Yan Dal)',
                'diagnosis' => 'Pankreas Baş Karsinomu & Pankreatikoduodenektomi (Whipple Ameliyatı)',
                'attending_physician' => 'Doç. Dr. Serkan Uysal',
                'whipple_detail' => 'Pankreatikojejunostomi (Duct-to-Mucosa) + Hepatikojejunostomi Anaztomozu',
                'surgical_procedure' => 'Açık Whipple Prosedürü (Pankreas Baş + Duodenum Rezeksiyonu)',
                'postop_drain' => 'Pankreas Loj Dren Amilaz Değeri: 180 U/L (Fistül Yok, Normal)'
            ],
            [
                'id' => 1405,
                'patient_name' => 'Hacer Taşçı',
                'national_id' => '54362719365',
                'age' => 54,
                'gender' => 'Kadın',
                'room' => 'CRH-105 (Cerrahi Onkoloji Servisi)',
                'service' => 'Cerrahi Onkolojisi (Yan Dal)',
                'diagnosis' => 'Sağ Meme İnvaziv Duktal Karsinom & Modifiye Radikal Mastektomi + SLNB',
                'attending_physician' => 'Doç. Dr. Neslihan Cabıoğlu',
                'asa_score' => 'ASA Class II',
                'surgical_procedure' => 'Sağ MRM + Sentinel Lenf Nodu Biyopsisi (SLNB Frozen Negatif)',
                'postop_drain' => 'Aksiller Jackson-Pratt Dren: 45 ml/gün'
            ]
        ];

        if (!session()->has('general_surgery_admissions')) {
            session(['general_surgery_admissions' => $defaultAdmissions]);
        }

        $surgAdmissions = session('general_surgery_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($surgAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($surgAdmissions) > 0) {
            $selectedAdmission = reset($surgAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $surgExams = session('general_surgery_exams', []);

        return compact(
            'surgAdmissions',
            'selectedAdmission',
            'selectedId',
            'surgExams',
            'activeSubKey'
        );
    }
}
