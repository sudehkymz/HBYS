<?php

namespace App\Modules\Inpatient\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmissionController extends Controller
{
    /**
     * Display the admission dashboard and active inpatients.
     */
    public function index(Request $request)
    {
        // Try fetching real patients from the database
        $patients = [];
        try {
            $dbPatients = \App\Modules\Patient\Models\Patient::latest()->get();
            foreach ($dbPatients as $p) {
                $age = $p->birth_date ? $p->birth_date->age : 30;
                $patients[] = [
                    'id' => $p->id,
                    'national_id' => $p->national_id,
                    'name' => $p->full_name,
                    'age' => $age,
                    'gender' => $p->gender === 'male' || $p->gender === 'Erkek' ? 'Erkek' : 'Kadın',
                    'diagnosis' => 'Genel Klinik İnceleme'
                ];
            }
        } catch (\Exception $e) {
            // Ignore database errors and use mock data
        }

        // Mock Patients waiting for Inpatient Admission if DB is empty or fails
        if (empty($patients)) {
            $patients = [
                [
                    'id' => 10,
                    'national_id' => '11223344556',
                    'name' => 'Caner Yılmaz',
                    'age' => 29,
                    'gender' => 'Erkek',
                    'diagnosis' => 'Akut Apandisit (Acil Yatış)'
                ],
                [
                    'id' => 11,
                    'national_id' => '22334455667',
                    'name' => 'Hale Demir',
                    'age' => 31,
                    'gender' => 'Kadın',
                    'diagnosis' => 'Gebelik Takibi (Doğum Öncesi)'
                ],
                [
                    'id' => 12,
                    'national_id' => '33445566778',
                    'name' => 'Kemal Aslan',
                    'age' => 64,
                    'gender' => 'Erkek',
                    'diagnosis' => 'Koledokolitiyazis (Safra Yolu Taşı)'
                ]
            ];
        }

        // Try fetching real doctors from the database
        $doctors = [];
        try {
            $dbDoctors = \App\Modules\Personnel\Models\Doctor::all();
            foreach ($dbDoctors as $d) {
                $doctors[] = [
                    'name' => $d->name,
                    'specialty' => $d->specialty
                ];
            }
        } catch (\Exception $e) {
            // Ignore DB errors
        }

        if (empty($doctors)) {
            $doctors = [
                ['name' => 'Dr. Kürşat Kıran', 'specialty' => 'Genel Cerrahi'],
                ['name' => 'Dr. Ahmet Tan', 'specialty' => 'Dahiliye'],
                ['name' => 'Dr. Selin Saygı', 'specialty' => 'Çocuk Sağlığı'],
                ['name' => 'Dr. Merve Çelik', 'specialty' => 'Kadın Doğum']
            ];
        }

        // Auto-refresh beds session if VIP service is not present
        if (session()->has('beds') && !collect(session('beds'))->contains('service', 'VIP & Suit Servisi')) {
            session()->forget('beds');
        }

        // Mock Beds status (25 beds per service, plus 10 VIP suites)
        if (!session()->has('beds')) {
            $services = ['Genel Cerrahi', 'Dahiliye', 'Kadın Doğum', 'Çocuk Sağlığı', 'VIP & Suit Servisi'];
            $defaultBeds = [];
            $bedId = 1;
            
            foreach ($services as $serviceIndex => $service) {
                if ($service === 'VIP & Suit Servisi') {
                    // VIP Suites (1 bed per room: VIP-501, VIP-502...)
                    for ($i = 1; $i <= 10; $i++) {
                        $roomNum = 500 + $i;
                        $bedName = "VIP-{$roomNum}";
                        $defaultBeds[] = [
                            'id' => $bedId++,
                            'service' => $service,
                            'room' => (string)$roomNum,
                            'bed' => $bedName,
                            'status' => 'bos',
                            'status_tr' => 'Boş',
                            'patient_name' => null
                        ];
                    }
                } else {
                    $baseRoom = ($serviceIndex + 1) * 100; // 100, 200, 300, 400
                    for ($i = 1; $i <= 25; $i++) {
                        $roomOffset = ceil($i / 2); // 2 beds per room: 101-A, 101-B, etc.
                        $roomNum = $baseRoom + $roomOffset;
                        $bedLetter = ($i % 2 === 1) ? 'A' : 'B';
                        $bedName = "{$roomNum}-{$bedLetter}";
                        
                        $status = 'bos';
                        $statusTr = 'Boş';
                        $patientName = null;
                        
                        // Match existing patient locations to avoid breaking admissions
                        if ($service === 'Genel Cerrahi' && $bedName === '101-A') {
                            $status = 'dolu';
                            $statusTr = 'Dolu';
                            $patientName = 'Hasan Kale';
                        } elseif ($service === 'Genel Cerrahi' && $bedName === '102-A') {
                            $status = 'temizlik';
                            $statusTr = 'Temizlik Bekliyor';
                        } elseif ($service === 'Dahiliye' && $bedName === '201-A') {
                            $status = 'dolu';
                            $statusTr = 'Dolu';
                            $patientName = 'Zeynep Ak';
                        } elseif ($service === 'Dahiliye' && $bedName === '202-A') {
                            $status = 'izolasyon';
                            $statusTr = 'İzolasyon';
                            $patientName = 'Mustafa Solmaz';
                        } elseif ($service === 'Kadın Doğum' && $bedName === '301-A') {
                            $status = 'dolu';
                            $statusTr = 'Dolu';
                            $patientName = 'Hale Demir';
                        } elseif ($service === 'Çocuk Sağlığı' && $bedName === '401-A') {
                            $status = 'dolu';
                            $statusTr = 'Dolu';
                            $patientName = 'Ayaz Toprak';
                        }
                        
                        $defaultBeds[] = [
                            'id' => $bedId++,
                            'service' => $service,
                            'room' => (string)$roomNum,
                            'bed' => $bedName,
                            'status' => $status,
                            'status_tr' => $statusTr,
                            'patient_name' => $patientName
                        ];
                    }
                }
            }
            session(['beds' => $defaultBeds]);
        }
        $beds = session('beds');

        // Default Active Inpatient Admissions
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
            ],
            [
                'id' => 505,
                'patient_name' => 'Hale Demir',
                'national_id' => '22334455667',
                'age' => 31,
                'gender' => 'Kadın',
                'service' => 'Kadın Doğum',
                'room' => '301',
                'bed' => '301-A',
                'diagnosis' => 'Gebelik Takibi (Doğum Öncesi)',
                'attending_physician' => 'Dr. Merve Çelik',
                'admission_date' => now()->subDays(2)->format('d.m.Y H:i'),
                'companion' => 'Eşi (Murat Demir)'
            ]
        ];

        if (!session()->has('admissions')) {
            session(['admissions' => $defaultAdmissions]);
        }
        $admissions = session('admissions');

        // Bed occupancy stats
        $stats = [
            'total' => count($beds),
            'dolu' => collect($beds)->where('status', 'dolu')->count() + collect($beds)->where('status', 'izolasyon')->count(),
            'bos' => collect($beds)->where('status', 'bos')->count(),
            'other' => collect($beds)->whereIn('status', ['temizlik', 'rezerve', 'bakim'])->count(),
        ];

        return view('modules.inpatient.admission', compact('patients', 'doctors', 'beds', 'admissions', 'stats'));
    }

    /**
     * Store a new patient admission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|integer',
            'service' => 'required|string',
            'bed_id' => 'required|integer',
            'diagnosis' => 'required|string|max:500',
            'companion' => 'nullable|string|max:200',
            'attending_physician' => 'required|string',
        ]);

        // Find patient from database first
        $patient = null;
        try {
            $dbPatient = \App\Modules\Patient\Models\Patient::find($validated['patient_id']);
            if ($dbPatient) {
                $patient = [
                    'name' => $dbPatient->full_name,
                    'age' => $dbPatient->birth_date ? $dbPatient->birth_date->age : 30,
                    'gender' => $dbPatient->gender === 'male' || $dbPatient->gender === 'Erkek' ? 'Erkek' : 'Kadın',
                    'national_id' => $dbPatient->national_id
                ];
            }
        } catch (\Exception $e) {
            // Ignore DB errors
        }

        if (!$patient) {
            // Mock list of patients waiting
            $waitingPatients = [
                10 => ['name' => 'Caner Yılmaz', 'age' => 29, 'gender' => 'Erkek', 'national_id' => '11223344556'],
                11 => ['name' => 'Hale Demir', 'age' => 31, 'gender' => 'Kadın', 'national_id' => '22334455667'],
                12 => ['name' => 'Kemal Aslan', 'age' => 64, 'gender' => 'Erkek', 'national_id' => '33445566778']
            ];
            $patient = $waitingPatients[$validated['patient_id']] ?? [
                'name' => 'Bilinmeyen Hasta',
                'age' => 0,
                'gender' => 'Belirtilmemiş',
                'national_id' => '00000000000'
            ];
        }

        // Fetch beds
        $beds = session('beds', []);
        $selectedBedIndex = null;
        foreach ($beds as $index => $bed) {
            if ($bed['id'] == $validated['bed_id']) {
                $selectedBedIndex = $index;
                break;
            }
        }

        if ($selectedBedIndex === null || $beds[$selectedBedIndex]['status'] === 'dolu') {
            return redirect()->back()->withErrors(['bed_id' => 'Seçilen yatak dolu veya geçersiz.']);
        }

        // Update bed status in session
        $beds[$selectedBedIndex]['status'] = 'dolu';
        $beds[$selectedBedIndex]['status_tr'] = 'Dolu';
        $beds[$selectedBedIndex]['patient_name'] = $patient['name'];
        session(['beds' => $beds]);

        // Add new admission
        $newAdmission = [
            'id' => time(),
            'patient_name' => $patient['name'],
            'national_id' => $patient['national_id'],
            'age' => $patient['age'],
            'gender' => $patient['gender'],
            'service' => $validated['service'],
            'room' => $beds[$selectedBedIndex]['room'],
            'bed' => $beds[$selectedBedIndex]['bed'],
            'diagnosis' => $validated['diagnosis'],
            'attending_physician' => $validated['attending_physician'],
            'admission_date' => now()->format('d.m.Y H:i'),
            'companion' => $validated['companion'] ?: 'Yok'
        ];

        $admissions = session('admissions', []);
        array_unshift($admissions, $newAdmission);
        session(['admissions' => $admissions]);

        // Add to timeline events
        $timelineEvents = session('timeline_events', []);
        array_unshift($timelineEvents, [
            'time' => now()->format('d.m.Y H:i'),
            'type' => 'Yatış',
            'badge_color' => 'success',
            'details' => "{$patient['name']} isimli hasta {$beds[$selectedBedIndex]['service']} servisi, Oda {$beds[$selectedBedIndex]['room']}, Yatak {$beds[$selectedBedIndex]['bed']} numarasına yatırıldı. Tanı: {$validated['diagnosis']}"
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('inpatient.admission.index')->with('success', 'Hasta yatış işlemi başarıyla tamamlandı!');
    }

    /**
     * Transfer patient to a different bed.
     */
    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'new_bed_id' => 'required|integer'
        ]);

        $admissions = session('admissions', []);
        $selectedAdmissionIndex = null;
        foreach ($admissions as $index => $adm) {
            if ($adm['id'] == $validated['admission_id']) {
                $selectedAdmissionIndex = $index;
                break;
            }
        }

        if ($selectedAdmissionIndex === null) {
            return redirect()->back()->withErrors(['admission_id' => 'Geçersiz yatış kaydı.']);
        }

        $admission = $admissions[$selectedAdmissionIndex];

        // Fetch beds
        $beds = session('beds', []);
        $newBedIndex = null;
        $oldBedIndex = null;

        foreach ($beds as $index => $bed) {
            if ($bed['id'] == $validated['new_bed_id']) {
                $newBedIndex = $index;
            }
            if ($bed['room'] == $admission['room'] && $bed['bed'] == $admission['bed']) {
                $oldBedIndex = $index;
            }
        }

        if ($newBedIndex === null || $beds[$newBedIndex]['status'] === 'dolu') {
            return redirect()->back()->withErrors(['new_bed_id' => 'Transfer edilmek istenen yatak dolu veya geçersiz.']);
        }

        // Empty old bed
        if ($oldBedIndex !== null) {
            $beds[$oldBedIndex]['status'] = 'temizlik';
            $beds[$oldBedIndex]['status_tr'] = 'Temizlik Bekliyor';
            $beds[$oldBedIndex]['patient_name'] = null;
        }

        // Fill new bed
        $beds[$newBedIndex]['status'] = 'dolu';
        $beds[$newBedIndex]['status_tr'] = 'Dolu';
        $beds[$newBedIndex]['patient_name'] = $admission['patient_name'];
        session(['beds' => $beds]);

        // Update admission details
        $admissions[$selectedAdmissionIndex]['room'] = $beds[$newBedIndex]['room'];
        $admissions[$selectedAdmissionIndex]['bed'] = $beds[$newBedIndex]['bed'];
        $admissions[$selectedAdmissionIndex]['service'] = $beds[$newBedIndex]['service'];
        session(['admissions' => $admissions]);

        // Add to timeline events
        $timelineEvents = session('timeline_events', []);
        array_unshift($timelineEvents, [
            'time' => now()->format('d.m.Y H:i'),
            'type' => 'Transfer',
            'badge_color' => 'info',
            'details' => "{$admission['patient_name']} isimli hasta Oda {$admission['room']}, Yatak {$admission['bed']} konumundan Oda {$beds[$newBedIndex]['room']}, Yatak {$beds[$newBedIndex]['bed']} ({$beds[$newBedIndex]['service']} servisi) konumuna transfer edildi."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('inpatient.admission.index')->with('success', 'Hasta transfer işlemi başarıyla tamamlandı!');
    }

    /**
     * Display patient care timeline.
     */
    public function timeline(Request $request)
    {
        $defaultTimelineEvents = [
            [
                'time' => now()->subHours(2)->format('d.m.Y H:i'),
                'type' => 'Epikriz / Taburcu',
                'badge_color' => 'danger',
                'details' => 'Caner Öz isimli hasta Genel Cerrahi servisinden taburcu edildi. Reçete Kodu: MOCK-RX-1289'
            ],
            [
                'time' => now()->subHours(6)->format('d.m.Y H:i'),
                'type' => 'İlaç Uygulama',
                'badge_color' => 'primary',
                'details' => 'Zeynep Ak isimli hastaya hekim istemi doğrultusunda Insulin uygulaması yapıldı.'
            ],
            [
                'time' => now()->subHours(12)->format('d.m.Y H:i'),
                'type' => 'Yatış',
                'badge_color' => 'success',
                'details' => 'Zeynep Ak isimli hasta Dahiliye servisi, Oda 201, Yatak 201-A numarasına yatırıldı.'
            ],
            [
                'time' => now()->subHours(24)->format('d.m.Y H:i'),
                'type' => 'Laboratuvar Sonuç',
                'badge_color' => 'warning',
                'details' => 'Hasan Kale isimli hastanın Hemogram ve Biyokimya tahlil sonuçları sisteme girildi.'
            ]
        ];

        if (!session()->has('timeline_events')) {
            session(['timeline_events' => $defaultTimelineEvents]);
        }

        $timelineEvents = session('timeline_events');

        return view('modules.inpatient.timeline', compact('timelineEvents'));
    }

    /**
     * Add a new bed to the session.
     */
    public function addBed(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|string',
            'room' => 'required|string|max:10',
            'bed' => 'required|string|max:10',
            'status' => 'required|string|in:bos,temizlik,izolasyon,rezerve,izole',
        ]);

        $beds = session('beds', []);
        
        // Generate new ID
        $newId = count($beds) > 0 ? max(array_column($beds, 'id')) + 1 : 1;

        $statusTrMap = [
            'bos' => 'Boş',
            'temizlik' => 'Temizlik Bekliyor',
            'izolasyon' => 'İzolasyon',
            'rezerve' => 'Rezerve',
            'izole' => 'İzole Edildi'
        ];

        $beds[] = [
            'id' => $newId,
            'service' => $validated['service'],
            'room' => $validated['room'],
            'bed' => $validated['bed'],
            'status' => $validated['status'],
            'status_tr' => $statusTrMap[$validated['status']] ?? 'Bilinmiyor',
            'patient_name' => null
        ];

        session(['beds' => $beds]);

        return redirect()->route('inpatient.admission.index')->with('success', 'Yeni yatak başarıyla tanımlandı!');
    }

    /**
     * Update status of an existing bed.
     */
    public function updateBedStatus(Request $request)
    {
        $validated = $request->validate([
            'bed_id' => 'required|string', // Can be single ID or comma-separated list of IDs e.g. "1,2,5"
            'status' => 'required|string|in:bos,dolu,temizlik,izolasyon,rezerve,izole',
        ]);

        $bedIds = explode(',', $validated['bed_id']);
        $beds = session('beds', []);
        
        $updatedCount = 0;
        $statusTrMap = [
            'bos' => 'Boş',
            'dolu' => 'Dolu',
            'temizlik' => 'Temizlik Bekliyor',
            'izolasyon' => 'İzolasyon',
            'rezerve' => 'Rezerve',
            'izole' => 'İzole Edildi'
        ];

        foreach ($beds as $index => $bed) {
            if (in_array($bed['id'], $bedIds)) {
                $newStatus = $validated['status'];
                $beds[$index]['status'] = $newStatus;
                $beds[$index]['status_tr'] = $statusTrMap[$newStatus];
                
                if (!in_array($newStatus, ['dolu', 'izolasyon'])) {
                    $beds[$index]['patient_name'] = null;
                }
                $updatedCount++;
            }
        }

        if ($updatedCount > 0) {
            session(['beds' => $beds]);
            return redirect()->route('inpatient.admission.index')->with('success', "{$updatedCount} adet yatak durumu başarıyla güncellendi!");
        }

        return redirect()->back()->withErrors(['bed_id' => 'Yatak bulunamadı.']);
    }
}