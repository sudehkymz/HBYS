<?php

namespace App\Modules\SportsMedicine\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportsMedicineController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 1101,
                'patient_name' => 'Mert Demirel (Profesyonel Futbolcu)',
                'national_id' => '10293847601',
                'age' => 24,
                'gender' => 'Erkek',
                'room' => 'SPR-101 (Performans Lab)',
                'service' => 'Spor Hekimliği (Performans & CPET)',
                'diagnosis' => 'Ön Çapraz Bağ (ÖÇB) Rekonstrüksiyonu Sonrası 6. Ay Sağına Dönüş (Return to Play - RTP)',
                'attending_physician' => 'Prof. Dr. Tolga Şahin',
                'vo2_max' => 'VO2 Max: 58.4 mL/kg/dk (Üst Düzey Aerobik Kapasite)',
                'biodex_hq' => 'Biodex İzokinetik H/Q Oranı: %64 (Simetrik Kas Dengesi Uygun)',
                'rtp_clearance' => 'Return to Play (RTP) Testleri Başarılı - Sahaya Çıkış Lisansı Onaylandı'
            ],
            [
                'id' => 1102,
                'patient_name' => 'Selin Aksoy (Milli Atlet)',
                'national_id' => '21039485712',
                'age' => 21,
                'gender' => 'Kadın',
                'room' => 'SPR-102 (MSK USG Birimi)',
                'service' => 'Spor Hekimliği Polikliniği',
                'diagnosis' => 'Kronik Aşil Tendinopati & USG Rehberliğinde PRP Enjeksiyonu',
                'attending_physician' => 'Doç. Dr. Hakan Eröz',
                'msk_usg' => 'MSK USG: Aşil Tendon Mid-Substance %30 İğsi Kalınlaşma & Neovaskülarizasyon',
                'prp_injection' => 'Tendon İçi USG Kılavuzluğunda 3ml Autologous PRP Enjeksiyonu Yapıldı',
                'rehab_plan' => 'Eksantrik Yükleme Egzersiz Protokolü (Stanish Şeması)'
            ],
            [
                'id' => 1103,
                'patient_name' => 'Kaan Polat (Basketbolcu)',
                'national_id' => '32140596823',
                'age' => 26,
                'gender' => 'Erkek',
                'room' => 'SPR-103',
                'service' => 'Spor Hekimliği (İzokinetik Lab)',
                'diagnosis' => 'Hamstring Grade II Kas Yaralanması & İzokinetik Dinamometre Kas İmpalansı',
                'attending_physician' => 'Prof. Dr. Tolga Şahin',
                'biodex_hq' => 'Hamstring/Quadriceps Tork Dengesizliği: H/Q %48 (Yüksek Nüks Riski)',
                'peak_torque' => 'Quadriceps Peak Torque: 280 Nm, Hamstring Peak Torque: 134 Nm',
                'rehab_plan' => 'Nordic Hamstring Eksantrik Güçlendirme & Kinesiotaping'
            ],
            [
                'id' => 1104,
                'patient_name' => 'Deniz Arslan (Yüzücü)',
                'national_id' => '43251607934',
                'age' => 19,
                'gender' => 'Kadın',
                'room' => 'SPR-104',
                'service' => 'Spor Hekimliği Polikliniği',
                'diagnosis' => 'Yüzücü Omuz Sendromu (Subakromiyel İmpingement) & Rotator Manşet Taraması',
                'attending_physician' => 'Uzm. Dr. Gökhan Sever',
                'msk_usg' => 'MSK USG: M.Supraspinatus Tendonunda Hafif Ödem & Bursit',
                'rtp_clearance' => 'Kulaç Tekniği Modifikasyonu & Scapular Dyskinesis Egzersizleri',
                'lisans_approval' => 'Aktif Yarışma Sezonu İçin Tıbbi Uygunluk Onaylandı'
            ],
            [
                'id' => 1105,
                'patient_name' => 'Emre Yılmaz (Amatör Lisanslı)',
                'national_id' => '54362718045',
                'age' => 17,
                'gender' => 'Erkek',
                'room' => 'SPR-105',
                'service' => 'Spor Hekimliği (Lisans Sağlık Masası)',
                'diagnosis' => 'Sezon Öncesi Sporcu Lisansı Sağlık Kurul Taraması & Kardiyak EKG Ekarte',
                'attending_physician' => 'Doç. Dr. Hakan Eröz',
                'ecg_screening' => 'EKG: Normal Sinus Ritmi (Erken Repolarizasyon - Sporcu Kalbi Uyumlu)',
                'body_fat' => 'DEXA / Skinfold Vücut Yağ Yüzdesi: %11.2 (Optimal Atletik Profil)',
                'lisans_approval' => 'Lisans Sağlık Raporu E-Devlet Entegre Sistemi Onaylandı'
            ]
        ];

        if (!session()->has('sports_admissions')) {
            session(['sports_admissions' => $defaultAdmissions]);
        }

        $sportsAdmissions = session('sports_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($sportsAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($sportsAdmissions) > 0) {
            $selectedAdmission = reset($sportsAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $sportsExams = session('sports_exams', []);

        return view('modules.sports_medicine.index', compact(
            'sportsAdmissions',
            'selectedAdmission',
            'selectedId',
            'sportsExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('sports_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Tolga Şahin',
            'date' => date('d.m.Y H:i')
        ];

        session(['sports_exams' => $exams]);

        return redirect()->route('sports_medicine.index', ['admission_id' => $admissionId])
            ->with('success', 'Spor Hekimliği muayene kaydı, VO2 max değerleri ve lisans onay raporu kaydedildi.');
    }
}
