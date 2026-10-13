<?php

namespace App\Modules\Pathology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PathologyController extends Controller
{
    /**
     * Display pathology workspace.
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

        // Available pathology tests
        $pathTests = [
            'Doku Biyopsisi (Histopatoloji)',
            'İnce İğne Aspirasyon Sitolojisi (İİAS)',
            'Eksfoliyatif Sitoloji (Yayma)',
            'Frozen İnceleme (Ameliyat Esnası Hızlı Tanı)',
            'Sıvı Bazlı Sitoloji (LBC - Pap Smear)',
            'Tru-cut (Karaciğer / Meme Kalın İğne) Biyopsisi',
            'Punch (Deri/Cilt) Biyopsisi',
            'Eksizyonel Biyopsi (Tümörün Tamamının Çıkarılması)',
            'İnsizyonel Biyopsi (Kısmi Doku Alımı)',
            'Hücre Bloğu İncelemesi',
            'İmmünohistokimya (İHK) Boyamaları',
            'Floresan İn Situ Hibridizasyon (FISH) Analizi',
            'Kemik İliği Biyopsisi İncelemesi'
        ];

        // Default orders
        $defaultOrders = [
            501 => [
                ['id' => 2001, 'type' => 'Patoloji', 'name' => 'Doku Biyopsisi (Histopatoloji)', 'status' => 'Sonuçlandı', 'ordered_at' => '27.07.2026 09:30']
            ],
            503 => [
                ['id' => 2002, 'type' => 'Patoloji', 'name' => 'Sputum Sitolojisi (Balgam Sitolojisi)', 'status' => 'Sonuçlandı', 'ordered_at' => '28.07.2026 14:30']
            ]
        ];

        // Default results
        $defaultResults = [
            501 => [
                2001 => [
                    'result_summary' => 'Makroskopi: 1 adet 0.5 cm çapında gri-beyaz renkli doku parçası. Mikroskopi: Kesitlerde benign kronik kolesistit bulguları izlenmiştir. Malignite lehine bulgu saptanmamıştır.',
                    'pathologist' => 'Uzm. Dr. Melis Kaya',
                    'completed_at' => '27.07.2026 13:00'
                ]
            ],
            503 => [
                2002 => [
                    'result_summary' => 'Mikroskopi: Yaymalarda yaygın nötrofil lökositler, alveolar makrofajlar ve skuamöz epitel hücreleri izlenmiştir. Neoplastik veya atipik hücre popülasyonu izlenmemiştir. Akut lober pnömoni tablosunu destekleyen sitolojik bulgular.',
                    'pathologist' => 'Uzm. Dr. Melis Kaya',
                    'completed_at' => '28.07.2026 17:15'
                ]
            ]
        ];

        if (!session()->has('pathology_orders')) {
            session(['pathology_orders' => $defaultOrders]);
        }
        if (!session()->has('pathology_results')) {
            session(['pathology_results' => $defaultResults]);
        }

        $orders = session('pathology_orders');
        $results = session('pathology_results');

        $activeOrders = $selectedId && isset($orders[$selectedId]) ? $orders[$selectedId] : [];
        $activeResults = $selectedId && isset($results[$selectedId]) ? $results[$selectedId] : [];

        return view('modules.pathology.index', compact(
            'admissions',
            'selectedAdmission',
            'selectedId',
            'pathTests',
            'orders',
            'results'
        ));
    }

    /**
     * Request a pathology test.
     */
    public function requestTest(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'test_name' => 'required|string',
        ]);

        $orders = session('pathology_orders', []);
        $admissionId = $validated['admission_id'];

        if (!isset($orders[$admissionId])) {
            $orders[$admissionId] = [];
        }

        $orderId = time() . rand(10, 99);
        $newOrder = [
            'id' => $orderId,
            'type' => 'Patoloji',
            'name' => $validated['test_name'],
            'status' => 'İstem Yapıldı',
            'ordered_at' => now()->format('d.m.Y H:i')
        ];

        array_unshift($orders[$admissionId], $newOrder);
        session(['pathology_orders' => $orders]);

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
            'type' => 'Patoloji İstem',
            'badge_color' => 'warning',
            'details' => "{$patientName} isimli hasta için Patoloji istemi yapıldı: {$validated['test_name']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('pathology.index', ['admission_id' => $admissionId])
            ->with('success', 'Patoloji tetkik istemi başarıyla gönderildi.');
    }

    /**
     * Complete order and save pathology result.
     */
    public function saveResult(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'order_id' => 'required|integer',
            'result_summary' => 'required|string|max:1000',
            'pathologist' => 'required|string|max:100',
        ]);

        $admissionId = $validated['admission_id'];
        $orderId = $validated['order_id'];

        // Update order status
        $orders = session('pathology_orders', []);
        $foundOrder = null;
        if (isset($orders[$admissionId])) {
            foreach ($orders[$admissionId] as $index => $order) {
                if ($order['id'] == $orderId) {
                    $orders[$admissionId][$index]['status'] = 'Sonuçlandı';
                    $foundOrder = $order;
                    break;
                }
            }
            session(['pathology_orders' => $orders]);
        }

        if (!$foundOrder) {
            return redirect()->back()->withErrors(['order_id' => 'İstem kaydı bulunamadı.']);
        }

        // Save result details
        $results = session('pathology_results', []);
        if (!isset($results[$admissionId])) {
            $results[$admissionId] = [];
        }

        $results[$admissionId][$orderId] = [
            'result_summary' => $validated['result_summary'],
            'pathologist' => $validated['pathologist'],
            'completed_at' => now()->format('d.m.Y H:i')
        ];
        session(['pathology_results' => $results]);

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
            'type' => 'Patoloji Sonuç',
            'badge_color' => 'success',
            'details' => "{$patientName} isimli hastanın {$foundOrder['name']} tetkiki sonuçlandı: {$validated['result_summary']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('pathology.index', ['admission_id' => $admissionId])
            ->with('success', 'Patoloji raporu başarıyla kaydedildi.');
    }
}
