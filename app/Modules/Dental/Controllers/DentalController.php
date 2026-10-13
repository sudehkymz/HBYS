<?php

namespace App\Modules\Dental\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DentalController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_general');
        return view('modules.dental.subspecialties.general', $context);
    }

    public function surgery(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_surgery');
        return view('modules.dental.subspecialties.surgery', $context);
    }

    public function radiology(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_radiology');
        return view('modules.dental.subspecialties.radiology', $context);
    }

    public function pedodontics(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_pedodontics');
        return view('modules.dental.subspecialties.pedodontics', $context);
    }

    public function endodontics(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_endodontics');
        return view('modules.dental.subspecialties.endodontics', $context);
    }

    public function orthodontics(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_orthodontics');
        return view('modules.dental.subspecialties.orthodontics', $context);
    }

    public function periodontics(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_periodontics');
        return view('modules.dental.subspecialties.periodontics', $context);
    }

    public function prosthodontics(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_prosthodontics');
        return view('modules.dental.subspecialties.prosthodontics', $context);
    }

    public function restorative(Request $request)
    {
        $context = $this->getPatientContext($request, 'dental_restorative');
        return view('modules.dental.subspecialties.restorative', $context);
    }

    public function storeExam(Request $request)
    {
        $patientId = $request->input('patient_id');
        $subSpecialty = $request->input('sub_specialty', 'dental_general');
        $notes = $request->input('clinical_notes');
        $toothNotes = $request->input('tooth_notes', []);
        $subSpecialtyData = $request->input('sub_specialty_data', []);

        $exams = session('dental_exams_data', []);
        $exams[] = [
            'id' => rand(1000, 9999),
            'patient_id' => $patientId,
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'tooth_notes' => $toothNotes,
            'sub_specialty_data' => $subSpecialtyData,
            'created_at' => now()->toDateTimeString(),
            'dentist' => auth()->user()->name ?? 'Dr. Dt. Ahmet Yılmaz'
        ];
        session(['dental_exams_data' => $exams]);

        $redirectRoute = $request->input('redirect_route', 'dental.index');
        return redirect()->route($redirectRoute, ['patient_id' => $patientId])
            ->with('success', 'Diş hekimliği muayenesi ve odontogram işlemleri başarıyla kaydedildi.');
    }

    protected function getPatientContext(Request $request, string $activeSpecialtyKey): array
    {
        $defaultPatients = [
            [
                'id' => 801,
                'patient_name' => 'Murat Aksoy',
                'age' => 34,
                'gender' => 'Erkek',
                'national_id' => '40918273645',
                'service' => 'Diş Polikliniği',
                'chair' => 'Ünite 1',
                'teeth_status' => [
                    16 => ['condition' => 'dolgu', 'label' => 'Dolgu yapılmış (Kompozit)'],
                    21 => ['condition' => 'curuk', 'label' => 'Arayüz Çürüğü'],
                    36 => ['condition' => 'cekim', 'label' => 'Çekilmiş Diş'],
                    46 => ['condition' => 'kron', 'label' => 'Zirkonyum Kaplama']
                ]
            ],
            [
                'id' => 802,
                'patient_name' => 'Elif Yıldız (Çocuk)',
                'age' => 8,
                'gender' => 'Kız',
                'national_id' => '50827364152',
                'service' => 'Çocuk Diş Hekimliği (Pedodonti)',
                'chair' => 'Ünite 3 (Pedodonti)',
                'teeth_status' => [
                    54 => ['condition' => 'curuk', 'label' => 'Süt Azı Çürüğü'],
                    64 => ['condition' => 'dolgu', 'label' => 'Fissür Örtücü Uygulandı'],
                    75 => ['condition' => 'cekim', 'label' => 'Erken Süt Dişi Çekimi (Yer Tutucu Gerekli)']
                ]
            ],
            [
                'id' => 803,
                'patient_name' => 'Selin Demir',
                'age' => 26,
                'gender' => 'Kız',
                'national_id' => '60738291044',
                'service' => 'Ortodonti & Çene Cerrahisi',
                'chair' => 'Ünite 5',
                'teeth_status' => [
                    18 => ['condition' => 'gomulu', 'label' => '20\'lik Gömülü Diş'],
                    28 => ['condition' => 'gomulu', 'label' => '20\'lik Gömülü Diş'],
                    38 => ['condition' => 'gomulu', 'label' => 'Ağrılı Gömülü Diş (Cerrahi Çekim)'],
                    48 => ['condition' => 'gomulu', 'label' => '20\'lik Gömülü Diş']
                ]
            ]
        ];

        if (!session()->has('dental_patients_data')) {
            session(['dental_patients_data' => $defaultPatients]);
        }

        $dentalPatients = session('dental_patients_data', $defaultPatients);
        $selectedId = $request->query('patient_id');
        $selectedPatient = null;

        if ($selectedId) {
            foreach ($dentalPatients as $p) {
                if ($p['id'] == $selectedId) {
                    $selectedPatient = $p;
                    break;
                }
            }
        }

        if (!$selectedPatient && count($dentalPatients) > 0) {
            $selectedPatient = reset($dentalPatients);
            $selectedId = $selectedPatient['id'];
        }

        $dentalExams = session('dental_exams_data', []);

        return compact(
            'dentalPatients',
            'selectedPatient',
            'selectedId',
            'dentalExams',
            'activeSpecialtyKey'
        );
    }
}
