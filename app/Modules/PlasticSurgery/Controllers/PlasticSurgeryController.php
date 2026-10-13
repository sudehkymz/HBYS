<?php

namespace App\Modules\PlasticSurgery\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlasticSurgeryController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.plastic_surgery.subspecialties.general', $context);
    }

    public function handSurgery(Request $request)
    {
        $context = $this->getPatientContext($request, 'hand_surgery');
        return view('modules.plastic_surgery.subspecialties.hand_surgery', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);
        $redirectRoute = $request->input('redirect_route', 'plastic_surgery.index');

        $exams = session('plastic_surgery_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Deniz Güneş',
            'date' => date('d.m.Y H:i')
        ];

        session(['plastic_surgery_exams' => $exams]);

        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Plastik ve Rekonstrüktif Cerrahi ameliyat kaydı kaydedildi.');
    }

    private function getPatientContext(Request $request, string $activeSubKey)
    {
        $defaultAdmissions = [
            [
                'id' => 2301,
                'patient_name' => 'Ebru Kaplan',
                'national_id' => '10293848814',
                'age' => 45,
                'gender' => 'Kadın',
                'room' => 'PRS-101 (Mikrocerrahi)',
                'service' => 'Plastik, Rekonstrüktif ve Estetik Cerrahi',
                'diagnosis' => 'Mastektomi Sonrası Serbest ALT (Anterolateral Uyluk) Flep İle Mikrovasküler Meme Rekonstrüksiyonu',
                'attending_physician' => 'Prof. Dr. Deniz Güneş',
                'flap_monitoring' => 'Mikrovasküler Serbest Flep: Perlatör Doppler Akım Şiddetli (+), Pembe Sıcak Dokututuculuğu',
                'pedicle_anastomosis' => 'Torakodorsal Arter-Ven İle Perforatör Arter Mikronastomozu (9-0 Monofilaman)',
                'donor_site' => 'Sol Sol Uyluk Donör Alanı Primer Kapatıldı'
            ],
            [
                'id' => 2302,
                'patient_name' => 'Kemal Ergün',
                'national_id' => '21039486925',
                'age' => 28,
                'gender' => 'Erkek',
                'room' => 'PRS-102 (El Cerrahisi Birimi)',
                'service' => 'El Cerrahisi (Ortak Yan Dal)',
                'diagnosis' => 'Sol El Volar Zone II Fleksör Tendon Kesisi (FDP + FDS) & Tenorafi / Kleinert Erken Mobilizasyon',
                'attending_physician' => 'Doç. Dr. Barış Soner (El Cerrahisi Uzmanı)',
                'tendon_repair' => 'Kore Sütürü (4-Strand Core Suture 3-0 Supramid) + Epitendon Sürekli Sütür 5-0',
                'nerve_repair' => 'Nöroliz & Dijital Sinir Epineöral Dikiş (10-0 Prolene Mikronörocerrahi)',
                'splint_protocol' => 'Volar Dinamik Kleinert Ateli (Dorsal Blok Ateli Wrist 30° Fleksiyonda)'
            ]
        ];

        if (!session()->has('plastic_admissions')) {
            session(['plastic_admissions' => $defaultAdmissions]);
        }

        $plasticAdmissions = session('plastic_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($plasticAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($plasticAdmissions) > 0) {
            $selectedAdmission = reset($plasticAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $plasticExams = session('plastic_surgery_exams', []);

        return compact(
            'plasticAdmissions',
            'selectedAdmission',
            'selectedId',
            'plasticExams',
            'activeSubKey'
        );
    }
}
