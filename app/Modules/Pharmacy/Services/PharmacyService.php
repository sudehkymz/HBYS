<?php

namespace App\Modules\Pharmacy\Services;

class PharmacyService
{
    /**
     * Eczacı Sorgulaması: Ayaktan Hasta ve Yatan Hasta Ayrımı İle Reçete Sorgulama
     */
    public function searchPrescriptionAndWorkflow(?string $prescriptionCode = '', ?string $nationalId = '', ?string $patientName = '', int $step = 0): array
    {
        $prescriptionCode = (string) ($prescriptionCode ?? '');
        $nationalId = (string) ($nationalId ?? '');
        $patientName = (string) ($patientName ?? '');

        $prescriptions = [
            'EREP-2026-998811' => [
                'prescription_code' => 'EREP-2026-998811',
                'order_code' => 'ORD-2026-8841',
                'patient_name' => 'Ahmet Yılmaz',
                'national_id' => '12345678901',
                'birth_date' => '12.05.1985',
                'gender' => 'Erkek',
                'patient_type' => 'ayaktan',
                'patient_type_label' => 'Ayaktan Hasta (Poliklinik)',
                'clinic' => 'Kardiyoloji Polikliniği',
                'sgk_type' => 'SGK 4/a (SSK)',
                'physician' => 'Dr. Mehmet Öz (Kardiyoloji)',
                'diagnosis' => 'I10 - Essansiyel Hipertansiyon',
                'date' => date('d.m.Y'),
                'medula_info' => [
                    'provizyon_no' => 'PRV-2026-994411',
                    'total_price' => '142.50 TL',
                    'sgk_coverage' => '114.00 TL (%80 SGK)',
                    'patient_copay' => '28.50 TL',
                    'copay_status' => 'Katılım Payı (Eczanede Tahsil Edilecek)'
                ],
                'drugs' => [
                    [
                        'name' => 'Candesartan 16mg Tablet',
                        'barcode' => '8699543010012',
                        'its_status' => 'İTS Onaylı',
                        'box' => 1,
                        'dosage' => '1x1 (Sabah)',
                        'price' => '98.50 TL',
                        'sgk_rate' => '%80 SGK',
                        'sgk_pays' => '78.80 TL',
                        'patient_pays' => '19.70 TL',
                        'stock' => 140,
                        'shelf' => 'Raf A-12',
                        'stock_status' => 'Stokta Var',
                        'equivalent_generic' => 'Atacand 16mg / Ayra 16mg'
                    ],
                    [
                        'name' => 'Coraspin 100mg Tablet',
                        'barcode' => '8699500010022',
                        'its_status' => 'İTS Onaylı',
                        'box' => 1,
                        'dosage' => '1x1 (Tok)',
                        'price' => '44.00 TL',
                        'sgk_rate' => '%80 SGK',
                        'sgk_pays' => '35.20 TL',
                        'patient_pays' => '8.80 TL',
                        'stock' => 250,
                        'shelf' => 'Raf B-04',
                        'stock_status' => 'Stokta Var',
                        'equivalent_generic' => 'Aspirin 100mg'
                    ]
                ],
                'allergies' => ['Penasilin Alerjisi'],
                'interactions' => 'Güvenli (Etkileşim Yok)',
                'default_step' => 6
            ],
            'EREP-2026-554422' => [
                'prescription_code' => 'EREP-2026-554422',
                'order_code' => 'ORD-2026-8842',
                'patient_name' => 'Ayşe Demir',
                'national_id' => '98765432109',
                'birth_date' => '24.08.1992',
                'gender' => 'Kadın',
                'patient_type' => 'yatan_hasta',
                'patient_type_label' => 'Yatan Hasta (Klinik Servis - Yatak No: 304)',
                'clinic' => 'Kadın Doğum Servisi (Oda 304)',
                'sgk_type' => 'SGK 4/b (Bağ-Kur)',
                'physician' => 'Op. Dr. Elif Kaya (Kadın Doğum)',
                'diagnosis' => 'O09 - Gebelik Takibi & Astım',
                'date' => date('d.m.Y'),
                'medula_info' => [
                    'provizyon_no' => 'PRV-2026-552288',
                    'total_price' => '210.00 TL',
                    'sgk_coverage' => '210.00 TL (%100 Muaf)',
                    'patient_copay' => '0.00 TL',
                    'copay_status' => 'Yatan Hasta (Hastane Karşılıyor)'
                ],
                'drugs' => [
                    [
                        'name' => 'Ventolin Inhaler 100mcg',
                        'barcode' => '8699512345678',
                        'its_status' => 'İTS Onaylı',
                        'box' => 1,
                        'dosage' => '2 Puf (İhtiyaç halinde)',
                        'price' => '115.00 TL',
                        'sgk_rate' => '%100 Muaf',
                        'sgk_pays' => '115.00 TL',
                        'patient_pays' => '0.00 TL',
                        'stock' => 85,
                        'shelf' => 'Raf C-08',
                        'stock_status' => 'Stokta Var',
                        'equivalent_generic' => 'Salbutamol Inhaler'
                    ],
                    [
                        'name' => 'Gynoferon Draje',
                        'barcode' => '8699598765432',
                        'its_status' => 'İTS Onaylı',
                        'box' => 1,
                        'dosage' => '1x1',
                        'price' => '95.00 TL',
                        'sgk_rate' => '%100 Muaf',
                        'sgk_pays' => '95.00 TL',
                        'patient_pays' => '0.00 TL',
                        'stock' => 120,
                        'shelf' => 'Raf A-05',
                        'stock_status' => 'Stokta Var',
                        'equivalent_generic' => 'Ferro Sanol'
                    ]
                ],
                'allergies' => ['Aspirin/NSAİİ'],
                'interactions' => 'Gebelikte Kontrendike Olmayan Alternatif Seçildi',
                'default_step' => 2
            ]
        ];

        // Veritabanındaki E-Reçeteleri Çek ve Dinamik Olarak Eczane Karşılama Listesine Ekle
        try {
            $dbPrescriptions = \App\Modules\Prescription\Models\Prescription::with('items')->latest()->get();
            $patientDataProvider = app(\App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider::class);

            foreach ($dbPrescriptions as $dbP) {
                $patient = $patientDataProvider->getVirtualPatientProfile($dbP->patient_id);
                $code = $dbP->erecepta_no ?: $dbP->prescription_code;

                $drugs = [];
                $totalPrice = 0;
                if ($dbP->items && count($dbP->items) > 0) {
                    foreach ($dbP->items as $item) {
                        $itemPrice = 85.00;
                        $totalPrice += $itemPrice;
                        $drugs[] = [
                            'name' => $item->drug_name,
                            'barcode' => $item->barcode ?: ('8699' . rand(100000000, 999999999)),
                            'its_status' => 'İTS Onaylı',
                            'box' => $item->box_count ?: 1,
                            'dosage' => $item->dosage . ' (' . ($item->frequency ?: '1x1') . ')',
                            'price' => number_format($itemPrice, 2) . ' TL',
                            'sgk_rate' => '%80 SGK',
                            'sgk_pays' => number_format($itemPrice * 0.8, 2) . ' TL',
                            'patient_pays' => number_format($itemPrice * 0.2, 2) . ' TL',
                            'stock' => rand(50, 200),
                            'shelf' => 'Raf A-04',
                            'stock_status' => 'Stokta Var',
                            'equivalent_generic' => 'Eşdeğer Muadil Var'
                        ];
                    }
                } else {
                    $totalPrice = 98.50;
                    $drugs[] = [
                        'name' => 'Candesartan 16mg Tablet',
                        'barcode' => '8699543010012',
                        'its_status' => 'İTS Onaylı',
                        'box' => 1,
                        'dosage' => '1x1 (Sabah)',
                        'price' => '98.50 TL',
                        'sgk_rate' => '%80 SGK',
                        'sgk_pays' => '78.80 TL',
                        'patient_pays' => '19.70 TL',
                        'stock' => 140,
                        'shelf' => 'Raf A-12',
                        'stock_status' => 'Stokta Var',
                        'equivalent_generic' => 'Atacand 16mg / Ayra 16mg'
                    ];
                }

                $copay = $totalPrice * 0.2;
                $sgkPays = $totalPrice * 0.8;
                $isDispensed = session("pharmacy_dispensed_{$code}", false);

                $dynamicPrescription = [
                    'prescription_code' => $code,
                    'order_code' => 'ORD-' . date('Y') . '-' . sprintf('%04d', $dbP->id),
                    'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
                    'national_id' => $patient['national_id'],
                    'birth_date' => $patient['birth_date'] ?? '12.05.1985',
                    'gender' => $patient['gender'] ?? 'Erkek',
                    'patient_type' => 'ayaktan',
                    'patient_type_label' => 'Ayaktan Hasta (Poliklinik)',
                    'clinic' => 'Kardiyoloji Polikliniği',
                    'sgk_type' => 'SGK 4/a (SSK)',
                    'physician' => 'Dr. Hekim (E-Reçete Masası)',
                    'diagnosis' => $dbP->diagnosis_code ?: 'I10 - Essansiyel Hipertansiyon',
                    'date' => $dbP->created_at ? $dbP->created_at->format('d.m.Y H:i') : date('d.m.Y'),
                    'medula_info' => [
                        'provizyon_no' => 'PRV-' . date('Y') . '-' . rand(100000, 999999),
                        'total_price' => number_format($totalPrice, 2) . ' TL',
                        'sgk_coverage' => number_format($sgkPays, 2) . ' TL (%80 SGK)',
                        'patient_copay' => number_format($copay, 2) . ' TL',
                        'copay_status' => $isDispensed ? 'Reçete İlaçları Karşılandı ve Teslim Edildi' : 'Katılım Payı (Eczanede Tahsil Edilecek)'
                    ],
                    'drugs' => $drugs,
                    'allergies' => $patient['allergies'] ?? ['Yok'],
                    'interactions' => 'Güvenli (Etkileşim Yok)',
                    'default_step' => $isDispensed ? 6 : 1
                ];

                $prescriptions[$code] = $dynamicPrescription;
                if ($dbP->prescription_code && $dbP->prescription_code !== $code) {
                    $prescriptions[$dbP->prescription_code] = $dynamicPrescription;
                }
            }
        } catch (\Throwable $e) {
            // Log error silently if DB exception
            logger()->error('Pharmacy DB prescriptions fetch error: ' . $e->getMessage());
        }

        $found = null;
        $searchKey = trim($prescriptionCode);
        $cleanTc = trim($nationalId);
        $cleanName = trim($patientName);

        $hasSearchTerm = !empty($searchKey) || !empty($cleanTc) || !empty($cleanName);

        if (!empty($searchKey) && isset($prescriptions[$searchKey])) {
            $found = $prescriptions[$searchKey];
        } elseif ($hasSearchTerm) {
            foreach ($prescriptions as $p) {
                $codeMatch = !empty($searchKey) && str_contains(mb_strtolower($p['prescription_code'], 'UTF-8'), mb_strtolower($searchKey, 'UTF-8'));
                $tcMatch = !empty($cleanTc) && str_contains($p['national_id'], $cleanTc);
                $nameMatch = !empty($cleanName) && str_contains(mb_strtolower($p['patient_name'], 'UTF-8'), mb_strtolower($cleanName, 'UTF-8'));
                if ($codeMatch || $tcMatch || $nameMatch) {
                    $found = $p;
                    break;
                }
            }
        }

        $workflow = null;
        if ($found) {
            $code = $found['prescription_code'];
            $isDispensed = (bool) session("pharmacy_dispensed_{$code}", false);
            $found['is_dispensed'] = $isDispensed;
            $found['receipt_no'] = session("pharmacy_receipt_{$code}", 'FIS-' . date('Y') . '-889922');
            $found['dispense_date'] = session("pharmacy_dispense_date_{$code}", date('d.m.Y H:i'));

            $activeStep = $step ?: $found['default_step'];
            $workflow = $this->getPharmacyWorkflowStatus($found['order_code'], $activeStep);
        }

        return [
            'prescription' => $found,
            'workflow' => $workflow,
            'has_search_term' => $hasSearchTerm,
            'all_prescriptions' => array_keys($prescriptions)
        ];
    }

    /**
     * Canlı Autocomplete Arama için Eşleşen Yatan Hasta ve Reçeteleri Döner
     */
    public function searchInpatientPrescriptionsMany(?string $query = ''): array
    {
        $query = trim(mb_strtolower($query ?? '', 'UTF-8'));
        if (empty($query)) return [];

        $prescriptions = [
            'EREP-2026-554422' => [
                'prescription_code' => 'EREP-2026-554422',
                'patient_name' => 'Ayşe Demir',
                'national_id' => '98765432109',
                'birth_date' => '24.08.1992',
                'gender' => 'Kadın',
                'clinic' => 'Kadın Doğum Servisi (Oda 304)',
                'physician' => 'Op. Dr. Elif Kaya',
                'diagnosis' => 'O09 - Gebelik Takibi & Astım'
            ],
            'EREP-2026-998811' => [
                'prescription_code' => 'EREP-2026-998811',
                'patient_name' => 'Ahmet Yılmaz',
                'national_id' => '12345678901',
                'birth_date' => '12.05.1985',
                'gender' => 'Erkek',
                'clinic' => 'Kardiyoloji Polikliniği',
                'physician' => 'Dr. Mehmet Öz',
                'diagnosis' => 'I10 - Essansiyel Hipertansiyon'
            ]
        ];

        try {
            $dbPrescriptions = \App\Modules\Prescription\Models\Prescription::with('items')->latest()->get();
            $patientDataProvider = app(\App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider::class);

            foreach ($dbPrescriptions as $dbP) {
                $patient = $patientDataProvider->getVirtualPatientProfile($dbP->patient_id);
                $code = $dbP->erecepta_no ?: $dbP->prescription_code;

                $prescriptions[$code] = [
                    'prescription_code' => $code,
                    'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
                    'national_id' => $patient['national_id'],
                    'birth_date' => $patient['birth_date'] ?? '12.05.1985',
                    'gender' => $patient['gender'] ?? 'Erkek',
                    'clinic' => 'Kardiyoloji Polikliniği (Yeni E-Reçete)',
                    'physician' => 'Dr. Hekim',
                    'diagnosis' => $dbP->diagnosis_code ?: 'I10 - Essansiyel Hipertansiyon'
                ];
            }
        } catch (\Throwable $e) {}

        $matches = [];
        foreach ($prescriptions as $p) {
            $codeMatch = str_contains(mb_strtolower($p['prescription_code'], 'UTF-8'), $query);
            $nameMatch = str_contains(mb_strtolower($p['patient_name'], 'UTF-8'), $query);
            $tcMatch = str_contains($p['national_id'], $query);

            if ($codeMatch || $nameMatch || $tcMatch) {
                $matches[] = $p;
            }
        }

        return $matches;
    }

    /**
     * Eczane İlaç Stok & Depo Yönetimi Listesi
     */
    public function getPharmacyInventory(): array
    {
        return [
            // Kardiyoloji / Tansiyon
            ['id' => 1, 'name' => 'Candesartan 16mg Tablet', 'barcode' => '8699543010012', 'category' => 'Kardiyoloji / Tansiyon', 'stock' => 140, 'min_limit' => 15, 'shelf' => 'Raf A-12', 'price' => '98.50 TL', 'expiry_date' => '15.11.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 2, 'name' => 'Amlodipin 5mg Tablet', 'barcode' => '8699543010029', 'category' => 'Kardiyoloji / Tansiyon', 'stock' => 180, 'min_limit' => 20, 'shelf' => 'Raf A-14', 'price' => '42.00 TL', 'expiry_date' => '10.05.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 3, 'name' => 'Beloc ZOK 50mg Tablet', 'barcode' => '8699543010036', 'category' => 'Kardiyoloji / Beta Blokör', 'stock' => 95, 'min_limit' => 25, 'shelf' => 'Raf A-15', 'price' => '64.50 TL', 'expiry_date' => '18.12.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 4, 'name' => 'Coraspin 100mg Tablet', 'barcode' => '8699500010022', 'category' => 'Kan Sulandırıcı', 'stock' => 250, 'min_limit' => 30, 'shelf' => 'Raf B-04', 'price' => '44.00 TL', 'expiry_date' => '20.08.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 5, 'name' => 'Lasix 40mg Tablet', 'barcode' => '8699543010050', 'category' => 'Kardiyoloji / Diüretik', 'stock' => 60, 'min_limit' => 15, 'shelf' => 'Raf A-18', 'price' => '38.00 TL', 'expiry_date' => '04.09.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],

            // Diyabet ve Endokrin
            ['id' => 6, 'name' => 'Glucophage 1000mg Tablet', 'barcode' => '8699511122334', 'category' => 'Diyabet / Metformin', 'stock' => 110, 'min_limit' => 20, 'shelf' => 'Raf C-08', 'price' => '65.00 TL', 'expiry_date' => '10.04.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 7, 'name' => 'Diamicron MR 60mg Tablet', 'barcode' => '8699511122341', 'category' => 'Diyabet / Sülfonilüre', 'stock' => 85, 'min_limit' => 15, 'shelf' => 'Raf C-10', 'price' => '82.00 TL', 'expiry_date' => '14.07.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 8, 'name' => 'Lantus SoloStar 100 U/ml Enjeksiyon', 'barcode' => '8699511122358', 'category' => 'Diyabet / İnsülin', 'stock' => 40, 'min_limit' => 10, 'shelf' => 'Soğuk Zincir Dolap 1', 'price' => '340.00 TL', 'expiry_date' => '22.02.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 9, 'name' => 'Euthyrox 50mcg Tablet', 'barcode' => '8699511122365', 'category' => 'Endokrin / Tiroid', 'stock' => 120, 'min_limit' => 20, 'shelf' => 'Raf C-15', 'price' => '35.50 TL', 'expiry_date' => '30.10.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 10, 'name' => 'Crestor 10mg Film Tablet', 'barcode' => '8699511122372', 'category' => 'Lipid / Kolesterol', 'stock' => 75, 'min_limit' => 15, 'shelf' => 'Raf C-18', 'price' => '128.00 TL', 'expiry_date' => '11.06.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],

            // Solunum Sistemi
            ['id' => 11, 'name' => 'Ventolin Inhaler 100mcg', 'barcode' => '8699512345678', 'category' => 'Solunum / Astım & KOAH', 'stock' => 14, 'min_limit' => 10, 'shelf' => 'Raf D-02', 'price' => '72.00 TL', 'expiry_date' => '15.08.2026', 'status' => 'expiring', 'status_label' => 'SKT Yakın (15 Gün)'],
            ['id' => 12, 'name' => 'Pulmicort 0.5mg/2ml Nebül', 'barcode' => '8699512345685', 'category' => 'Solunum / Kortikosteroid', 'stock' => 50, 'min_limit' => 15, 'shelf' => 'Raf D-04', 'price' => '145.00 TL', 'expiry_date' => '08.01.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 13, 'name' => 'Singulair 10mg Tablet', 'barcode' => '8699512345692', 'category' => 'Solunum / Alerjik Astım', 'stock' => 65, 'min_limit' => 15, 'shelf' => 'Raf D-06', 'price' => '110.00 TL', 'expiry_date' => '19.03.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 14, 'name' => 'Otrivine %0.1 Burun Spreyi', 'barcode' => '8699512345708', 'category' => 'KBB / Dekonjestan', 'stock' => 90, 'min_limit' => 20, 'shelf' => 'Raf D-10', 'price' => '52.00 TL', 'expiry_date' => '12.11.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],

            // Antibiyotik ve Enfeksiyon
            ['id' => 15, 'name' => 'Augmentin 1000mg Tablet', 'barcode' => '8699544332211', 'category' => 'Antibiyotik / Penam', 'stock' => 5, 'min_limit' => 20, 'shelf' => 'Raf B-10', 'price' => '115.00 TL', 'expiry_date' => '30.01.2027', 'status' => 'critical', 'status_label' => 'Kritik Stok (< 20)'],
            ['id' => 16, 'name' => 'Sefuroksim 500mg Tablet', 'barcode' => '8699544332228', 'category' => 'Antibiyotik / Sefalosporin', 'stock' => 80, 'min_limit' => 15, 'shelf' => 'Raf B-12', 'price' => '135.00 TL', 'expiry_date' => '25.05.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 17, 'name' => 'Cipro 500mg Film Tablet', 'barcode' => '8699544332235', 'category' => 'Antibiyotik / Kinolon', 'stock' => 60, 'min_limit' => 15, 'shelf' => 'Raf B-14', 'price' => '92.00 TL', 'expiry_date' => '14.04.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],

            // Gastrointestinal ve Mide
            ['id' => 18, 'name' => 'Lansor 30mg Kapsül', 'barcode' => '8699577889901', 'category' => 'Gastrointestinal / Mide Koruyucu', 'stock' => 160, 'min_limit' => 25, 'shelf' => 'Raf E-01', 'price' => '78.00 TL', 'expiry_date' => '02.03.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 19, 'name' => 'Nexium 40mg Tablet', 'barcode' => '8699577889918', 'category' => 'Gastrointestinal / PPI', 'stock' => 110, 'min_limit' => 20, 'shelf' => 'Raf E-03', 'price' => '94.00 TL', 'expiry_date' => '17.09.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 20, 'name' => 'Gaviscon Double Action Likit 200ml', 'barcode' => '8699577889925', 'category' => 'Gastrointestinal / Antasit', 'stock' => 70, 'min_limit' => 15, 'shelf' => 'Raf E-05', 'price' => '68.00 TL', 'expiry_date' => '29.11.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 21, 'name' => 'Duspatalin RETARD 200mg Kapsül', 'barcode' => '8699577889932', 'category' => 'Gastrointestinal / İBS Spazmolitik', 'stock' => 45, 'min_limit' => 10, 'shelf' => 'Raf E-08', 'price' => '86.00 TL', 'expiry_date' => '05.06.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],

            // Analjezik, Kas Gevşetici ve Romatoloji
            ['id' => 22, 'name' => 'Parol 500mg Tablet', 'barcode' => '8699500998877', 'category' => 'Analjezik / Ağrı Kesici', 'stock' => 420, 'min_limit' => 50, 'shelf' => 'Raf A-01', 'price' => '28.00 TL', 'expiry_date' => '05.12.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 23, 'name' => 'Apranax Fort 550mg Tablet', 'barcode' => '8699500998884', 'category' => 'NSAİİ / Analjezik', 'stock' => 130, 'min_limit' => 20, 'shelf' => 'Raf F-02', 'price' => '62.00 TL', 'expiry_date' => '18.10.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 24, 'name' => 'Majezik 100mg Film Tablet', 'barcode' => '8699500998891', 'category' => 'NSAİİ / Romatizma', 'stock' => 95, 'min_limit' => 15, 'shelf' => 'Raf F-04', 'price' => '58.00 TL', 'expiry_date' => '21.01.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 25, 'name' => 'Muscoril 4mg Kapsül', 'barcode' => '8699500998907', 'category' => 'Kas Gevşetici', 'stock' => 85, 'min_limit' => 15, 'shelf' => 'Raf F-06', 'price' => '74.00 TL', 'expiry_date' => '09.07.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],

            // Nöroloji ve Psikiyatri
            ['id' => 26, 'name' => 'Cipralex 10mg Film Tablet', 'barcode' => '8699588112233', 'category' => 'Psikiyatri / SSRI Antidepresan', 'stock' => 60, 'min_limit' => 10, 'shelf' => 'Kırmızı/Yeşil Reçete Kasası 1', 'price' => '105.00 TL', 'expiry_date' => '14.03.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 27, 'name' => 'Xanax 0.5mg Tablet', 'barcode' => '8699588112240', 'category' => 'Psikiyatri / Anksiyolitik (Kırmızı Reçete)', 'stock' => 25, 'min_limit' => 5, 'shelf' => 'Kırmızı/Yeşil Reçete Kasası 2', 'price' => '65.00 TL', 'expiry_date' => '11.11.2026', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 28, 'name' => 'Relpax 40mg Film Tablet', 'barcode' => '8699588112257', 'category' => 'Nöroloji / Migren', 'stock' => 35, 'min_limit' => 10, 'shelf' => 'Raf G-02', 'price' => '155.00 TL', 'expiry_date' => '08.08.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],

            // Dermatoloji, Göz ve Diğer
            ['id' => 29, 'name' => 'Allerset 10mg Film Tablet', 'barcode' => '8699599001122', 'category' => 'Dermatoloji / Antihistaminik', 'stock' => 140, 'min_limit' => 20, 'shelf' => 'Raf H-01', 'price' => '48.00 TL', 'expiry_date' => '30.04.2028', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 30, 'name' => 'Stilex Jel 30g', 'barcode' => '8699599001139', 'category' => 'Dermatoloji / Topikal Jel', 'stock' => 55, 'min_limit' => 10, 'shelf' => 'Raf H-03', 'price' => '42.50 TL', 'expiry_date' => '12.12.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 31, 'name' => 'Cosopt Göz Damlası 5ml', 'barcode' => '8699599001146', 'category' => 'Göz / Glokom Damlası', 'stock' => 30, 'min_limit' => 5, 'shelf' => 'Raf H-08', 'price' => '112.00 TL', 'expiry_date' => '01.05.2027', 'status' => 'normal', 'status_label' => 'Stokta Var'],
            ['id' => 32, 'name' => 'Tantum Verde Gargara 150ml', 'barcode' => '8699599001153', 'category' => 'KBB / Ağız Bakım', 'stock' => 80, 'min_limit' => 15, 'shelf' => 'Raf H-10', 'price' => '56.00 TL', 'expiry_date' => '22.09.2028', 'status' => 'normal', 'status_label' => 'Stokta Var']
        ];
    }

    /**
     * İlaç İstemine ve Seçilen Aşamaya Göre 8 Aşamalı Dinamik Eczane Akışı
     */
    public function getPharmacyWorkflowStatus(string $orderCode = 'ORD-2026-8841', int $activeStep = 6): array
    {
        $orders = [
            'ORD-2026-8841' => ['patient' => 'Ahmet Yılmaz', 'drug' => 'Candesartan 16mg Tablet (1x1)', 'default_step' => 6],
            'ORD-2026-8842' => ['patient' => 'Ayşe Demir', 'drug' => 'Ventolin Inhaler (2 Puf)', 'default_step' => 2],
            'ORD-2026-8843' => ['patient' => 'Mehmet Kaya', 'drug' => 'Lasix (Furosemid) 40mg (1x1)', 'default_step' => 7],
            'ORD-2026-8844' => ['patient' => 'Ahmet Yılmaz', 'drug' => 'Parasetamol 500mg Tablet', 'default_step' => 8]
        ];

        $selectedOrder = $orders[$orderCode] ?? $orders['ORD-2026-8841'];
        $currentStep = $activeStep ?: $selectedOrder['default_step'];

        $allStepDefinitions = [
            1 => ['name' => 'Doktor İlaç İstemi (Order)', 'detail' => 'Poliklinik/Servis hekimi tarafından elektronik ilaç istemi oluşturuldu.'],
            2 => ['name' => 'Eczane Reçete/İstem Kontrolü', 'detail' => 'Sorumlu eczacı istemi inceledi ve sistemde doğruladı.'],
            3 => ['name' => 'Depo Stok Kontrolü', 'stock' => 'Mevcut (Raf A-12, 140 Kutu)', 'detail' => 'Eczane ana deposunda stok miktarı teyit edildi.'],
            4 => ['name' => 'Alerji Kontrolü', 'safety' => 'Güvenli (Çakışan Alerji Yok)', 'detail' => 'Hasta alerji veritabanı ile ilaç eşleştirildi.'],
            5 => ['name' => 'İlaç Etkileşim Kontrolü', 'safety' => 'Etkileşim Uyarısı Yok', 'detail' => 'Hastanın aktif kullandığı diğer ilaçlarla etkileşim kontrolü yapıldı.'],
            6 => ['name' => 'İlaç Hazırlama & Dozaj Etiketleme', 'detail' => 'Eczane teknisyeni dozaj etiketini bastı ve ilacı hazırlama kutusuna koydu.'],
            7 => ['name' => 'Servise Teslim (Klinik Kurye)', 'detail' => 'İlaç kurye zimmetine aktarıldı ve klinik servise taşınıyor.'],
            8 => ['name' => 'Hemşire Uygulaması & İlaç Kapatma', 'detail' => 'Servis hemşiresi hastaya ilacı uyguladı ve istem kapanış onayını verdi.']
        ];

        $steps = [];
        for ($i = 1; $i <= 8; $i++) {
            $def = $allStepDefinitions[$i];
            $status = 'pending';
            $time = '-';

            if ($i < $currentStep) {
                $status = 'completed';
                $time = sprintf('%02d:%02d', 10, 10 + ($i * 2));
            } elseif ($i == $currentStep) {
                $status = ($currentStep == 8) ? 'completed' : 'in_progress';
                $time = sprintf('%02d:%02d', 10, 10 + ($i * 2));
            }

            $stepData = [
                'step' => $i,
                'name' => $def['name'],
                'status' => $status,
                'timestamp' => $time,
                'detail' => $def['detail']
            ];

            if (isset($def['stock'])) $stepData['stock_status'] = $def['stock'];
            if (isset($def['safety'])) $stepData['safety_status'] = $def['safety'];

            $steps[] = $stepData;
        }

        return [
            'order_code' => $orderCode,
            'current_step' => $currentStep,
            'patient_name' => $selectedOrder['patient'],
            'ordered_drug' => $selectedOrder['drug'],
            'available_orders' => $orders,
            'steps' => $steps
        ];
    }

    /**
     * Eczacı Gizlilik ve Kısıtlı Erişim Sorgulaması (Şartname Bölüm 24 & 30)
     */
    public function queryByPharmacist(string $prescriptionCode, string $role = 'pharmacist'): array
    {
        return [
            'access_level' => 'restricted_pharmacist',
            'patient_initials' => 'A*** Y*****',
            'allowed_info' => [
                'drug_list' => [
                    'Candesartan 16mg Tablet',
                    'Coraspin 100mg Tablet'
                ]
            ],
            'restricted_fields' => [
                'patient_full_history' => 'Erişim Yetkisi Yok (Eczacı Kısıtlaması)'
            ]
        ];
    }
}
