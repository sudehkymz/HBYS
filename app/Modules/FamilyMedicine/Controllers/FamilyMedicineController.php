<?php

namespace App\Modules\FamilyMedicine\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FamilyMedicineController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 701,
                'patient_name' => 'Zeynep Yılmaz',
                'national_id' => '11223344556',
                'age' => 35,
                'gender' => 'Kadın',
                'room' => 'AH-101',
                'service' => 'Aile Hekimliği Polikliniği',
                'diagnosis' => 'Periyodik Sağlık Taraması & HYP Kronik Hastalık Risk İzlemi',
                'attending_physician' => 'Uzm. Dr. Aylin Güneş',
                'hyp_status' => 'HYP İzlem Yapıldı (Tansiyon & Obezite Taraması Tamam)',
                'vaccine_status' => 'Tetanoz/Difteri Rapel Dozu Yapıldı'
            ],
            [
                'id' => 702,
                'patient_name' => 'Ahmet Can',
                'national_id' => '22334455667',
                'age' => 48,
                'gender' => 'Erkek',
                'room' => 'AH-102',
                'service' => 'Aile Hekimliği Polikliniği',
                'diagnosis' => 'GGK Kanser Taraması & İnfluenza Aşı İslemi',
                'attending_physician' => 'Uzm. Dr. Aylin Güneş',
                'hyp_status' => 'SCORE Kardiyovasküler Risk %1.8 (Normal)',
                'vaccine_status' => 'İnfluenza Aşısı Reçete Edildi'
            ],
            [
                'id' => 703,
                'patient_name' => 'Sevgi Arslan',
                'national_id' => '33445566778',
                'age' => 27,
                'gender' => 'Kadın',
                'room' => 'AH-103',
                'service' => 'Aile Hekimliği Polikliniği',
                'diagnosis' => 'Evlilik Öncesi SMA & Thalassemia Taraması',
                'attending_physician' => 'Uzm. Dr. Aylin Güneş',
                'hyp_status' => 'Premarital Sağlık Taraması Uygun',
                'vaccine_status' => 'Hepatit B Aşı Kürü Başlandı'
            ]
        ];

        if (!session()->has('family_medicine_admissions')) {
            session(['family_medicine_admissions' => $defaultAdmissions]);
        }

        $familyAdmissions = session('family_medicine_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($familyAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($familyAdmissions) > 0) {
            $selectedAdmission = reset($familyAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $familyExams = session('family_medicine_exams', []);

        return view('modules.family_medicine.index', compact(
            'familyAdmissions',
            'selectedAdmission',
            'selectedId',
            'familyExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('family_medicine_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Uzm. Dr. Aylin Güneş',
            'date' => date('d.m.Y H:i')
        ];

        session(['family_medicine_exams' => $exams]);

        return redirect()->route('family_medicine.index', ['admission_id' => $admissionId])
            ->with('success', 'Aile Hekimliği muayene kaydı ve HYP parametreleri kaydedildi.');
    }
}
