<?php

namespace App\Modules\Ent\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntController extends Controller
{
    public function index(Request $request)
    {
        $defaultAdmissions = [
            [
                'id' => 2101,
                'patient_name' => 'Bora Kılıç',
                'national_id' => '10293848692',
                'age' => 38,
                'gender' => 'Erkek',
                'room' => 'KBB-101 (Endoskopi Lab)',
                'service' => 'Kulak Burun Boğaz Hastalıkları (KBB)',
                'diagnosis' => 'Kronik Nazal Septum Deviasyonu & Endoskopik Sinüs Cerrahisi (FESS / Septoplasti)',
                'attending_physician' => 'Prof. Dr. Suat Şahin',
                'audiometry_results' => 'Saf Ses Odyometrisi: Havayolu SSO Sağ 15 dB, Sol 18 dB (İşitme Normal)',
                'nasal_endoscopy' => 'Rigid 0° Endoskopi: Sol Deviasyon, Bilateral Maksiller Sinüs Polipozisi',
                'surgical_plan' => 'Endoskopik Sinus Cerrahisi (FESS) + Septoplasti + Bilateral Konka Radyofrekansı'
            ],
            [
                'id' => 2102,
                'patient_name' => 'Nehir Yaman (Çocuk)',
                'national_id' => '21039486703',
                'age' => 6,
                'gender' => 'Kadın',
                'room' => 'KBB-102 (Pediatrik KBB)',
                'service' => 'Kulak Burun Boğaz Hastalıkları (KBB)',
                'diagnosis' => 'Adenotonsiller Hipertrofi & Seröz Otitis Media (Adenotonsillektomi + Havalandırma Tüpü)',
                'attending_physician' => 'Prof. Dr. Suat Şahin',
                'audiometry_results' => 'Timpanometri: Bilateral Tip B (İletim Tipi İşitme Kaybı 25 dB)',
                'nasal_endoscopy' => 'Nazofarenks Endoskopisi: Evre 3 Adenoid Hipertrofisi (Hava Yolu %80 Tıkalı)',
                'surgical_plan' => 'Adenoidosüktif Koblör Tonsillektomi + Bilateral Kulak Zarı Tüpü (Ventilation Tube)'
            ]
        ];

        if (!session()->has('ent_admissions')) {
            session(['ent_admissions' => $defaultAdmissions]);
        }

        $entAdmissions = session('ent_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($entAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($entAdmissions) > 0) {
            $selectedAdmission = reset($entAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $entExams = session('ent_exams', []);

        return view('modules.ent.index', compact(
            'entAdmissions',
            'selectedAdmission',
            'selectedId',
            'entExams'
        ));
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $formData = $request->input('form_data', []);

        $exams = session('ent_exams', []);
        $exams[$admissionId] = [
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'form_data' => $formData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Suat Şahin',
            'date' => date('d.m.Y H:i')
        ];

        session(['ent_exams' => $exams]);

        return redirect()->route('ent.index', ['admission_id' => $admissionId])
            ->with('success', 'KBB muayenesi ve endoskopi/odyometri kaydı başarıyla kaydedildi.');
    }
}
