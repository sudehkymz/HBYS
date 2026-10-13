<?php

namespace App\Modules\Nursing\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Personnel\Models\Doctor;

class NursingController extends Controller
{
    /**
     * Display nursing panel and patient chart.
     */
    public function index(Request $request)
    {
        if (!session()->has('admissions')) {
            $defaultAdmissions = [
                [
                    'id' => 501,
                    'patient_name' => 'Hasan Kale',
                    'national_id' => '12312312312',
                    'age' => 45,
                    'gender' => 'Erkek',
                    'service' => 'Genel Cerrahi',
                    'room' => '101',
                    'bed' => '101-A',
                    'diagnosis' => 'Kolelitiazis (Safra Kesesi İltihabı)',
                    'attending_physician' => 'Dr. Kürşat Kıran',
                    'admission_date' => now()->subDays(4)->format('d.m.Y H:i'),
                    'companion' => 'Eşi (Ayşe Kale)'
                ],
                [
                    'id' => 502,
                    'patient_name' => 'Zeynep Ak',
                    'national_id' => '45645645645',
                    'age' => 52,
                    'gender' => 'Kadın',
                    'service' => 'Dahiliye',
                    'room' => '201',
                    'bed' => '201-A',
                    'diagnosis' => 'Kontrolsüz Diyabet ve Dehidratasyon',
                    'attending_physician' => 'Dr. Ahmet Tan',
                    'admission_date' => now()->subDays(2)->format('d.m.Y H:i'),
                    'companion' => 'Kızı (Ebru Ak)'
                ],
                [
                    'id' => 503,
                    'patient_name' => 'Mustafa Solmaz',
                    'national_id' => '78978978978',
                    'age' => 68,
                    'gender' => 'Erkek',
                    'service' => 'Dahiliye',
                    'room' => '202',
                    'bed' => '202-A',
                    'diagnosis' => 'KOAH Alevlenmesi (Pnömoni)',
                    'attending_physician' => 'Dr. Ahmet Tan',
                    'admission_date' => now()->subDays(3)->format('d.m.Y H:i'),
                    'companion' => 'Yok'
                ],
                [
                    'id' => 504,
                    'patient_name' => 'Ayaz Toprak',
                    'national_id' => '25825825825',
                    'age' => 7,
                    'gender' => 'Erkek',
                    'service' => 'Çocuk Sağlığı',
                    'room' => '401',
                    'bed' => '401-A',
                    'diagnosis' => 'Akut Bronşiyolit',
                    'attending_physician' => 'Dr. Selin Saygı',
                    'admission_date' => now()->subHours(18)->format('d.m.Y H:i'),
                    'companion' => 'Annesi (Suna Toprak)'
                ]
            ];
            session(['admissions' => $defaultAdmissions]);
        }
        $admissions = session('admissions', []);
        $selectedId = $request->query('admission_id');
        
        $selectedAdmission = null;
        if ($selectedId) {
            foreach ($admissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        } elseif (count($admissions) > 0) {
            $selectedAdmission = $admissions[0];
            $selectedId = $selectedAdmission['id'];
        }

        // Default vital signs logs
        $defaultObservations = [
            501 => [
                ['time' => '27.07.2026 08:00', 'systolic' => 120, 'diastolic' => 80, 'pulse' => 72, 'temp' => 36.6, 'spo2' => 98],
                ['time' => '27.07.2026 12:00', 'systolic' => 125, 'diastolic' => 82, 'pulse' => 75, 'temp' => 36.8, 'spo2' => 97],
            ],
            502 => [
                ['time' => '27.07.2026 09:00', 'systolic' => 135, 'diastolic' => 85, 'pulse' => 80, 'temp' => 37.1, 'spo2' => 96],
            ]
        ];

        // Default medication logs
        $defaultMedications = [
            501 => [
                ['time' => '27.07.2026 08:00', 'name' => 'Parol 500mg Tablet', 'dose' => '1 Adet', 'nurse' => 'Hemşire Meltem Öz', 'status' => 'Uygulandı'],
                ['time' => '27.07.2026 10:00', 'name' => 'Cefazol 1g IV flakon', 'dose' => '1 Flakon', 'nurse' => 'Hemşire Meltem Öz', 'status' => 'Uygulandı']
            ],
            502 => [
                ['time' => '27.07.2026 09:00', 'name' => 'Lantus Solostar 10 Ünite SC', 'dose' => '10 Ünite', 'nurse' => 'Hemşire Meltem Öz', 'status' => 'Uygulandı']
            ]
        ];

        // Default nursing notes
        $defaultNotes = [
            501 => [
                ['time' => '27.07.2026 08:30', 'nurse' => 'Hemşire Meltem Öz', 'note' => 'Hasta sabah vizitinde değerlendirildi. Ameliyat bölgesi pansumanı temiz, sızıntı yok. Vital bulgular stabil.'],
            ],
            502 => [
                ['time' => '27.07.2026 09:15', 'nurse' => 'Hemşire Meltem Öz', 'note' => 'Hastanın kan şekeri takibi yapıldı. SC insülin uygulaması sonrasında hipoglisemi semptomları yönünden izleniyor.'],
            ]
        ];

        if (!session()->has('nursing_observations')) {
            session(['nursing_observations' => $defaultObservations]);
        }
        if (!session()->has('nursing_medications')) {
            session(['nursing_medications' => $defaultMedications]);
        }
        if (!session()->has('nursing_notes')) {
            session(['nursing_notes' => $defaultNotes]);
        }

        $observations = session('nursing_observations');
        $medications = session('nursing_medications');
        $notes = session('nursing_notes');

        $activeObservations = $selectedId && isset($observations[$selectedId]) ? $observations[$selectedId] : [];
        $activeMedications = $selectedId && isset($medications[$selectedId]) ? $medications[$selectedId] : [];
        $activeNotes = $selectedId && isset($notes[$selectedId]) ? $notes[$selectedId] : [];

        // Fetch doctors with fallback
        $doctors = [];
        try {
            $doctors = Doctor::all();
        } catch (\Exception $e) {
            // Ignore DB errors
        }
        if (empty($doctors) || (is_object($doctors) && method_exists($doctors, 'isEmpty') && $doctors->isEmpty())) {
            $doctors = collect([
                (object) ['id' => 1, 'name' => 'Prof. Dr. Ali Kaya', 'specialty' => 'Kardiyoloji'],
                (object) ['id' => 2, 'name' => 'Doç. Dr. Zeynep Can', 'specialty' => 'Nöroloji']
            ]);
        }

        return view('modules.nursing.index', compact(
            'admissions', 
            'selectedAdmission',
            'selectedId',
            'observations', 
            'medications', 
            'notes',
            'doctors'
        ));
    }

    /**
     * Store vital signs observation.
     */
    public function observe(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'systolic' => 'required|integer',
            'diastolic' => 'required|integer',
            'pulse' => 'required|integer',
            'temp' => 'required|numeric',
            'spo2' => 'required|integer',
        ]);

        $observations = session('nursing_observations', []);
        $admissionId = $validated['admission_id'];

        if (!isset($observations[$admissionId])) {
            $observations[$admissionId] = [];
        }

        $newObs = [
            'time' => now()->format('d.m.Y H:i'),
            'systolic' => $validated['systolic'],
            'diastolic' => $validated['diastolic'],
            'pulse' => $validated['pulse'],
            'temp' => $validated['temp'],
            'spo2' => $validated['spo2']
        ];

        array_unshift($observations[$admissionId], $newObs);
        session(['nursing_observations' => $observations]);

        // Add to timeline events
        $admissions = session('admissions', []);
        $patientName = 'Hasta';
        foreach ($admissions as $adm) {
            if ($adm['id'] == $admissionId) {
                $patientName = $adm['patient_name'];
                break;
            }
        }

        $timelineEvents = session('timeline_events', []);
        array_unshift($timelineEvents, [
            'time' => now()->format('d.m.Y H:i'),
            'type' => 'Hemşirelik Takip',
            'badge_color' => 'info',
            'details' => "{$patientName} isimli hastanın vital bulguları kaydedildi: TA: {$validated['systolic']}/{$validated['diastolic']} mmHg, Nabız: {$validated['pulse']}/dk, Ateş: {$validated['temp']} °C, SpO2: %{$validated['spo2']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('nursing.index', ['admission_id' => $admissionId])
            ->with('success', 'Vital bulgular başarıyla kaydedildi.');
    }

    /**
     * Log medication administration.
     */
    public function medicate(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'name' => 'required|string|max:150',
            'dose' => 'required|string|max:50',
            'nurse' => 'required|string|max:100',
        ]);

        $meds = session('nursing_medications', []);
        $admissionId = $validated['admission_id'];

        if (!isset($meds[$admissionId])) {
            $meds[$admissionId] = [];
        }

        $newMed = [
            'time' => now()->format('d.m.Y H:i'),
            'name' => $validated['name'],
            'dose' => $validated['dose'],
            'nurse' => $validated['nurse'],
            'status' => 'Uygulandı'
        ];

        array_unshift($meds[$admissionId], $newMed);
        session(['nursing_medications' => $meds]);

        // Add to timeline
        $admissions = session('admissions', []);
        $patientName = 'Hasta';
        foreach ($admissions as $adm) {
            if ($adm['id'] == $admissionId) {
                $patientName = $adm['patient_name'];
                break;
            }
        }

        $timelineEvents = session('timeline_events', []);
        array_unshift($timelineEvents, [
            'time' => now()->format('d.m.Y H:i'),
            'type' => 'İlaç Uygulama',
            'badge_color' => 'primary',
            'details' => "{$patientName} isimli hastaya ilaç uygulaması yapıldı: {$validated['name']} - Doz: {$validated['dose']} ({$validated['nurse']})."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('nursing.index', ['admission_id' => $admissionId])
            ->with('success', 'İlaç uygulaması kaydedildi.');
    }

    /**
     * Add nursing note.
     */
    public function note(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'nurse' => 'required|string|max:100',
            'note' => 'required|string|max:1000',
            'doctor_ids' => 'nullable|array',
            'doctor_ids.*' => 'integer',
        ]);

        $notes = session('nursing_notes', []);
        $admissionId = $validated['admission_id'];

        if (!isset($notes[$admissionId])) {
            $notes[$admissionId] = [];
        }

        // Get selected doctor names
        $sentDoctors = [];
        if (!empty($validated['doctor_ids'])) {
            try {
                $dbDoctors = Doctor::whereIn('id', $validated['doctor_ids'])->pluck('name')->toArray();
                if (!empty($dbDoctors)) {
                    $sentDoctors = $dbDoctors;
                }
            } catch (\Exception $e) {
                // Ignore DB errors
            }

            if (empty($sentDoctors)) {
                // Fallback for mock doctors
                foreach ($validated['doctor_ids'] as $docId) {
                    if ($docId == 1) $sentDoctors[] = 'Prof. Dr. Ali Kaya';
                    if ($docId == 2) $sentDoctors[] = 'Doç. Dr. Zeynep Can';
                }
            }
        }

        $newNote = [
            'time' => now()->format('d.m.Y H:i'),
            'nurse' => $validated['nurse'],
            'note' => $validated['note'],
            'sent_doctors' => $sentDoctors
        ];

        array_unshift($notes[$admissionId], $newNote);
        session(['nursing_notes' => $notes]);

        // Send to timeline/notification if doctors selected
        if (!empty($sentDoctors)) {
            $admissions = session('admissions', []);
            $patientName = 'Hasta';
            foreach ($admissions as $adm) {
                if ($adm['id'] == $admissionId) {
                    $patientName = $adm['patient_name'];
                    break;
                }
            }

            $docNames = implode(', ', $sentDoctors);
            $timelineEvents = session('timeline_events', []);
            array_unshift($timelineEvents, [
                'time' => now()->format('d.m.Y H:i'),
                'type' => 'Doktora Klinik Not Sevk',
                'badge_color' => 'warning',
                'details' => "{$patientName} isimli hasta için girilen klinik not, {$docNames} isimli doktor(lara) iletildi: \"{$validated['note']}\""
            ]);
            session(['timeline_events' => $timelineEvents]);
        }

        return redirect()->route('nursing.index', ['admission_id' => $admissionId])
            ->with('success', 'Hemşirelik notu kaydedildi ve seçilen doktorlara iletildi.');
    }
}
