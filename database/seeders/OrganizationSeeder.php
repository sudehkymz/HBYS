<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Models\Floor;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Organization\Models\Poliklinik;
use App\Modules\Organization\Models\ExaminationRoom;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BİNALAR
        $aBlok = Building::create([
            'name' => 'A Blok (Ana Hizmet Binası)',
            'address' => 'Merkez Kampüs, Atatürk Cad. No:1'
        ]);

        $bBlok = Building::create([
            'name' => 'B Blok (Poliklinikler Binası)',
            'address' => 'Merkez Kampüs, Atatürk Cad. No:2'
        ]);

        $cBlok = Building::create([
            'name' => 'C Blok (Cerrahi & Acil Binası)',
            'address' => 'Merkez Kampüs, Atatürk Cad. No:3'
        ]);

        // 2. KATLAR
        $zeminA = Floor::create(['building_id' => $aBlok->id, 'name' => 'Zemin Kat (A Blok)']);
        $kat1A  = Floor::create(['building_id' => $aBlok->id, 'name' => '1. Kat (A Blok)']);
        $kat2A  = Floor::create(['building_id' => $aBlok->id, 'name' => '2. Kat (A Blok)']);
        $kat3A  = Floor::create(['building_id' => $aBlok->id, 'name' => '3. Kat (A Blok)']);

        $zeminB = Floor::create(['building_id' => $bBlok->id, 'name' => 'Zemin Kat (B Blok)']);
        $kat1B  = Floor::create(['building_id' => $bBlok->id, 'name' => '1. Kat (B Blok)']);
        $kat2B  = Floor::create(['building_id' => $bBlok->id, 'name' => '2. Kat (B Blok)']);
        $kat3B  = Floor::create(['building_id' => $bBlok->id, 'name' => '3. Kat (B Blok)']);

        $zeminC = Floor::create(['building_id' => $cBlok->id, 'name' => 'Zemin Kat (C Blok)']);
        $kat1C  = Floor::create(['building_id' => $cBlok->id, 'name' => '1. Kat (C Blok)']);
        $kat2C  = Floor::create(['building_id' => $cBlok->id, 'name' => '2. Kat (C Blok)']);

        // 3. EKSİKSİZ VE DETAYLI KLİNİKLER, POLİKLİNİKLER VE MUAYENE ODALARI
        $clinicsData = [
            [
                'name' => 'Acil Tıp Kliniği',
                'floor_id' => $zeminC->id,
                'poliklinikler' => [
                    ['name' => 'Acil Servis Polikliniği 1', 'rooms' => ['Triyaj & Acil Oda 1', 'Kırmızı Kod Alanı']],
                    ['name' => 'Acil Servis Polikliniği 2', 'rooms' => ['Triyaj & Acil Oda 2', 'Sarı Kod Müşahade Odası']],
                    ['name' => 'Pediatrik Acil Polikliniği', 'rooms' => ['Çocuk Acil Muayene Odası']],
                ]
            ],
            [
                'name' => 'İç Hastalıkları (Dahiliye) Kliniği',
                'floor_id' => $zeminB->id,
                'poliklinikler' => [
                    ['name' => 'Genel Dahiliye Polikliniği', 'rooms' => ['Poliklinik Oda B-101', 'Poliklinik Oda B-101B']],
                    ['name' => 'Diyabet & Endokrin Polikliniği', 'rooms' => ['Poliklinik Oda B-102', 'Diyabet Eğitim Odası']],
                    ['name' => 'Gastroenteroloji Polikliniği', 'rooms' => ['Poliklinik Oda B-105', 'Endoskopi Muayene Odası']],
                    ['name' => 'Nefroloji & Diyaliz Polikliniği', 'rooms' => ['Poliklinik Oda B-106']],
                ]
            ],
            [
                'name' => 'Kardiyoloji Kliniği',
                'floor_id' => $kat1B->id,
                'poliklinikler' => [
                    ['name' => 'Kardiyoloji Polikliniği 1', 'rooms' => ['Poliklinik Oda B-201', 'EKG Muayene Odası']],
                    ['name' => 'EKO & Efor Polikliniği', 'rooms' => ['EKO Test Odası 1', 'Eforlu EKG Odası']],
                    ['name' => 'Holter & Kalp Pili Polikliniği', 'rooms' => ['Holter Analiz Odası']],
                ]
            ],
            [
                'name' => 'Nöroloji Kliniği',
                'floor_id' => $kat1B->id,
                'poliklinikler' => [
                    ['name' => 'Nöroloji Polikliniği 1', 'rooms' => ['Poliklinik Oda B-203']],
                    ['name' => 'EEG & EMG Laboratuvar Polikliniği', 'rooms' => ['EEG Çekim Odası', 'EMG Muayene Odası']],
                ]
            ],
            [
                'name' => 'Göz Hastalıkları Kliniği',
                'floor_id' => $kat2B->id,
                'poliklinikler' => [
                    ['name' => 'Göz Polikliniği 1', 'rooms' => ['Poliklinik Oda B-301', 'Bio-Mikroskop Odası']],
                    ['name' => 'Göz Polikliniği 2', 'rooms' => ['Poliklinik Oda B-302', 'Göz Tansiyonu Muayene Odası']],
                    ['name' => 'Retina & Lazertedavi Polikliniği', 'rooms' => ['OCT & Retina Muayene Odası']],
                ]
            ],
            [
                'name' => 'Kulak Burun Boğaz (KBB) Kliniği',
                'floor_id' => $kat2B->id,
                'poliklinikler' => [
                    ['name' => 'KBB Polikliniği 1', 'rooms' => ['Poliklinik Oda B-303', 'KBB Endoskopi Odası']],
                    ['name' => 'KBB Polikliniği 2', 'rooms' => ['Poliklinik Oda B-304']],
                    ['name' => 'Odyoloji & İşitme Polikliniği', 'rooms' => ['Sessiz Kabin İşitme Test Odası']],
                ]
            ],
            [
                'name' => 'Ortopedi ve Travmatoloji Kliniği',
                'floor_id' => $kat1C->id,
                'poliklinikler' => [
                    ['name' => 'Ortopedi Polikliniği 1', 'rooms' => ['Poliklinik Oda C-101', 'Alçı & Atel Odası']],
                    ['name' => 'Ortopedi Polikliniği 2', 'rooms' => ['Poliklinik Oda C-102']],
                    ['name' => 'Omurga Cerrahisi Polikliniği', 'rooms' => ['Poliklinik Oda C-102B']],
                ]
            ],
            [
                'name' => 'Genel Cerrahi Kliniği',
                'floor_id' => $kat1C->id,
                'poliklinikler' => [
                    ['name' => 'Genel Cerrahi Polikliniği 1', 'rooms' => ['Poliklinik Oda C-103', 'Küçük Müdahale & Pansuman Odası']],
                    ['name' => 'Genel Cerrahi Polikliniği 2', 'rooms' => ['Poliklinik Oda C-104']],
                    ['name' => 'Meme & Endokrin Cerrahisi Polikliniği', 'rooms' => ['Poliklinik Oda C-104B']],
                ]
            ],
            [
                'name' => 'Kadın Hastalıkları ve Doğum Kliniği',
                'floor_id' => $kat1A->id,
                'poliklinikler' => [
                    ['name' => 'Gebe Takip Polikliniği', 'rooms' => ['Poliklinik Oda A-201', 'USG Muayene Odası']],
                    ['name' => 'Jinekoloji Polikliniği', 'rooms' => ['Poliklinik Oda A-202', 'NST Muayene Odası']],
                    ['name' => 'Perinatoloji Polikliniği', 'rooms' => ['Detaylı Ultrason Odası']],
                ]
            ],
            [
                'name' => 'Çocuk Sağlığı ve Hastalıkları Kliniği',
                'floor_id' => $zeminA->id,
                'poliklinikler' => [
                    ['name' => 'Çocuk Sağlığı Polikliniği 1', 'rooms' => ['Poliklinik Oda A-101', 'Aşı Odası']],
                    ['name' => 'Çocuk Sağlığı Polikliniği 2', 'rooms' => ['Poliklinik Oda A-102', 'Sağlam Çocuk Muayene Odası']],
                    ['name' => 'Pediatrik Kardiyoloji Polikliniği', 'rooms' => ['Çocuk EKO Odası']],
                ]
            ],
            [
                'name' => 'Göğüs Hastalıkları Kliniği',
                'floor_id' => $kat2A->id,
                'poliklinikler' => [
                    ['name' => 'Göğüs Hastalıkları Polikliniği', 'rooms' => ['Poliklinik Oda A-301', 'Solunum Fonksiyon Test (SFT) Odası']],
                    ['name' => 'Alerji & Uyku Polikliniği', 'rooms' => ['Alerji Test Odası']],
                ]
            ],
            [
                'name' => 'Dermatoloji (Cildiye) Kliniği',
                'floor_id' => $zeminB->id,
                'poliklinikler' => [
                    ['name' => 'Dermatoloji Polikliniği 1', 'rooms' => ['Poliklinik Oda B-103', 'Dermoskop Muayene Odası']],
                    ['name' => 'Kozmetik & Kriyoterapi Polikliniği', 'rooms' => ['Kriyoterapi & Lazer Odası']],
                ]
            ],
            [
                'name' => 'Üroloji Kliniği',
                'floor_id' => $kat1C->id,
                'poliklinikler' => [
                    ['name' => 'Üroloji Polikliniği 1', 'rooms' => ['Poliklinik Oda C-105', 'Uroflowmetri Muayene Odası']],
                    ['name' => 'Androloji & Taş Cerrahisi Polikliniği', 'rooms' => ['ESWL & Sistoskopi Odası']],
                ]
            ],
            [
                'name' => 'Fiziksel Tıp ve Rehabilitasyon Kliniği',
                'floor_id' => $zeminA->id,
                'poliklinikler' => [
                    ['name' => 'FTR Polikliniği 1', 'rooms' => ['Poliklinik Oda A-103', 'Elektroterapi Odası']],
                    ['name' => 'Romatoloji Polikliniği', 'rooms' => ['Poliklinik Oda A-103B', 'Egzersiz Salonu']],
                ]
            ],
            [
                'name' => 'Beyin ve Sinir Cerrahisi Kliniği',
                'floor_id' => $kat1C->id,
                'poliklinikler' => [
                    ['name' => 'Nöroşirürji Polikliniği 1', 'rooms' => ['Poliklinik Oda C-106', 'Omurga Muayene Odası']],
                ]
            ],
            [
                'name' => 'Psikiyatri & Ruh Sağlığı Kliniği',
                'floor_id' => $kat3A->id,
                'poliklinikler' => [
                    ['name' => 'Erişkin Psikiyatri Polikliniği 1', 'rooms' => ['Poliklinik Oda A-302']],
                    ['name' => 'Erişkin Psikiyatri Polikliniği 2', 'rooms' => ['Poliklinik Oda A-303', 'Psikoterapi Görüşme Odası']],
                ]
            ],
            [
                'name' => 'Plastik, Rekonstrüktif ve Estetik Cerrahi Kliniği',
                'floor_id' => $kat2C->id,
                'poliklinikler' => [
                    ['name' => 'Plastik Cerrahi Polikliniği', 'rooms' => ['Poliklinik Oda C-201', 'Pansuman & Müdahale Odası']],
                ]
            ],
            [
                'name' => 'Enfeksiyon Hastalıkları Kliniği',
                'floor_id' => $zeminB->id,
                'poliklinikler' => [
                    ['name' => 'Enfeksiyon Hastalıkları Polikliniği', 'rooms' => ['Poliklinik Oda B-104', 'İzolasyon Muayene Odası']],
                ]
            ],
            [
                'name' => 'Kalp ve Damar Cerrahisi (KDC) Kliniği',
                'floor_id' => $kat2C->id,
                'poliklinikler' => [
                    ['name' => 'KDC Polikliniği', 'rooms' => ['Poliklinik Oda C-202', 'Doppler Ultrason Odası']],
                ]
            ],
            [
                'name' => 'Anesteziyoloji ve Reanimasyon Kliniği',
                'floor_id' => $kat1C->id,
                'poliklinikler' => [
                    ['name' => 'Ameliyathane Önü Anestezi Polikliniği', 'rooms' => ['Anestezi Değerlendirme Odası C-001']],
                ]
            ],
        ];

        foreach ($clinicsData as $data) {
            $clinic = Clinic::create([
                'floor_id' => $data['floor_id'],
                'name' => $data['name'],
            ]);

            foreach ($data['poliklinikler'] as $pData) {
                $pol = Poliklinik::create([
                    'clinic_id' => $clinic->id,
                    'name' => $pData['name'],
                ]);

                foreach ($pData['rooms'] as $roomName) {
                    ExaminationRoom::create([
                        'poliklinik_id' => $pol->id,
                        'name' => $roomName,
                        'capacity' => rand(1, 2),
                    ]);
                }
            }
        }
    }
}
