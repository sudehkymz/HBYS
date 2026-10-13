<?php

namespace App\Modules\Dermatology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DermatologyController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 601,
                'patient_name' => 'Gamze Aksoy',
                'national_id' => '10293847561',
                'age' => 24,
                'gender' => 'Kadın',
                'room' => 'CLD-101',
                'service' => 'Deri ve Zührevi Hastalıkları (Cildiye)',
                'diagnosis' => 'Şiddetli Nodülokistik Akne Vulgaris & Sistemik İzotretinoin Takibi',
                'attending_physician' => 'Prof. Dr. Nermin Keskin',
                'isotretinoin_dose' => '40 mg/gün (Kümülatif: 4200 mg / 7200 mg Target)',
                'alt_ast' => 'ALT: 22 U/L, Trigliserid: 145 mg/dL (Normal)',
                'pregnancy_test' => 'Beta-hCG Negatif (Gebe Kalmama Taahhüdü Onaylı)'
            ],
            [
                'id' => 602,
                'patient_name' => 'Ferhat Polat',
                'national_id' => '21304958672',
                'age' => 45,
                'gender' => 'Erkek',
                'room' => 'CLD-102',
                'service' => 'Deri ve Zührevi Hastalıkları (Cildiye)',
                'diagnosis' => 'Psoriasis Vulgaris (Sedef Hastalığı) & PASI Skoru Evreleme',
                'attending_physician' => 'Doç. Dr. Selim Şen',
                'pasi_score' => 'PASI: 14.8 (Orta/Şiddetli Plak Psoriasis)',
                'bsa_percent' => '%18 Vücut Yüzey Alanı Tutulumu',
                'treatment' => 'Sistemik Anti-IL17 Biyolojik Ajan (Secukinumab)'
            ],
            [
                'id' => 603,
                'patient_name' => 'Bahar Korkmaz',
                'national_id' => '32415069783',
                'age' => 38,
                'gender' => 'Kadın',
                'room' => 'CLD-103',
                'service' => 'Deri ve Zührevi Hastalıkları (Cildiye)',
                'diagnosis' => 'Dijital Dermatoskopi Displastik Nevüs (Ben Haritası) & Melanom Taraması',
                'attending_physician' => 'Prof. Dr. Nermin Keskin',
                'nevus_count' => '42 Toplam Nevüs (3 Adet Atipik/Displastik Nevüs)',
                'abcde_score' => 'Sol Sırt 6mm Asimetrik Düzensiz Sınır (Eksizyonel Biyopsi İstendi)'
            ],
            [
                'id' => 604,
                'patient_name' => 'Murat Yıldız',
                'national_id' => '43526170894',
                'age' => 29,
                'gender' => 'Erkek',
                'room' => 'CLD-104',
                'service' => 'Deri ve Zührevi Hastalıkları (Cildiye)',
                'diagnosis' => 'Vitiligo Vulgaris & Dar Bant UVB (311nm) Fototerapi Takibi',
                'attending_physician' => 'Uzm. Dr. Burcu Erdem',
                'uvb_session' => '16. Seans / 36 Seanslık Kür (0.85 J/cm² Doz)',
                'repigmentation' => 'Yüz ve Gövdede %40 Fokal Repigmentasyon'
            ],
            [
                'id' => 605,
                'patient_name' => 'Kerem Arel',
                'national_id' => '54637281905',
                'age' => 33,
                'gender' => 'Erkek',
                'room' => 'CLD-105',
                'service' => 'Zührevi Hastalıklar (Venereoloji)',
                'diagnosis' => 'Anogenital Kondiloma Aküminata (HPV) & Kriyoterapi İşlemi',
                'attending_physician' => 'Doç. Dr. Selim Şen',
                'hpv_status' => 'Genital Lezyonlara Sıvı Azot Kriyoterapi (-196°C) Uygulandı',
                'serology' => 'VDRL/RPR: Negatif, Anti-HIV 1/2: Negatif'
            ]
        ];

        if (!session()->has('dermatology_admissions')) {
            session(['dermatology_admissions' => $defaultAdmissions]);
        }

        $dermAdmissions = session('dermatology_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($dermAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($dermAdmissions) > 0) {
            $selectedAdmission = reset($dermAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $dermExams = session('dermatology_exams', []);

        return view('modules.dermatology.index', compact(
            'dermAdmissions',
            'selectedAdmission',
            'selectedId',
            'dermExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('dermatology_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Nermin Keskin',
            'date' => date('d.m.Y H:i')
        ];

        session(['dermatology_exams' => $exams]);

        return redirect()->route('dermatology.index', ['admission_id' => $admissionId])
            ->with('success', 'Dermatoloji & Zührevi Hastalıklar muayene kaydı, dermatoskopi ve tedavi parametreleri kaydedildi.');
    }
}
