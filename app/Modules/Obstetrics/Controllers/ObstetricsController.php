<?php

namespace App\Modules\Obstetrics\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObstetricsController extends Controller
{
    /**
     * Display obstetrics and newborn management dashboard.
     */
    public function index(Request $request)
    {
        $admissions = session('admissions', []);
        
        // Filter female admissions for pregnancy tracking
        $femaleAdmissions = collect($admissions)->where('gender', 'Kadın')->values()->all();
        
        $selectedId = $request->query('admission_id');

        $selectedAdmission = null;
        if ($selectedId) {
            foreach ($femaleAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        } elseif (count($femaleAdmissions) > 0) {
            $selectedAdmission = $femaleAdmissions[0];
            $selectedId = $selectedAdmission['id'];
        }

        // Default pregnancy records
        $defaultPregnancies = [
            505 => [
                'lmp' => '20.10.2025',
                'week' => '40',
                'risk' => 'Normal',
                'midwife' => 'Ebe Fatma Şen',
                'status' => 'Doğum Bekleniyor'
            ]
        ];

        // Default deliveries list
        $defaultDeliveries = [];

        if (!session()->has('pregnancy_records')) {
            session(['pregnancy_records' => $defaultPregnancies]);
        }
        if (!session()->has('deliveries_records')) {
            session(['deliveries_records' => $defaultDeliveries]);
        }

        $pregnancies = session('pregnancy_records');
        $deliveries = session('deliveries_records');

        $activePregnancy = $selectedId && isset($pregnancies[$selectedId]) ? $pregnancies[$selectedId] : null;
        $activeDelivery = $selectedId && isset($deliveries[$selectedId]) ? $deliveries[$selectedId] : null;

        return view('modules.obstetrics.index', compact(
            'femaleAdmissions',
            'selectedAdmission',
            'selectedId',
            'pregnancies',
            'deliveries'
        ));
    }

    /**
     * Create or update pregnancy details.
     */
    public function pregnancy(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'lmp' => 'required|string',
            'week' => 'required|integer',
            'risk' => 'required|string',
            'midwife' => 'required|string|max:100',
        ]);

        $pregnancies = session('pregnancy_records', []);
        $admissionId = $validated['admission_id'];

        $pregnancies[$admissionId] = [
            'lmp' => $validated['lmp'],
            'week' => $validated['week'],
            'risk' => $validated['risk'],
            'midwife' => $validated['midwife'],
            'status' => 'Doğum Bekleniyor'
        ];

        session(['pregnancy_records' => $pregnancies]);

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
            'type' => 'Gebelik Takip',
            'badge_color' => 'info',
            'details' => "{$patientName} isimli hastanın gebelik kartı oluşturuldu/güncellendi: Haftası: {$validated['week']}, Risk Seviyesi: {$validated['risk']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('obstetrics.index', ['admission_id' => $admissionId])
            ->with('success', 'Gebelik takibi kaydı başarıyla oluşturuldu.');
    }

    /**
     * Complete pregnancy and record delivery (generating a newborn baby card).
     */
    public function delivery(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'birth_date' => 'required|string',
            'baby_gender' => 'required|string|in:Erkek,Kız',
            'weight' => 'required|integer',
            'height' => 'required|integer',
            'apgar' => 'required|integer|min:0|max:10',
            'pediatrician' => 'required|string|max:100',
        ]);

        $admissionId = $validated['admission_id'];

        // Find mother
        $admissions = session('admissions', []);
        $motherIndex = null;
        foreach ($admissions as $index => $adm) {
            if ($adm['id'] == $admissionId) {
                $motherIndex = $index;
                break;
            }
        }

        if ($motherIndex === null) {
            return redirect()->back()->withErrors(['admission_id' => 'Anne yatış kaydı bulunamadı.']);
        }

        $mother = $admissions[$motherIndex];

        // Save delivery record
        $deliveries = session('deliveries_records', []);
        $deliveries[$admissionId] = [
            'birth_date' => $validated['birth_date'],
            'baby_gender' => $validated['baby_gender'],
            'weight' => $validated['weight'],
            'height' => $validated['height'],
            'apgar' => $validated['apgar'],
            'pediatrician' => $validated['pediatrician']
        ];
        session(['deliveries_records' => $deliveries]);

        // Update pregnancy status
        $pregnancies = session('pregnancy_records', []);
        if (isset($pregnancies[$admissionId])) {
            $pregnancies[$admissionId]['status'] = 'Doğum Yaptı';
            session(['pregnancy_records' => $pregnancies]);
        }

        // Create Newborn Baby Inpatient Admission Card!
        // Find a bed in Çocuk Sağlığı (or Kadın Doğum) for the baby
        $beds = session('beds', []);
        $babyBedIndex = null;
        foreach ($beds as $index => $b) {
            if (($b['service'] == 'Çocuk Sağlığı' || $b['service'] == 'Kadın Doğum') && $b['status'] == 'bos') {
                $babyBedIndex = $index;
                break;
            }
        }

        $babyName = "Bebek " . $mother['patient_name'] . " (" . $validated['baby_gender'] . ")";
        $babyRoom = '401';
        $babyBed = '401-B';

        if ($babyBedIndex !== null) {
            $beds[$babyBedIndex]['status'] = 'dolu';
            $beds[$babyBedIndex]['status_tr'] = 'Dolu';
            $beds[$babyBedIndex]['patient_name'] = $babyName;
            $babyRoom = $beds[$babyBedIndex]['room'];
            $babyBed = $beds[$babyBedIndex]['bed'];
            session(['beds' => $beds]);
        }

        $newbornAdmission = [
            'id' => time() . rand(10, 99),
            'patient_name' => $babyName,
            'national_id' => 'B-' . rand(100000, 999999),
            'age' => 0,
            'gender' => $validated['baby_gender'],
            'service' => 'Çocuk Sağlığı',
            'room' => $babyRoom,
            'bed' => $babyBed,
            'diagnosis' => 'Yenidoğan Sağlıklı Bebek',
            'attending_physician' => $validated['pediatrician'],
            'admission_date' => now()->format('d.m.Y H:i'),
            'companion' => 'Annesi (' . $mother['patient_name'] . ')'
        ];

        $admissions[] = $newbornAdmission;
        session(['admissions' => $admissions]);

        // Add to timeline
        $timelineEvents = session('timeline_events', []);
        array_unshift($timelineEvents, [
            'time' => now()->format('d.m.Y H:i'),
            'type' => 'Doğum / Yenidoğan',
            'badge_color' => 'success',
            'details' => "{$mother['patient_name']} isimli hasta doğum yaptı. {$babyName} dünyaya geldi. Ağırlık: {$validated['weight']} gr, Boy: {$validated['height']} cm, APGAR: {$validated['apgar']}. Doktor: {$validated['pediatrician']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('obstetrics.index', ['admission_id' => $admissionId])
            ->with('success', 'Doğum kaydı tamamlandı ve yenidoğan hasta kartı otomatik oluşturuldu.');
    }
}
