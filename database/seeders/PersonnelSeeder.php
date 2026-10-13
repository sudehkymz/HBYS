<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Modules\Identity\Models\User;
use App\Modules\Personnel\Models\Personnel;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Organization\Models\ExaminationRoom;

class PersonnelSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('1');
        $clinics = Clinic::all();
        $rooms = ExaminationRoom::all();

        // 1. SİSTEM YÖNETİCİSİ VE YÖNETİM HESAPLARI
        User::updateOrCreate(
            ['email' => 'admin@hbys.com'],
            [
                'name' => 'Sistem Yöneticisi',
                'password' => $defaultPassword,
                'phone' => '05000000001',
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'mudur@hbys.com'],
            [
                'name' => 'Hastane Müdürü Kemal Şen',
                'password' => $defaultPassword,
                'phone' => '05550001122',
                'role' => 'manager',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'bashekim@hbys.com'],
            [
                'name' => 'Prof. Dr. Ali Kaya (Başhekim)',
                'password' => $defaultPassword,
                'phone' => '05553334455',
                'role' => 'chief_physician',
                'is_active' => true,
            ]
        );

        // 2. 50 DETAYLI HEKİM LİSTESİ (TÜM POLİKLİNİKLERE DAĞITILMIŞ, ŞİFRE = 1)
        $doctorMasterList = [
            // Acil Tıp
            ['title' => 'Prof. Dr.', 'name' => 'Bülent Yaman', 'specialty' => 'Acil Tıp Uzmanı', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Acil Tıp Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Caner Yıldız', 'specialty' => 'Acil Tıp Uzmanı', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Acil Tıp Kliniği'],
            ['title' => 'Dr.', 'name' => 'Merve intern', 'specialty' => 'Pratisyen Hekim', 'academic_title' => 'İntern Hekim', 'clinic' => 'Acil Tıp Kliniği'],
            ['title' => 'Dr.', 'name' => 'Oğuzhan Kaya', 'specialty' => 'Acil Servis Hekimi', 'academic_title' => 'Asistan Hekim', 'clinic' => 'Acil Tıp Kliniği'],

            // Dahiliye
            ['title' => 'Doç. Dr.', 'name' => 'Zeynep Can', 'specialty' => 'İç Hastalıkları (Dahiliye)', 'academic_title' => 'Doç. Dr.', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Mehmet Öz', 'specialty' => 'Endokrinoloji ve Metabolizma', 'academic_title' => 'Uzman Hekim', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],
            ['title' => 'Dr. Öğr. Üyesi', 'name' => 'Hasan Kale', 'specialty' => 'Diyabet ve Nefroloji', 'academic_title' => 'Dr. Öğr. Üyesi', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Selin Aksoy', 'specialty' => 'Genel Dahiliye Uzmanı', 'academic_title' => 'Uzman Hekim', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],

            // Kardiyoloji
            ['title' => 'Prof. Dr.', 'name' => 'Serdar Aksoy', 'specialty' => 'Kardiyoloji Uzmanı', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Kardiyoloji Kliniği'],
            ['title' => 'Doç. Dr.', 'name' => 'Hakan Çelik', 'specialty' => 'Girişimsel Kardiyoloji', 'academic_title' => 'Doç. Dr.', 'clinic' => 'Kardiyoloji Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Ebru Güneş', 'specialty' => 'Kardiyolog', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Kardiyoloji Kliniği'],

            // Nöroloji
            ['title' => 'Doç. Dr.', 'name' => 'Elif Arslan', 'specialty' => 'Nöroloji Uzmanı', 'academic_title' => 'Doç. Dr.', 'clinic' => 'Nöroloji Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Kemal Vural', 'specialty' => 'Klinik Nörofizyoloji', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Nöroloji Kliniği'],
            ['title' => 'Dr. Öğr. Üyesi', 'name' => 'Deniz Şahin', 'specialty' => 'Epilepsi ve Parkinson', 'academic_title' => 'Dr. Öğr. Üyesi', 'clinic' => 'Nöroloji Kliniği'],

            // Göz Hastalıkları
            ['title' => 'Prof. Dr.', 'name' => 'Ömer Faruk Soylu', 'specialty' => 'Göz Hastalıkları Uzmanı', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Göz Hastalıkları Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Aylin Çetin', 'specialty' => 'Katarakt ve Kornea Cerrahisi', 'academic_title' => 'Op. Dr.', 'clinic' => 'Göz Hastalıkları Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Murat Karaca', 'specialty' => 'Retina Hastalıkları', 'academic_title' => 'Op. Dr.', 'clinic' => 'Göz Hastalıkları Kliniği'],

            // KBB
            ['title' => 'Prof. Dr.', 'name' => 'Mustafa Dağlı', 'specialty' => 'Kulak Burun Boğaz Cerrahisi', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Kulak Burun Boğaz (KBB) Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Sinan Toprak', 'specialty' => 'Rinoplasti ve KBB Uzmanı', 'academic_title' => 'Op. Dr.', 'clinic' => 'Kulak Burun Boğaz (KBB) Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Gizem Yılmaz', 'specialty' => 'Otoloji ve Odyoloji', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Kulak Burun Boğaz (KBB) Kliniği'],

            // Ortopedi
            ['title' => 'Prof. Dr.', 'name' => 'Erhan Tan', 'specialty' => 'Ortopedi ve Travmatoloji', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Ortopedi ve Travmatoloji Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Kürşat Kıran', 'specialty' => 'Artroskopi ve Protez Cerrahisi', 'academic_title' => 'Op. Dr.', 'clinic' => 'Ortopedi ve Travmatoloji Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Alperen Sezer', 'specialty' => 'Omurga Cerrahisi', 'academic_title' => 'Op. Dr.', 'clinic' => 'Ortopedi ve Travmatoloji Kliniği'],

            // Genel Cerrahi
            ['title' => 'Prof. Dr.', 'name' => 'Metin Erdem', 'specialty' => 'Genel Cerrahi Uzmanı', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Genel Cerrahi Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Burak Tunç', 'specialty' => 'Laparoskopik Cerrahi', 'academic_title' => 'Op. Dr.', 'clinic' => 'Genel Cerrahi Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Seda Yener', 'specialty' => 'Meme ve Endokrin Cerrahisi', 'academic_title' => 'Op. Dr.', 'clinic' => 'Genel Cerrahi Kliniği'],

            // Kadın Doğum
            ['title' => 'Prof. Dr.', 'name' => 'Merve Çelik', 'specialty' => 'Kadın Hastalıkları ve Doğum', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Kadın Hastalıkları ve Doğum Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Zeliha Kılıç', 'specialty' => 'Perinatoloji ve Gebe Takibi', 'academic_title' => 'Op. Dr.', 'clinic' => 'Kadın Hastalıkları ve Doğum Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Ceren Polat', 'specialty' => 'Jinekolojik Onkoloji', 'academic_title' => 'Op. Dr.', 'clinic' => 'Kadın Hastalıkları ve Doğum Kliniği'],

            // Çocuk Sağlığı
            ['title' => 'Doç. Dr.', 'name' => 'Selin Saygı', 'specialty' => 'Çocuk Sağlığı ve Hastalıkları', 'academic_title' => 'Doç. Dr.', 'clinic' => 'Çocuk Sağlığı ve Hastalıkları Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Emre Öztürk', 'specialty' => 'Pediatrik Kardiyoloji', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Çocuk Sağlığı ve Hastalıkları Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Tuğba Ergin', 'specialty' => 'Yenidoğan (Neonatoloji)', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Çocuk Sağlığı ve Hastalıkları Kliniği'],

            // Göğüs Hastalıkları
            ['title' => 'Prof. Dr.', 'name' => 'Nihal Aydın', 'specialty' => 'Göğüs Hastalıkları ve KOAH', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Göğüs Hastalıkları Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Tarık Uysal', 'specialty' => 'Alerji ve Göğüs Hastalıkları', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Göğüs Hastalıkları Kliniği'],

            // Dermatoloji
            ['title' => 'Doç. Dr.', 'name' => 'Büşra Demirel', 'specialty' => 'Dermatoloji (Cildiye) Uzmanı', 'academic_title' => 'Doç. Dr.', 'clinic' => 'Dermatoloji (Cildiye) Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Fatih Şen', 'specialty' => 'Kozmetik ve Dermato-onkoloji', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Dermatoloji (Cildiye) Kliniği'],

            // Üroloji
            ['title' => 'Prof. Dr.', 'name' => 'Turgut Kaplan', 'specialty' => 'Üroloji ve Androloji Uzmanı', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Üroloji Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Gökhan Yavuz', 'specialty' => 'Endoüroloji ve Taş Cerrahisi', 'academic_title' => 'Op. Dr.', 'clinic' => 'Üroloji Kliniği'],

            // Fiziksel Tıp
            ['title' => 'Doç. Dr.', 'name' => 'Hande Bilgin', 'specialty' => 'Fiziksel Tıp ve Rehabilitasyon', 'academic_title' => 'Doç. Dr.', 'clinic' => 'Fiziksel Tıp ve Rehabilitasyon Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Cemil Koç', 'specialty' => 'Romatoloji ve FTR', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Fiziksel Tıp ve Rehabilitasyon Kliniği'],

            // Beyin Cerrahi
            ['title' => 'Prof. Dr.', 'name' => 'Yılmaz Güler', 'specialty' => 'Beyin ve Sinir Cerrahisi (Nöroşirürji)', 'academic_title' => 'Prof. Dr.', 'clinic' => 'Beyin ve Sinir Cerrahisi Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Kaan Şimşek', 'specialty' => 'Omurga ve Nöro-onkoloji', 'academic_title' => 'Op. Dr.', 'clinic' => 'Beyin ve Sinir Cerrahisi Kliniği'],

            // Ekstra Branş Hekimleri
            ['title' => 'Uzm. Dr.', 'name' => 'Aslı Aksu', 'specialty' => 'Acil Tıp Uzmanı', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Acil Tıp Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Barış Korkmaz', 'specialty' => 'Dahiliye Uzmanı', 'academic_title' => 'Uzman Hekim', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Ceyda Akın', 'specialty' => 'Kardiyoloji Uzmanı', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Kardiyoloji Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Davut Efe', 'specialty' => 'Genel Cerrahi Uzmanı', 'academic_title' => 'Op. Dr.', 'clinic' => 'Genel Cerrahi Kliniği'],
            ['title' => 'Op. Dr.', 'name' => 'Esma Yalçın', 'specialty' => 'Göz Hastalıkları Uzmanı', 'academic_title' => 'Op. Dr.', 'clinic' => 'Göz Hastalıkları Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Ferhat Keskin', 'specialty' => 'Pediatri Uzmanı', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Çocuk Sağlığı ve Hastalıkları Kliniği'],
            ['title' => 'Uzm. Dr.', 'name' => 'Gülşah Dede', 'specialty' => 'Dermatoloji Uzmanı', 'academic_title' => 'Uzman Hekim', 'clinic' => 'Dermatoloji (Cildiye) Kliniği'],
        ];

        $docIndex = 1;
        foreach ($doctorMasterList as $dData) {
            $email = "doktor{$docIndex}@hbys.com";
            $fullName = "{$dData['title']} {$dData['name']}";
            
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $fullName,
                    'password' => $defaultPassword,
                    'phone' => '0555' . str_pad($docIndex, 7, '0', STR_PAD_LEFT),
                    'role' => 'physician',
                    'is_active' => true,
                ]
            );

            $clinic = $clinics->where('name', $dData['clinic'])->first() ?? $clinics->first();
            $room = $rooms->where('poliklinik.clinic_id', $clinic->id)->first() ?? $rooms->first();

            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $fullName,
                    'email' => $email,
                    'phone' => $user->phone,
                    'specialty' => $dData['specialty'],
                    'academic_title' => $dData['academic_title'],
                    'clinic_id' => $clinic->id ?? null,
                    'examination_room_id' => $room->id ?? null,
                    'working_hours' => '08:30 - 17:00',
                    'appointment_capacity' => 24,
                    'can_operate' => str_contains($dData['title'], 'Op.') || str_contains($dData['title'], 'Prof.'),
                    'can_consult' => true,
                    'can_report' => true,
                    'has_e_signature' => true,
                ]
            );

            $docIndex++;
        }

        // 3. KLİNİK BAKIM & DESTEK PERSONELİ (25 DETAYLI PERSONEL)
        $careStaffList = [
            ['name' => 'Uzm. Hem. Ayşe Yılmaz', 'email' => 'ayse.yilmaz@hbys.com', 'role' => 'Hemşire', 'care_rank' => 'Sağlık Bakım Hizmetleri Müdürü', 'clinic' => 'Acil Tıp Kliniği'],
            ['name' => 'Hem. Fatma Şahin', 'email' => 'fatma.sahin@hbys.com', 'role' => 'Hemşire', 'care_rank' => 'Sorumlu Hemşire', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],
            ['name' => 'Hem. Sevgi Karaca', 'email' => 'sevgi.karaca@hbys.com', 'role' => 'Hemşire', 'care_rank' => 'Yoğun Bakım Hemşiresi', 'clinic' => 'Kardiyoloji Kliniği'],
            ['name' => 'Hem. Zeynep Erdem', 'email' => 'zeynep.erdem@hbys.com', 'role' => 'Hemşire', 'care_rank' => 'Ameliyathane Hemşiresi', 'clinic' => 'Genel Cerrahi Kliniği'],
            ['name' => 'Hem. Melek Şen', 'email' => 'melek.sen@hbys.com', 'role' => 'Hemşire', 'care_rank' => 'Poliklinik Hemşiresi', 'clinic' => 'Nöroloji Kliniği'],
            ['name' => 'Hem. Büşra Yalçın', 'email' => 'busra.yalcin@hbys.com', 'role' => 'Hemşire', 'care_rank' => 'Çocuk Servis Hemşiresi', 'clinic' => 'Çocuk Sağlığı ve Hastalıkları Kliniği'],
            ['name' => 'Hem. Kübra Aksoy', 'email' => 'kubra.aksoy@hbys.com', 'role' => 'Hemşire', 'care_rank' => 'Acil Servis Hemşiresi', 'clinic' => 'Acil Tıp Kliniği'],

            ['name' => 'Ebe Gamze Kılıç', 'email' => 'gamze.kilic@hbys.com', 'role' => 'Ebe', 'care_rank' => 'Kıdemli Ebe', 'clinic' => 'Kadın Hastalıkları ve Doğum Kliniği'],
            ['name' => 'Ebe Hatice Korkmaz', 'email' => 'hatice.korkmaz@hbys.com', 'role' => 'Ebe', 'care_rank' => 'Doğumhane Ebesi', 'clinic' => 'Kadın Hastalıkları ve Doğum Kliniği'],

            ['name' => 'Tekn. Murat Araz', 'email' => 'murat.araz@hbys.com', 'role' => 'Sağlık Teknikeri', 'care_rank' => 'Biyokimya Teknikeri', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],
            ['name' => 'Tekn. Sevgi Yıldız', 'email' => 'sevgi.yildiz@hbys.com', 'role' => 'Radyoloji Teknikeri', 'care_rank' => 'MR & BT Teknikeri', 'clinic' => 'Kardiyoloji Kliniği'],
            ['name' => 'Tekn. Burak Taş', 'email' => 'burak.tas@hbys.com', 'role' => 'Laboratuvar Teknikeri', 'care_rank' => 'Mikrobiyoloji Teknikeri', 'clinic' => 'Acil Tıp Kliniği'],
            ['name' => 'Tekn. Selim Kılınç', 'email' => 'selim.kilinc@hbys.com', 'role' => 'Anestezi Teknikeri', 'care_rank' => 'Anestezi Teknikeri', 'clinic' => 'Genel Cerrahi Kliniği'],

            ['name' => 'Paramedik Oğuzhan Yıldırım', 'email' => 'oguzhan.yildirim@hbys.com', 'role' => 'Paramedik', 'care_rank' => '112 Nakil Paramedik', 'clinic' => 'Acil Tıp Kliniği'],
            ['name' => 'Paramedik Serkan Dede', 'email' => 'serkan.dede@hbys.com', 'role' => 'Paramedik', 'care_rank' => 'Acil Müdahale Paramedik', 'clinic' => 'Acil Tıp Kliniği'],

            ['name' => 'Fizyoterapist Canan Arslan', 'email' => 'canan.arslan@hbys.com', 'role' => 'Fizyoterapist', 'care_rank' => 'Kıdemli Fizyoterapist', 'clinic' => 'Fiziksel Tıp ve Rehabilitasyon Kliniği'],
            ['name' => 'Diyetisyen Ebru Toprak', 'email' => 'ebru.toprak@hbys.com', 'role' => 'Diyetisyen', 'care_rank' => 'Klinik Diyetisyen', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],
            ['name' => 'Eczacı Kalfası Melih Şahin', 'email' => 'melih.sahin@hbys.com', 'role' => 'Eczane Teknikeri', 'care_rank' => 'İlaç Hazırlama Teknikeri', 'clinic' => 'İç Hastalıkları (Dahiliye) Kliniği'],

            ['name' => 'Hasta Bakıcı Hakan Polat', 'email' => 'hakan.polat@hbys.com', 'role' => 'Hasta Bakım Personeli', 'care_rank' => 'Kıdemli Bakım Personeli', 'clinic' => 'Acil Tıp Kliniği'],
            ['name' => 'Hasta Bakıcı Erkan Gürbüz', 'email' => 'erkan.gurbuz@hbys.com', 'role' => 'Hasta Bakım Personeli', 'care_rank' => 'Servis Bakım Personeli', 'clinic' => 'Genel Cerrahi Kliniği'],
            ['name' => 'Hasta Bakıcı Emine Çetin', 'email' => 'emine.cetin@hbys.com', 'role' => 'Hasta Bakım Personeli', 'care_rank' => 'Kadın Servis Bakıcısı', 'clinic' => 'Kadın Hastalıkları ve Doğum Kliniği'],

            ['name' => 'Stajyer Hem. Selin Kurt', 'email' => 'selin.kurt@hbys.com', 'role' => 'Stajyer', 'care_rank' => 'Stajyer Hemşire', 'clinic' => 'Çocuk Sağlığı ve Hastalıkları Kliniği'],
            ['name' => 'Stajyer Tekn. Alperen Varol', 'email' => 'alperen.varol@hbys.com', 'role' => 'Stajyer', 'care_rank' => 'Stajyer Sağlık Teknikeri', 'clinic' => 'Göz Hastalıkları Kliniği'],

            ['name' => 'Odyometrist Gizem Ünal', 'email' => 'gizem.unal@hbys.com', 'role' => 'Odyolog', 'care_rank' => 'İşitme Testi Teknikeri', 'clinic' => 'Kulak Burun Boğaz (KBB) Kliniği'],
            ['name' => 'Optisyen Berkay Yalçın', 'email' => 'berkay.yalcin@hbys.com', 'role' => 'Optisyen', 'care_rank' => 'Göz Test Personeli', 'clinic' => 'Göz Hastalıkları Kliniği'],
        ];

        $pIndex = 1;
        foreach ($careStaffList as $cs) {
            $clinic = $clinics->where('name', $cs['clinic'])->first() ?? $clinics->first();

            // Kullanıcı Hesabı
            User::updateOrCreate(
                ['email' => $cs['email']],
                [
                    'name' => $cs['name'],
                    'password' => $defaultPassword,
                    'phone' => '0555111' . str_pad($pIndex, 4, '0', STR_PAD_LEFT),
                    'role' => str_contains($cs['role'], 'Hemşire') || str_contains($cs['role'], 'Ebe') ? 'nurse' : 'lab_technician',
                    'is_active' => true,
                ]
            );

            // Personel Modeli
            Personnel::updateOrCreate(
                ['email' => $cs['email']],
                [
                    'name' => $cs['name'],
                    'phone' => '0555111' . str_pad($pIndex, 4, '0', STR_PAD_LEFT),
                    'role' => $cs['role'],
                    'academic_title' => null,
                    'care_rank' => $cs['care_rank'],
                    'clinic_id' => $clinic->id ?? null,
                ]
            );

            $pIndex++;
        }
    }
}
