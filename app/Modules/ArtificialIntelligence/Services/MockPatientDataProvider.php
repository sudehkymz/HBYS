<?php

namespace App\Modules\ArtificialIntelligence\Services;

class MockPatientDataProvider
{
    /**
     * Test ve geliştirme sürecinde kullanılacak birden fazla sanal hasta profili.
     */
    public function getVirtualPatientProfile(int $patientId = 1): array
    {
        $patients = [
            1 => [
                'patient_id' => 1,
                'first_name' => 'Ahmet',
                'last_name' => 'Yılmaz',
                'national_id' => '12345678901',
                'birth_date' => '1985-04-12',
                'gender' => 'Erkek',
                'blood_type' => 'A Rh+',
                'allergies' => ['Penasilin', 'Toz/Akar'],
                'chronic_diseases' => ['Essansiyel Hipertansiyon (I10)', 'Tip 2 Diyabet (E11)'],
                'vitals' => [
                    'blood_pressure' => '140/90 mmHg',
                    'pulse' => '82 bpm',
                    'temperature' => '36.6 °C',
                    'oxygen_saturation' => '%98'
                ],
                'recent_encounters' => [
                    [
                        'date' => '2026-07-18',
                        'clinic' => 'Kardiyoloji Polikliniği',
                        'physician' => 'Dr. Mehmet Öz',
                        'complaint' => 'Göğüste sıkışma hissi ve çarpıntı',
                        'diagnosis' => 'I10 - Essansiyel Hipertansiyon',
                        'notes' => 'Tansiyon yüksek seyrediyor. Diyet ve düzenli ilaç takibi önerildi.'
                    ]
                ],
                'lab_results' => [
                    ['test_name' => 'HbA1c', 'value' => '7.8', 'unit' => '%', 'reference' => '4.0 - 6.0', 'status' => 'Yüksek', 'date' => '2026-07-15'],
                    ['test_name' => 'LDL Kolesterol', 'value' => '142', 'unit' => 'mg/dL', 'reference' => '< 100', 'status' => 'Yüksek', 'date' => '2026-07-15']
                ],
                'radiology_results' => [
                    [
                        'id' => 'RAD-2026-901',
                        'type' => 'PA Akciğer Röntgeni (Direkt Grafi)',
                        'modality' => 'CR Röntgen',
                        'date' => '2026-07-18',
                        'is_new' => true,
                        'status' => 'Raporlandı',
                        'radiologist' => 'Uzm. Dr. Burak Radyolog',
                        'report' => 'Kardiyotorasik indeks hafif artmış izlendi. Akciğer parankim alanlarında aktif odak saptanmadı. Sinüsler açık.',
                        'image_badge' => 'PACS Görüntü Var (1 Grafi)'
                    ],
                    [
                        'id' => 'RAD-2025-412',
                        'type' => 'Toraks BT (Bilgisayarlı Tomografi)',
                        'modality' => 'CT Tomografi',
                        'date' => '2025-11-10',
                        'is_new' => false,
                        'status' => 'Eski Arşiv Kaydı',
                        'radiologist' => 'Uzm. Dr. Burak Radyolog',
                        'report' => 'Koroner arterlerde kalsifikasyonlar izlendi. Mediastinal vasküler yapılar tabidir.',
                        'image_badge' => 'PACS Arşiv (8 Kesit)'
                    ]
                ],
                'medication_history' => [
                    ['drug_name' => 'Candesartan 16mg', 'frequency' => '1x1', 'status' => 'Aktif'],
                    ['drug_name' => 'Metformin 850mg', 'frequency' => '2x1', 'status' => 'Aktif']
                ],
                'past_reports' => [
                    [
                        'id' => 901,
                        'report_number' => 'RAP-2026-1044',
                        'date' => '15.01.2026',
                        'report_type' => 'SGK İlaç Kullanım Raporu',
                        'diagnosis' => 'I10 - Essansiyel Hipertansiyon',
                        'rest_days' => 365,
                        'physician' => 'Dr. Mehmet Öz',
                        'clinic' => 'Kardiyoloji Polikliniği',
                        'status' => 'approved',
                        'e_rapor_no' => 'ERAP-2026-104499',
                        'content' => 'Hastanın I10 Essansiyel Hipertansiyon tanısı uyarınca 1 yıl süreyle Candesartan 16mg katılım payından muaf reçete edilmesine yönelik SGK İlaç Kullanım Raporu düzenlenmiştir.'
                    ],
                    [
                        'id' => 902,
                        'report_number' => 'RAP-2025-9942',
                        'date' => '10.05.2025',
                        'report_type' => 'Ayaktan İstirahat Raporu',
                        'diagnosis' => 'I10 - Essansiyel Hipertansiyon',
                        'rest_days' => 3,
                        'physician' => 'Dr. Ayşe Yılmaz',
                        'clinic' => 'Acil Servis',
                        'status' => 'approved',
                        'e_rapor_no' => 'ERAP-2025-994211',
                        'content' => 'Acil servise tansiyon yüksekliği ile başvuran hastaya 3 gün evde ayaktan istirahat raporu verilmiştir.'
                    ]
                ]
            ],
            2 => [
                'patient_id' => 2,
                'first_name' => 'Ayşe',
                'last_name' => 'Demir',
                'national_id' => '98765432109',
                'birth_date' => '1992-08-24',
                'gender' => 'Kadın',
                'blood_type' => '0 Rh+',
                'allergies' => ['Aspirin/NSAİİ', 'Sulfa İlaçları'],
                'chronic_diseases' => ['Alerjik Astım (J45)', 'Gebelik 24. Hafta'],
                'vitals' => [
                    'blood_pressure' => '115/75 mmHg',
                    'pulse' => '78 bpm',
                    'temperature' => '36.8 °C',
                    'oxygen_saturation' => '%96'
                ],
                'recent_encounters' => [
                    [
                        'date' => '2026-07-20',
                        'clinic' => 'Kadın Doğum Polikliniği',
                        'physician' => 'Op. Dr. Elif Kaya',
                        'complaint' => 'Rutin gebelik kontrolü ve hırıltılı solunum',
                        'diagnosis' => 'O09 - Gebelik Muayenesi & Astım',
                        'notes' => 'Fetal gelişim normal. Gebelikte kontrendike ilaçlardan kaçınılmalı.'
                    ]
                ],
                'lab_results' => [
                    ['test_name' => 'Hemoglobin (Hb)', 'value' => '10.5', 'unit' => 'g/dL', 'reference' => '12.0 - 15.5', 'status' => 'Düşük (Hafif Anemi)', 'date' => '2026-07-20'],
                    ['test_name' => 'Açlık Kan Şekeri (OGTT)', 'value' => '92', 'unit' => 'mg/dL', 'reference' => '< 95', 'status' => 'Normal', 'date' => '2026-07-20']
                ],
                'radiology_results' => [
                    [
                        'id' => 'RAD-2026-880',
                        'type' => 'Obstetrik USG (Ultrasonografi)',
                        'modality' => 'US Ultrason',
                        'date' => '2026-07-20',
                        'is_new' => true,
                        'status' => 'Raporlandı',
                        'radiologist' => 'Uzm. Dr. Zeynep Radyoloji',
                        'report' => '24 Hafta tek canlı fetus. Fetal kalp atımı düzenli (+). Amniyon sıvı miktarı yeterli. Plasenta anterior yerleşimli.',
                        'image_badge' => 'PACS Ultrason (4 Görüntü)'
                    ],
                    [
                        'id' => 'RAD-2024-331',
                        'type' => 'PA Akciğer Röntgeni',
                        'modality' => 'CR Röntgen',
                        'date' => '2024-03-12',
                        'is_new' => false,
                        'status' => 'Eski Arşiv Kaydı',
                        'radiologist' => 'Uzm. Dr. Zeynep Radyoloji',
                        'report' => 'Sol diyafram kubbesi tabii. Akciğer damar gölgeleri tabidir.',
                        'image_badge' => 'PACS Arşiv (1 Grafi)'
                    ]
                ],
                'medication_history' => [
                    ['drug_name' => 'Ventolin Inhaler', 'frequency' => 'İhtiyaç Halinde', 'status' => 'Aktif'],
                    ['drug_name' => 'Gynoferon (Demir)', 'frequency' => '1x1', 'status' => 'Aktif']
                ],
                'past_reports' => [
                    [
                        'id' => 903,
                        'report_number' => 'RAP-2026-0512',
                        'date' => '10.02.2026',
                        'report_type' => 'Analık Raporu',
                        'diagnosis' => 'O09 - Gebelik Muayenesi & Takibi',
                        'rest_days' => 56,
                        'physician' => 'Op. Dr. Elif Kaya',
                        'clinic' => 'Kadın Doğum Polikliniği',
                        'status' => 'approved',
                        'e_rapor_no' => 'ERAP-2026-051288',
                        'content' => 'Gebeliğin 32. haftasında olan gebeye mevzuata uygun doğum öncesi 56 günlük analık istirahat raporu tanzim edilmiştir.'
                    ]
                ]
            ],
            3 => [
                'patient_id' => 3,
                'first_name' => 'Mehmet',
                'last_name' => 'Kaya',
                'national_id' => '45678912345',
                'birth_date' => '1958-03-15',
                'gender' => 'Erkek',
                'blood_type' => 'B Rh+',
                'allergies' => ['Yok'],
                'chronic_diseases' => ['KOAH (J44)', 'KRONİK KALP YETMEZLİĞİ (I50)'],
                'vitals' => [
                    'blood_pressure' => '130/85 mmHg',
                    'pulse' => '90 bpm',
                    'temperature' => '36.5 °C',
                    'oxygen_saturation' => '%92 (Düşük)'
                ],
                'recent_encounters' => [
                    [
                        'date' => '2026-07-22',
                        'clinic' => 'Göğüs Hastalıkları Polikliniği',
                        'physician' => 'Prof. Dr. Can Serter',
                        'complaint' => 'Nefes darlığı artışı ve bacaklarda ödem',
                        'diagnosis' => 'J44 - KOAH Alevlenme',
                        'notes' => 'Oksijen satürasyonu %92. Diüretik dozu ayarlandı.'
                    ]
                ],
                'lab_results' => [
                    ['test_name' => 'Kreatinin', 'value' => '1.6', 'unit' => 'mg/dL', 'reference' => '0.7 - 1.2', 'status' => 'Yüksek', 'date' => '2026-07-22'],
                    ['test_name' => 'BNP (B-Tipi Natriüretik Peptit)', 'value' => '450', 'unit' => 'pg/mL', 'reference' => '< 100', 'status' => 'Kritik Yüksek', 'date' => '2026-07-22']
                ],
                'radiology_results' => [
                    [
                        'id' => 'RAD-2026-775',
                        'type' => 'PA Akciğer Röntgeni & Toraks BT',
                        'modality' => 'CR Röntgen / CT',
                        'date' => '2026-07-22',
                        'is_new' => true,
                        'status' => 'Raporlandı',
                        'radiologist' => 'Prof. Dr. Serdar Radyoloji',
                        'report' => 'Bilateral amfizematöz değişiklikler ve peribronşiyal kalınlaşmalar izlendi. KOAH alevlenme ile uyumludur.',
                        'image_badge' => 'PACS Görüntü Var (12 Kesit)'
                    ]
                ],
                'medication_history' => [
                    ['drug_name' => 'Spiriva Inhaler', 'frequency' => '1x1', 'status' => 'Aktif'],
                    ['drug_name' => 'Lasix (Furosemid) 40mg', 'frequency' => '1x1', 'status' => 'Aktif']
                ]
            ],
            4 => [
                'patient_id' => 4,
                'first_name' => 'Ahmet',
                'last_name' => 'Yılmaz',
                'national_id' => '55667788990',
                'birth_date' => '1962-11-24',
                'gender' => 'Erkek',
                'blood_type' => '0 Rh-',
                'allergies' => ['Aspirin'],
                'chronic_diseases' => ['Kritik KOAH (J44)', 'Hipertansiyon'],
                'vitals' => [
                    'blood_pressure' => '135/85 mmHg',
                    'pulse' => '88 bpm',
                    'temperature' => '36.8 °C',
                    'oxygen_saturation' => '%94'
                ],
                'recent_encounters' => [
                    [
                        'date' => '2026-07-10',
                        'clinic' => 'Dahiliye Polikliniği',
                        'physician' => 'Dr. Selin Yılmaz',
                        'complaint' => 'Nefes darlığı ve halsizlik',
                        'diagnosis' => 'J44 - KOAH Alevlenme',
                        'notes' => 'Oksijen satürasyon takibi önerildi.'
                    ]
                ],
                'lab_results' => [],
                'radiology_results' => [],
                'medication_history' => [],
                'past_reports' => []
            ],
            5 => [
                'patient_id' => 5,
                'first_name' => 'Ahmet',
                'last_name' => 'Yılmaz',
                'national_id' => '99887766554',
                'birth_date' => '2001-03-15',
                'gender' => 'Erkek',
                'blood_type' => 'B Rh+',
                'allergies' => ['Yok'],
                'chronic_diseases' => ['Kayıtlı Kronik Tanı Yok'],
                'vitals' => [
                    'blood_pressure' => '120/80 mmHg',
                    'pulse' => '72 bpm',
                    'temperature' => '36.5 °C',
                    'oxygen_saturation' => '%99'
                ],
                'recent_encounters' => [
                    [
                        'date' => '2026-07-22',
                        'clinic' => 'Ortopedi Polikliniği',
                        'physician' => 'Op. Dr. Hakan Öztürk',
                        'complaint' => 'Sağ ayak bileğinde burkulma',
                        'diagnosis' => 'S93 - Ayak Bileği Burkulması',
                        'notes' => 'Bandaj ve istirahat tavsiye edildi.'
                    ]
                ],
                'lab_results' => [],
                'radiology_results' => [],
                'medication_history' => [],
                'past_reports' => []
            ]
        ];

        $patient = $patients[$patientId] ?? $patients[1];
        $this->mergeLiveSessionData($patient, $patient['patient_id']);
        return $patient;
    }


    /**
     * Tüm sanal hasta profillerini döner.
     */
    public function getAllVirtualPatients(): array
    {
        return [
            1 => $this->getVirtualPatientProfile(1),
            2 => $this->getVirtualPatientProfile(2),
            3 => $this->getVirtualPatientProfile(3),
            4 => $this->getVirtualPatientProfile(4),
            5 => $this->getVirtualPatientProfile(5),
        ];
    }

    /**
     * İsim, Soyisim veya T.C. Kimlik No ile birden fazla eşleşen hastayı döner (Autocomplete için).
     */
    public function searchPatientProfilesMany(string $query): array
    {
        $query = trim(mb_strtolower($query));
        if (empty($query)) return [];

        $results = [];
        foreach ($this->getAllVirtualPatients() as $p) {
            $fullName = mb_strtolower($p['first_name'] . ' ' . $p['last_name']);
            $natId = $p['national_id'];
            if (
                str_contains($fullName, $query) ||
                str_contains(mb_strtolower($p['first_name']), $query) ||
                str_contains(mb_strtolower($p['last_name']), $query) ||
                str_contains($natId, $query)
            ) {
                $results[] = $p;
            }
        }

        // DB Patient sorgusu
        try {
            $dbPatients = \App\Modules\Patient\Models\Patient::where('national_id', 'like', "%{$query}%")
                ->orWhere('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->get();

            foreach ($dbPatients as $dbPatient) {
                $results[] = [
                    'patient_id' => $dbPatient->id,
                    'first_name' => $dbPatient->first_name,
                    'last_name' => $dbPatient->last_name,
                    'national_id' => $dbPatient->national_id,
                    'birth_date' => $dbPatient->birth_date ?? '1990-01-01',
                    'gender' => $dbPatient->gender ?? 'Erkek',
                    'blood_type' => $dbPatient->blood_type ?? 'A Rh+',
                    'allergies' => ['Yok'],
                    'chronic_diseases' => ['Kayıtlı Kronik Tanı Yok'],
                    'vitals' => [
                        'blood_pressure' => '120/80 mmHg',
                        'pulse' => '75 bpm',
                        'temperature' => '36.5 °C',
                        'oxygen_saturation' => '%98'
                    ],
                    'recent_encounters' => [
                        [
                            'date' => date('Y-m-d'),
                            'clinic' => 'Genel Poliklinik',
                            'physician' => auth()->user()->name ?? 'Dr. Hekim',
                            'complaint' => 'Genel Sağlık Kontrolü',
                            'diagnosis' => 'Z00 - Genel Muayene',
                            'notes' => 'Sistemdeki veritabanı hasta kaydı.'
                        ]
                    ],
                    'lab_results' => [],
                    'radiology_results' => [],
                    'medication_history' => [],
                    'past_reports' => []
                ];
            }
        } catch (\Throwable $e) {}

        return $results;
    }

    /**
     * İsim, Soyisim veya T.C. Kimlik No ile hasta arar.
     */
    public function searchPatientProfile(string $query): ?array
    {
        $query = trim(mb_strtolower($query));
        if (empty($query)) return null;

        foreach ($this->getAllVirtualPatients() as $p) {
            $fullName = mb_strtolower($p['first_name'] . ' ' . $p['last_name']);
            $natId = $p['national_id'];
            if (
                str_contains($fullName, $query) ||
                str_contains(mb_strtolower($p['first_name']), $query) ||
                str_contains(mb_strtolower($p['last_name']), $query) ||
                str_contains($natId, $query)
            ) {
                return $p;
            }
        }

        // DB Patient sorgusu
        try {
            $dbPatient = \App\Modules\Patient\Models\Patient::where('national_id', 'like', "%{$query}%")
                ->orWhere('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->first();

            if ($dbPatient) {
                return [
                    'patient_id' => $dbPatient->id,
                    'first_name' => $dbPatient->first_name,
                    'last_name' => $dbPatient->last_name,
                    'national_id' => $dbPatient->national_id,
                    'birth_date' => $dbPatient->birth_date ?? '1990-01-01',
                    'gender' => $dbPatient->gender ?? 'Erkek',
                    'blood_type' => $dbPatient->blood_type ?? 'A Rh+',
                    'allergies' => ['Yok'],
                    'chronic_diseases' => ['Kayıtlı Kronik Tanı Yok'],
                    'vitals' => [
                        'blood_pressure' => '120/80 mmHg',
                        'pulse' => '75 bpm',
                        'temperature' => '36.5 °C',
                        'oxygen_saturation' => '%98'
                    ],
                    'recent_encounters' => [
                        [
                            'date' => date('Y-m-d'),
                            'clinic' => 'Genel Poliklinik',
                            'physician' => auth()->user()->name ?? 'Dr. Hekim',
                            'complaint' => 'Genel Sağlık Kontrolü',
                            'diagnosis' => 'Z00 - Genel Muayene',
                            'notes' => 'Sistemdeki veritabanı hasta kaydı.'
                        ]
                    ],
                    'lab_results' => [],
                    'radiology_results' => [],
                    'medication_history' => [],
                    'past_reports' => []
                ];
                $this->mergeLiveSessionData($p, $p['patient_id']);
                return $p;
            }
        } catch (\Throwable $e) {}

        return null;
    }

    /**
     * Diğer modüllerde (Laboratuvar, Patoloji, Ameliyathane, Radyoloji) üretilen canlı istem ve raporları hasta profiline birleştirir.
     */
    public function mergeLiveSessionData(array &$patient, int $patientId): void
    {
        $admissionId = 500 + $patientId;

        // 1. Laboratuvar & Radyoloji Sonuçları (Diagnostics Modülü)
        $diagOrders = session('diagnostics_orders', []);
        $diagResults = session('diagnostics_results', []);

        if (isset($diagOrders[$admissionId])) {
            foreach ($diagOrders[$admissionId] as $order) {
                $orderId = $order['id'];
                $result = $diagResults[$admissionId][$orderId] ?? null;

                if ($order['type'] === 'Laboratuvar' && $result) {
                    $exists = false;
                    if (isset($patient['lab_results'])) {
                        foreach ($patient['lab_results'] as &$lr) {
                            if ($lr['test_name'] === $order['name']) {
                                $lr['value'] = $result['result_summary'];
                                $lr['date'] = $result['completed_at'] ?? $order['ordered_at'];
                                $exists = true;
                                break;
                            }
                        }
                    } else {
                        $patient['lab_results'] = [];
                    }
                    if (!$exists) {
                        $patient['lab_results'][] = [
                            'test_name' => $order['name'],
                            'value' => $result['result_summary'],
                            'unit' => 'Rapor',
                            'reference' => 'Klinik Referans',
                            'status' => 'Sonuçlandı',
                            'date' => $result['completed_at'] ?? $order['ordered_at']
                        ];
                    }
                } elseif ($order['type'] === 'Radyoloji') {
                    $exists = false;
                    if (isset($patient['radiology_results'])) {
                        foreach ($patient['radiology_results'] as &$rr) {
                            if ($rr['type'] === $order['name']) {
                                if ($result) {
                                    $rr['report'] = $result['result_summary'];
                                    $rr['status'] = 'Raporlandı';
                                    $rr['radiologist'] = $result['technician'] ?? 'Radyoloji Uzmanı';
                                }
                                $exists = true;
                                break;
                            }
                        }
                    } else {
                        $patient['radiology_results'] = [];
                    }
                    if (!$exists) {
                        $patient['radiology_results'][] = [
                            'id' => 'RAD-2026-' . $orderId,
                            'type' => $order['name'],
                            'modality' => 'Radyolojik Görüntüleme',
                            'date' => $result['completed_at'] ?? $order['ordered_at'],
                            'is_new' => true,
                            'status' => $result ? 'Raporlandı' : 'İstem Yapıldı',
                            'radiologist' => $result['technician'] ?? 'Radyoloji Uzmanı',
                            'report' => $result['result_summary'] ?? 'Radyoloji çekim / raporlama aşamasında.',
                            'image_badge' => 'PACS Görüntüleme Aktif'
                        ];
                    }
                }
            }
        }

        // 2. Patoloji Raporları (Pathology Modülü)
        $pathOrders = session('pathology_orders', []);
        $pathResults = session('pathology_results', []);

        if (isset($pathOrders[$admissionId])) {
            foreach ($pathOrders[$admissionId] as $porder) {
                $porderId = $porder['id'];
                $presult = $pathResults[$admissionId][$porderId] ?? null;

                $reportTitle = 'Patoloji Raporu - ' . $porder['name'];
                $exists = false;
                if (isset($patient['past_reports'])) {
                    foreach ($patient['past_reports'] as &$pr) {
                        if ($pr['report_type'] === $reportTitle) {
                            if ($presult) {
                                $pr['content'] = $presult['result_summary'];
                                $pr['physician'] = $presult['pathologist'] ?? 'Uzm. Dr. Melis Kaya';
                            }
                            $exists = true;
                            break;
                        }
                    }
                } else {
                    $patient['past_reports'] = [];
                }
                if (!$exists && $presult) {
                    array_unshift($patient['past_reports'], [
                        'id' => 8000 + $porderId,
                        'report_number' => 'PAT-2026-' . $porderId,
                        'date' => $presult['completed_at'] ?? $porder['ordered_at'],
                        'report_type' => $reportTitle,
                        'diagnosis' => 'Histopatolojik Tetkik Değerlendirmesi',
                        'rest_days' => 0,
                        'physician' => $presult['pathologist'] ?? 'Uzm. Dr. Melis Kaya',
                        'clinic' => 'Patoloji Laboratuvarı',
                        'status' => 'approved',
                        'e_rapor_no' => 'EPAT-2026-' . $porderId,
                        'content' => $presult['result_summary']
                    ]);
                }
            }
        }

        // 3. Ameliyat & Anestezi Raporları (Surgery Modülü)
        $surgSchedules = session('surgery_schedules', []);
        $surgReports = session('surgery_reports', []);

        if (isset($surgSchedules[$admissionId])) {
            $schedule = $surgSchedules[$admissionId];
            $sreport = $surgReports[$admissionId] ?? null;

            if ($sreport) {
                $reportTitle = 'Ameliyat & Anestezi Raporu - ' . ($schedule['operation'] ?? 'Cerrahi Operasyon');
                $exists = false;
                if (isset($patient['past_reports'])) {
                    foreach ($patient['past_reports'] as &$pr) {
                        if ($pr['report_type'] === $reportTitle) {
                            $pr['content'] = "AMELİYAT BULGULARI:\n" . $sreport['findings'] . "\n\nKOMPLİKASYONLAR:\n" . $sreport['complications'] . "\n\nPOST-OP İZLEM VE BAKIM:\n" . $sreport['postop_care'];
                            $exists = true;
                            break;
                        }
                    }
                } else {
                    $patient['past_reports'] = [];
                }
                if (!$exists) {
                    array_unshift($patient['past_reports'], [
                        'id' => 9000 + $admissionId,
                        'report_number' => 'AMEL-2026-' . $admissionId,
                        'date' => $sreport['completed_at'] ?? ($schedule['date'] ?? date('d.m.Y')),
                        'report_type' => $reportTitle,
                        'diagnosis' => $schedule['operation'] ?? 'Cerrahi Operasyon',
                        'rest_days' => 15,
                        'physician' => $schedule['surgeon'] ?? 'Op. Dr. Cerrahi Ekip',
                        'clinic' => 'Ameliyathane & Anestezi Servisi',
                        'status' => 'approved',
                        'e_rapor_no' => 'ESURG-2026-' . $admissionId,
                        'content' => "AMELİYAT BULGULARI:\n" . $sreport['findings'] . "\n\nKOMPLİKASYONLAR:\n" . $sreport['complications'] . "\n\nPOST-OP İZLEM VE BAKIM:\n" . $sreport['postop_care']
                    ]);
                }
            }
        }

        // 4. Veritabanında Oluşturulan Reçeteler (Prescription Modülü)
        try {
            if (class_exists(\App\Modules\Prescription\Models\Prescription::class)) {
                $dbPrescriptions = \App\Modules\Prescription\Models\Prescription::where('patient_id', $patientId)
                    ->with('items')
                    ->latest()
                    ->get();

                foreach ($dbPrescriptions as $dbPresc) {
                    foreach ($dbPresc->items as $item) {
                        $exists = false;
                        if (isset($patient['medication_history'])) {
                            foreach ($patient['medication_history'] as &$med) {
                                if ($med['drug_name'] === $item->drug_name) {
                                    $med['frequency'] = $item->dosage;
                                    $med['status'] = 'Aktif';
                                    $exists = true;
                                    break;
                                }
                            }
                        } else {
                            $patient['medication_history'] = [];
                        }
                        if (!$exists) {
                            array_unshift($patient['medication_history'], [
                                'drug_name' => $item->drug_name,
                                'frequency' => $item->dosage . ' (' . $item->box_count . ' Kutu)',
                                'status' => 'Aktif',
                                'erecepta_no' => $dbPresc->erecepta_no ?? $dbPresc->prescription_code
                            ]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Silently ignore if DB table is unavailable in scratch tests
        }
    }
}

