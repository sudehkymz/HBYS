<?php

namespace App\Modules\Laboratory\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiagnosticsController extends Controller
{
    /**
     * Display diagnostics workspace.
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

        // Available tests and imaging
        $labTests = [
            'Hemogram (Tam Kan Sayımı)', 
            'Biyokimya (Glikoz, Kreatinin, ALT/AST, AST)', 
            'HbA1c', 
            'Troponin', 
            'TSH',
            'CRP (C-Reaktif Protein)',
            'Sedimantasyon',
            'Tam İdrar Tetkiki (TİT)',
            'Vitamin B12 & Folat',
            'D Vitamini (25-OH Vitamin D)',
            'Koagülasyon Paneli (PT, APTT, INR)',
            'Elektrolitler (Sodyum, Potasyum, Klor, Kalsiyum)',
            'Tümör Belirteçleri (PSA, CEA, CA-125, CA-19-9)',
            'Kan Gazı Analizi',
            'Hormon Paneli (Serbest T3, Serbest T4, Beta-hCG)'
        ];
        $radTests = [
            'Akciğer Grafisi (Röntgen)', 
            'Tüm Batın USG (Ultrason)', 
            'Beyin MR', 
            'Toraks BT',
            'Mamografi',
            'Renkli Doppler USG (Karotis / Alt Ekstremite)',
            'Kemik Yoğunluğu Ölçümü (DEXA)',
            'Kranium BT (Beyin Tomografisi)',
            'Lomber MR (Bel Fıtığı / Omurga MR)',
            'Servikal MR',
            'Ekokardiyografi (EKO)'
        ];

        // Default orders
        $defaultOrders = [
            501 => [
                ['id' => 1001, 'type' => 'Laboratuvar', 'name' => 'Biyokimya (Glikoz, Kreatinin, ALT/AST)', 'status' => 'Sonuçlandı', 'ordered_at' => '27.07.2026 09:00'],
                ['id' => 1002, 'type' => 'Radyoloji', 'name' => 'Tüm Batın USG (Ultrason)', 'status' => 'İstem Yapıldı', 'ordered_at' => '27.07.2026 11:30']
            ],
            502 => [
                ['id' => 1003, 'type' => 'Laboratuvar', 'name' => 'HbA1c', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 08:30'],
                ['id' => 1004, 'type' => 'Laboratuvar', 'name' => 'Hemogram', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 08:30']
            ],
            503 => [
                ['id' => 1005, 'type' => 'Radyoloji', 'name' => 'Toraks BT', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 14:00'],
                ['id' => 1006, 'type' => 'Laboratuvar', 'name' => 'Hemogram', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 14:00']
            ],
            504 => [
                ['id' => 1007, 'type' => 'Radyoloji', 'name' => 'Akciğer Grafisi (Röntgen)', 'status' => 'Sonuçlandı', 'ordered_at' => '29.07.2026 10:15']
            ],
            505 => [
                ['id' => 1008, 'type' => 'Laboratuvar', 'name' => 'Hemogram', 'status' => 'Sonuçlandı', 'ordered_at' => '29.07.2026 09:00']
            ]
        ];

        $pathologyTests = [
            'Biyopsi (Doku Örneği İncelemesi)',
            'Sitolojik İnceleme (Sıvı Hücre İncelemesi)',
            'Servikal Yayma (Smear Testi)',
            'İnce İğne Aspirasyon Biyopsisi (İİAB)',
            'İmmünohistokimyasal Boyama'
        ];
        $cardiologyTests = [
            'Elektrokardiyografi (EKG)',
            'Ekokardiyografi (EKO)',
            'Efor Testi (Kardiyak Stres Testi)',
            'Holter İzlemi (24/48 Saatlik EKG)',
            'Tansiyon Holter (24 Saatlik Kan Basıncı Takibi)'
        ];

        // Default orders
        $defaultOrders = [
            501 => [
                ['id' => 1001, 'type' => 'Laboratuvar', 'name' => 'Biyokimya (Glikoz, Kreatinin, ALT/AST)', 'status' => 'Sonuçlandı', 'ordered_at' => '27.07.2026 09:00'],
                ['id' => 1002, 'type' => 'Radyoloji', 'name' => 'Tüm Batın USG (Ultrason)', 'status' => 'İstem Yapıldı', 'ordered_at' => '27.07.2026 11:30']
            ],
            502 => [
                ['id' => 1003, 'type' => 'Laboratuvar', 'name' => 'HbA1c', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 08:30'],
                ['id' => 1004, 'type' => 'Laboratuvar', 'name' => 'Hemogram', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 08:30']
            ],
            503 => [
                ['id' => 1005, 'type' => 'Radyoloji', 'name' => 'Toraks BT', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 14:00'],
                ['id' => 1006, 'type' => 'Laboratuvar', 'name' => 'Hemogram', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 14:00']
            ],
            504 => [
                ['id' => 1007, 'type' => 'Radyoloji', 'name' => 'Akciğer Grafisi (Röntgen)', 'status' => 'Sonuçlandı', 'ordered_at' => '29.07.2026 10:15']
            ],
            505 => [
                ['id' => 1008, 'type' => 'Laboratuvar', 'name' => 'Hemogram', 'status' => 'Sonuçlandı', 'ordered_at' => '29.07.2026 09:00']
            ]
        ];

        // Default results
        $defaultResults = [
            501 => [
                1001 => [
                    'result_summary' => 'Glikoz: 95 mg/dL (Normal), Kreatinin: 0.9 mg/dL (Normal), AST: 24 U/L (Normal), ALT: 30 U/L (Normal)',
                    'technician' => 'Uzm. Lab. Aslı Yıldız',
                    'completed_at' => '27.07.2026 10:30'
                ]
            ],
            502 => [
                1003 => [
                    'result_summary' => 'HbA1c: %8.4 (Yüksek). Kontrolsüz diyabet ile uyumlu.',
                    'technician' => 'Uzm. Lab. Aslı Yıldız',
                    'completed_at' => '28.07.2026 09:45'
                ],
                1004 => [
                    'result_summary' => 'WBC: 7.8 10^3/uL, RBC: 4.5 10^6/uL, HGB: 13.2 g/dL, PLT: 250 10^3/uL (Tüm değerler normal sınırlarda)',
                    'technician' => 'Uzm. Lab. Aslı Yıldız',
                    'completed_at' => '28.07.2026 09:45'
                ]
            ],
            503 => [
                1005 => [
                    'result_summary' => 'Her iki akciğer alt loblarda bilateral infiltrasyon ve konsolidasyon alanları izlenmiştir. Pnömoni (zatürre) ile uyumlu görünüm.',
                    'technician' => 'Radyoloji Tek. Hakan Genç',
                    'completed_at' => '28.07.2026 15:30'
                ],
                1006 => [
                    'result_summary' => 'WBC: 14.2 10^3/uL (Yüksek - Enfeksiyon ile uyumlu), HGB: 12.1 g/dL, PLT: 180 10^3/uL',
                    'technician' => 'Uzm. Lab. Aslı Yıldız',
                    'completed_at' => '28.07.2026 15:10'
                ]
            ],
            504 => [
                1007 => [
                    'result_summary' => 'Bronkovasküler gölgelerde belirginleşme ve peribronşiyal kalınlaşma izlenmiştir. Akut bronşiyolit tablosu ile uyumludur. Aktif infiltrasyon saptanmadı.',
                    'technician' => 'Radyoloji Tek. Hakan Genç',
                    'completed_at' => '29.07.2026 11:00'
                ]
            ],
            505 => [
                1008 => [
                    'result_summary' => 'WBC: 9.1 10^3/uL, HGB: 11.5 g/dL (Hafif düşük - Gebelik anemisi ile uyumlu), PLT: 220 10^3/uL',
                    'technician' => 'Uzm. Lab. Aslı Yıldız',
                    'completed_at' => '29.07.2026 10:15'
                ]
            ]
        ];

        if (!session()->has('diagnostics_orders')) {
            session(['diagnostics_orders' => $defaultOrders]);
        }
        if (!session()->has('diagnostics_results')) {
            session(['diagnostics_results' => $defaultResults]);
        }

        $orders = session('diagnostics_orders');
        $results = session('diagnostics_results');

        $activeOrders = $selectedId && isset($orders[$selectedId]) ? $orders[$selectedId] : [];
        $activeResults = $selectedId && isset($results[$selectedId]) ? $results[$selectedId] : [];

        return view('modules.diagnostics.index', compact(
            'admissions',
            'selectedAdmission',
            'selectedId',
            'labTests',
            'radTests',
            'pathologyTests',
            'cardiologyTests',
            'orders',
            'results'
        ));
    }

    /**
     * Request a diagnostics test (order).
     */
    public function requestTest(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'test_type' => 'required|string|in:Laboratuvar,Radyoloji,Patoloji,Kardiyoloji',
            'test_name' => 'required|string',
        ]);

        $orders = session('diagnostics_orders', []);
        $admissionId = $validated['admission_id'];

        if (!isset($orders[$admissionId])) {
            $orders[$admissionId] = [];
        }

        $orderId = time() . rand(10, 99);
        $newOrder = [
            'id' => $orderId,
            'type' => $validated['test_type'],
            'name' => $validated['test_name'],
            'status' => 'İstem Yapıldı',
            'ordered_at' => now()->format('d.m.Y H:i')
        ];

        array_unshift($orders[$admissionId], $newOrder);
        session(['diagnostics_orders' => $orders]);

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
            'type' => "{$validated['test_type']} İstem",
            'badge_color' => 'warning',
            'details' => "{$patientName} isimli hasta için {$validated['test_type']} istemi yapıldı: {$validated['test_name']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('diagnostics.index', ['admission_id' => $admissionId])
            ->with('success', 'Tetkik istemi başarıyla gönderildi.');
    }

    /**
     * Complete order and save diagnostics result.
     */
    public function saveResult(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'order_id' => 'required|integer',
            'result_summary' => 'required|string|max:1000',
            'technician' => 'required|string|max:100',
        ]);

        $admissionId = $validated['admission_id'];
        $orderId = $validated['order_id'];

        // Update order status
        $orders = session('diagnostics_orders', []);
        $foundOrder = null;
        if (isset($orders[$admissionId])) {
            foreach ($orders[$admissionId] as $index => $order) {
                if ($order['id'] == $orderId) {
                    $orders[$admissionId][$index]['status'] = 'Sonuçlandı';
                    $foundOrder = $order;
                    break;
                }
            }
            session(['diagnostics_orders' => $orders]);
        }

        if (!$foundOrder) {
            return redirect()->back()->withErrors(['order_id' => 'İstem kaydı bulunamadı.']);
        }

        // Save result details
        $results = session('diagnostics_results', []);
        if (!isset($results[$admissionId])) {
            $results[$admissionId] = [];
        }

        $results[$admissionId][$orderId] = [
            'result_summary' => $validated['result_summary'],
            'technician' => $validated['technician'],
            'completed_at' => now()->format('d.m.Y H:i')
        ];
        session(['diagnostics_results' => $results]);

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
            'type' => "{$foundOrder['type']} Sonuç",
            'badge_color' => 'success',
            'details' => "{$patientName} isimli hastanın {$foundOrder['name']} tetkiki sonuçlandı: {$validated['result_summary']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('diagnostics.index', ['admission_id' => $admissionId])
            ->with('success', 'Tetkik sonucu başarıyla kaydedildi.');
    }
}
