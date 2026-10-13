<?php

namespace App\Modules\Dietetics\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DieteticsController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 1901,
                'patient_name' => 'Kaan Polat',
                'national_id' => '10293848471',
                'age' => 41,
                'gender' => 'Erkek',
                'room' => 'DYT-101 (Vücut Analiz Lab)',
                'service' => 'Beslenme ve Diyetetik Polikliniği',
                'diagnosis' => 'Evre 1 Obezite & BIA (Tanita) Vücut Analiz Değerlendirmesi / Tıbbi Beslenme Tedavisi',
                'attending_physician' => 'Dyt. Selin Keskin',
                'bmi_status' => 'VKİ (BMI): 32.4 kg/m² (Ağırlık: 98 kg, Boy: 174 cm)',
                'bia_analysis' => 'BIA Vücut Yağ Yüzdesi: %31.8 (Yağ Kütlesi: 31.1 kg, BMR: 1890 kcal)',
                'diet_plan' => '1800 kcal/gün Akdeniz Tipi Makro-Besin Dengeli Diyet Listesi'
            ],
            [
                'id' => 1902,
                'patient_name' => 'Fikriye Çetin',
                'national_id' => '21039486582',
                'age' => 58,
                'gender' => 'Kadın',
                'room' => 'DYT-102 (Klinik Nütrisyon)',
                'service' => 'Beslenme ve Diyetetik Polikliniği',
                'diagnosis' => 'Tip 2 Diyabet & Nefropati Diyabetik Karbonhidrat Sayımı Diyet Protokolü',
                'attending_physician' => 'Dyt. Selin Keskin',
                'bmi_status' => 'VKİ (BMI): 28.1 kg/m² (Ağırlık: 73 kg, Boy: 161 cm)',
                'bia_analysis' => 'Kan Şekiri HbA1c: %8.2, GFR: 65 mL/dk (Düşük Sodyumlu Diyet)',
                'diet_plan' => '1500 kcal Karbonhidrat Sayımı (İnsülin-Karbonhidrat Oranı Uyumlu)'
            ],
            [
                'id' => 1903,
                'patient_name' => 'Harun Demirci',
                'national_id' => '32140597693',
                'age' => 71,
                'gender' => 'Erkek',
                'room' => 'DYT-103 (Bariyatri Takip)',
                'service' => 'Beslenme ve Diyetetik Polikliniği',
                'diagnosis' => 'Bariyatri Ameliyatı (Tüp Mide) Sonrası 1. Ay Sıvı-Püre Dönüşüm Beslenmesi',
                'attending_physician' => 'Dyt. Selin Keskin',
                'bmi_status' => 'Post-Op Ağırlık Kaybı: -11 kg (1 Aylık İlerleme Optimal)',
                'bia_analysis' => 'Proteinden Zengin Püre Fazı (60gr/gün İzolât Peynir Altı Suyu Proteini)',
                'diet_plan' => 'Bariyatri B-Kompleks & Multivitamin Desteği + Yüksek Proteinli Püre'
            ]
        ];

        if (!session()->has('dietetics_admissions')) {
            session(['dietetics_admissions' => $defaultAdmissions]);
        }

        $dytAdmissions = session('dietetics_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($dytAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($dytAdmissions) > 0) {
            $selectedAdmission = reset($dytAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $dytExams = session('dietetics_exams', []);

        return view('modules.dietetics.index', compact(
            'dytAdmissions',
            'selectedAdmission',
            'selectedId',
            'dytExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('dietetics_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Dyt. Selin Keskin',
            'date' => date('d.m.Y H:i')
        ];

        session(['dietetics_exams' => $exams]);

        return redirect()->route('dietetics.index', ['admission_id' => $admissionId])
            ->with('success', 'Beslenme ve Diyetetik vücut analizi (BIA) ve diyet listesi kaydedildi.');
    }
}
