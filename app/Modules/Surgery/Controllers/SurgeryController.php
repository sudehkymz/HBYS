<?php

namespace App\Modules\Surgery\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SurgeryController extends Controller
{
    /**
     * Display surgery and anesthesia workspace.
     */
    public function index(Request $request)
    {
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

        // Mock surgery teams
        $surgeons = ['Dr. Kürşat Kıran', 'Dr. Hande Şen', 'Dr. Murat Yılmaz'];
        $anesthesiologists = ['Dr. Ceren Yıldız', 'Dr. Kaan Taş'];
        $rooms = ['Ameliyathane Salon A', 'Ameliyathane Salon B', 'Laparoskopi Odası'];

        // Default surgery schedules
        $defaultSchedules = [
            501 => [
                'room' => 'Ameliyathane Salon A',
                'surgeon' => 'Dr. Kürşat Kıran',
                'anesthesiologist' => 'Dr. Ceren Yıldız',
                'planned_date' => '28.07.2026 10:00',
                'operation' => 'Laparoskopik Kolesistektomi',
                'status' => 'Planlandı'
            ],
            505 => [
                'room' => 'Ameliyathane Salon B',
                'surgeon' => 'Dr. Merve Çelik',
                'anesthesiologist' => 'Dr. Kaan Taş',
                'planned_date' => now()->addDays(1)->format('d.m.Y') . ' 09:30',
                'operation' => 'Elektif Sezaryen Doğum',
                'status' => 'Planlandı'
            ]
        ];

        // Default anesthesia records
        $defaultAnesthesia = [
            501 => [
                'asa_score' => 'ASA II',
                'airway' => 'Mallampati Class I',
                'preop_note' => 'Hasta laparoskopik safra kesesi ameliyatı için pre-op değerlendirildi. Akciğer sesleri doğal, kardiyak yönden stabil. Genel anestezi uygun görüldü.'
            ],
            505 => [
                'asa_score' => 'ASA I',
                'airway' => 'Mallampati Class I',
                'preop_note' => 'Hasta elektif sezaryen doğum operasyonu için pre-op değerlendirildi. Havayolu açık, koopere. Spinal anestezi planlandı.'
            ]
        ];

        // Default surgery reports
        $defaultReports = [];

        if (!session()->has('surgery_schedules')) {
            session(['surgery_schedules' => $defaultSchedules]);
        }
        if (!session()->has('anesthesia_records')) {
            session(['anesthesia_records' => $defaultAnesthesia]);
        }
        if (!session()->has('surgery_reports')) {
            session(['surgery_reports' => $defaultReports]);
        }

        $schedules = session('surgery_schedules');
        $anesthesia = session('anesthesia_records');
        $reports = session('surgery_reports');

        $activeSchedule = $selectedId && isset($schedules[$selectedId]) ? $schedules[$selectedId] : null;
        $activeAnesthesia = $selectedId && isset($anesthesia[$selectedId]) ? $anesthesia[$selectedId] : null;
        $activeReport = $selectedId && isset($reports[$selectedId]) ? $reports[$selectedId] : null;

        return view('modules.surgery.index', compact(
            'admissions',
            'selectedAdmission',
            'selectedId',
            'surgeons',
            'anesthesiologists',
            'rooms',
            'schedules',
            'anesthesia',
            'reports'
        ));
    }

    /**
     * Schedule a surgery.
     */
    public function schedule(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'room' => 'required|string',
            'surgeon' => 'required|string',
            'anesthesiologist' => 'required|string',
            'planned_date' => 'required|string',
            'operation' => 'required|string|max:200',
        ]);

        $schedules = session('surgery_schedules', []);
        $admissionId = $validated['admission_id'];

        $schedules[$admissionId] = [
            'room' => $validated['room'],
            'surgeon' => $validated['surgeon'],
            'anesthesiologist' => $validated['anesthesiologist'],
            'planned_date' => $validated['planned_date'],
            'operation' => $validated['operation'],
            'status' => 'Planlandı'
        ];

        session(['surgery_schedules' => $schedules]);

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
            'type' => 'Ameliyat Kararı',
            'badge_color' => 'warning',
            'details' => "{$patientName} isimli hasta için ameliyat planlandı: {$validated['operation']} (Tarih: {$validated['planned_date']}, Cerrah: {$validated['surgeon']})."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('surgery.index', ['admission_id' => $admissionId])
            ->with('success', 'Ameliyat başarıyla planlandı.');
    }

    /**
     * Store anesthesia pre-op note.
     */
    public function anesthetize(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'asa_score' => 'required|string',
            'airway' => 'required|string',
            'preop_note' => 'required|string|max:1000',
        ]);

        $anesthesia = session('anesthesia_records', []);
        $admissionId = $validated['admission_id'];

        $anesthesia[$admissionId] = [
            'asa_score' => $validated['asa_score'],
            'airway' => $validated['airway'],
            'preop_note' => $validated['preop_note']
        ];

        session(['anesthesia_records' => $anesthesia]);

        // Update schedule status if planned
        $schedules = session('surgery_schedules', []);
        if (isset($schedules[$admissionId])) {
            $schedules[$admissionId]['status'] = 'Anestezi Onaylı';
            session(['surgery_schedules' => $schedules]);
        }

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
            'type' => 'Anestezi Notu',
            'badge_color' => 'info',
            'details' => "{$patientName} isimli hastanın anestezi pre-op değerlendirmesi tamamlandı: Skala: {$validated['asa_score']}, Havayolu: {$validated['airway']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('surgery.index', ['admission_id' => $admissionId])
            ->with('success', 'Anestezi pre-op değerlendirmesi başarıyla kaydedildi.');
    }

    /**
     * Store surgery post-op report.
     */
    public function report(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'findings' => 'required|string|max:1000',
            'complications' => 'required|string|max:500',
            'postop_care' => 'required|string|max:500',
        ]);

        $reports = session('surgery_reports', []);
        $admissionId = $validated['admission_id'];

        $reports[$admissionId] = [
            'findings' => $validated['findings'],
            'complications' => $validated['complications'],
            'postop_care' => $validated['postop_care'],
            'completed_at' => now()->format('d.m.Y H:i')
        ];

        session(['surgery_reports' => $reports]);

        // Update schedule status
        $schedules = session('surgery_schedules', []);
        if (isset($schedules[$admissionId])) {
            $schedules[$admissionId]['status'] = 'Tamamlandı';
            session(['surgery_schedules' => $schedules]);
        }

        // Add to timeline
        $admissions = session('admissions', []);
        $patientName = 'Hasta';
        $service = '';
        foreach ($admissions as $index => $adm) {
            if ($adm['id'] == $admissionId) {
                $patientName = $adm['patient_name'];
                $service = $adm['service'];
                
                // Update patient diagnosis if it changed due to findings
                $admissions[$index]['diagnosis'] = "Post-op: " . ($schedules[$admissionId]['operation'] ?? 'Operasyon');
                break;
            }
        }
        session(['admissions' => $admissions]);

        $timelineEvents = session('timeline_events', []);
        array_unshift($timelineEvents, [
            'time' => now()->format('d.m.Y H:i'),
            'type' => 'Ameliyat Notu',
            'badge_color' => 'success',
            'details' => "{$patientName} isimli hastanın ameliyatı tamamlandı. Bulgular: {$validated['findings']}. Komplikasyon: {$validated['complications']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('surgery.index', ['admission_id' => $admissionId])
            ->with('success', 'Ameliyat raporu başarıyla kaydedildi.');
    }
}
