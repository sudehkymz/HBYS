<?php

namespace App\Modules\InfectiousDiseases\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfectiousDiseasesController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 501,
                'patient_name' => 'İsmail Güneş',
                'national_id' => '19283746501',
                'age' => 58,
                'gender' => 'Erkek',
                'room' => 'INF-101 (İzolasyon)',
                'service' => 'Enfeksiyon Hastalıkları ve Klinik Mikrobiyoloji',
                'diagnosis' => 'Yara Kültürü ESBL (+) Klebsiella pneumoniae & Kısıtlı Antibiyotik Onayı',
                'attending_physician' => 'Prof. Dr. Hakan Erdem',
                'culture_result' => 'Escherichia coli (ESBL Pozitif, Meropenem Hassas)',
                'kup_approval' => 'Meropenem 1g 3x1 KUP Formu Onaylandı',
                'procalcitonin' => 'Prokalsitonin: 4.8 ng/mL (Yüksek Sepsis Riski)'
            ],
            [
                'id' => 502,
                'patient_name' => 'Seda Yılmaz',
                'national_id' => '28374650192',
                'age' => 41,
                'gender' => 'Kadın',
                'room' => 'INF-102',
                'service' => 'Enfeksiyon Hastalıkları ve Klinik Mikrobiyoloji',
                'diagnosis' => 'Kronik Hepatit B (HBV DNA Yüksek) & Tenofovir Antiviral Takibi',
                'attending_physician' => 'Doç. Dr. Neslihan Kurt',
                'viral_load' => 'HBV DNA: 4.2 x 10^6 IU/mL (Yüksek Replikasyon)',
                'alt_ast' => 'ALT: 86 U/L, AST: 72 U/L (Transaminaz Yüksekliği)',
                'antiviral_med' => 'Tenofovir Alafenamid (TAF) 25mg 1x1'
            ],
            [
                'id' => 503,
                'patient_name' => 'Caner Akman',
                'national_id' => '37465019283',
                'age' => 36,
                'gender' => 'Erkek',
                'room' => 'INF-103',
                'service' => 'Enfeksiyon Hastalıkları ve Klinik Mikrobiyoloji',
                'diagnosis' => 'HIV/AIDS ART (Antiretroviral) Tedavisi & CD4+ T-Lenfosit Takibi',
                'attending_physician' => 'Prof. Dr. Hakan Erdem',
                'cd4_count' => 'CD4+ T-Hücresi: 480 hücre/µL (%28)',
                'hiv_rna' => 'HIV RNA Viral Yük: saptanamadı (<20 kopya/mL)',
                'art_regimen' => 'Biktarvy (Bictegravir/FTC/TAF) 1x1'
            ],
            [
                'id' => 504,
                'patient_name' => 'Nuran Vural',
                'national_id' => '46501928374',
                'age' => 67,
                'gender' => 'Kadın',
                'room' => 'INF-104 (Temas İzolasyonu)',
                'service' => 'Enfeksiyon Hastalıkları ve Klinik Mikrobiyoloji',
                'diagnosis' => 'MRSA (Metisiline Dirençli S.aureus) Osteomiyelit & Vankomisin İnfüzyonu',
                'attending_physician' => 'Uzm. Dr. Serdar Çelik',
                'mrsa_culture' => 'Kan & Doku Kültürü: MRSA (Vankomisin MIC: 1.0 µg/mL)',
                'isolation' => 'Temas İzolasyon Önlemleri Akut Odası',
                'vancomycin_trough' => 'Vankomisin Çukur Düzeyi: 16.5 µg/mL (Hedef 15-20)'
            ],
            [
                'id' => 505,
                'patient_name' => 'Barış Yılmaz',
                'national_id' => '50192837465',
                'age' => 31,
                'gender' => 'Erkek',
                'room' => 'INF-105 (Seyahat Sağlığı)',
                'service' => 'Enfeksiyon Hastalıkları (Seyahat Aşıları)',
                'diagnosis' => 'Yurt Dışı Seyahat Öncesi Sarı humma & Kuduz Temas Sonrası Proflaksi',
                'attending_physician' => 'Doç. Dr. Neslihan Kurt',
                'travel_vaccine' => 'Sarı Humma Aşısı Yapıldı (Uluslararası Aşı Karnesi Onaylandı)',
                'rabies_pep' => 'Kuduz Aşısı 3. Doz + Kuduz İmmünoglobulini (RIG) Tamamlandı'
            ]
        ];

        if (!session()->has('infectious_admissions')) {
            session(['infectious_admissions' => $defaultAdmissions]);
        }

        $infAdmissions = session('infectious_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($infAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($infAdmissions) > 0) {
            $selectedAdmission = reset($infAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $infExams = session('infectious_exams', []);

        return view('modules.infectious_diseases.index', compact(
            'infAdmissions',
            'selectedAdmission',
            'selectedId',
            'infExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('infectious_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Hakan Erdem',
            'date' => date('d.m.Y H:i')
        ];

        session(['infectious_exams' => $exams]);

        return redirect()->route('infectious_diseases.index', ['admission_id' => $admissionId])
            ->with('success', 'Enfeksiyon Hastalıkları muayene kaydı, kültür antibiyogramı ve KUP form onayı kaydedildi.');
    }
}
