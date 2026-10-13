<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Models\EpisodeOfCare;
use App\Modules\Patient\Models\Encounter;
use App\Modules\Emergency\Models\EmergencyTriage;
use App\Modules\Referral\Models\Referral;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Identity\Models\User;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();
        $clinics = Clinic::all();
        $user = User::first();
        $userId = $user ? $user->id : 1;

        $firstNamesMale = [
            'Ahmet', 'Mehmet', 'Mustafa', 'Ali', 'Hüseyin', 'Hasan', 'İbrahim', 'Ismail', 'Osman', 'Yusuf',
            'Murat', 'Ömer', 'Ramazan', 'Halil', 'Süleyman', 'Kadir', 'Emre', 'Burak', 'Serkan', 'Hakan',
            'Orhan', 'Metin', 'Bülent', 'Erhan', 'Volkan', 'Selim', 'Turgut', 'Gökhan', 'Onur', 'Fatih',
            'Enes', 'Kerem', 'Eren', 'Kaan', 'Arda', 'Batuhan', 'Uğur', 'Sinan', 'Yasin', 'Zafer',
            'Alper', 'Barış', 'Cem', 'Deniz', 'Efe', 'Furkan', 'Görkem', 'Harun', 'İlker', 'Koray'
        ];

        $firstNamesFemale = [
            'Ayşe', 'Zeynep', 'Fatma', 'Emine', 'Hatice', 'Elif', 'Merve', 'Büşra', 'Esra', 'Zeliha',
            'Seda', 'Gamze', 'Tuğba', 'Kübra', 'Selin', 'Ebru', 'Gizem', 'Derya', 'Sibel', 'Filiz',
            'Sevgi', 'Gülşah', 'Zehra', 'Nuray', 'Aslı', 'Ceren', 'Hande', 'Dilek', 'Pınar', 'Yasemin',
            'Aylin', 'Sultan', 'Songül', 'Rukiye', 'Rabia', 'Havva', 'Kader', 'Nermin', 'Özlem', 'Semra',
            'Şerife', 'Tülay', 'Ülkü', 'Yıldız', 'Bahar', 'Beste', 'Damla', 'Ece', 'Hazal', 'İrem'
        ];

        $lastNames = [
            'Yılmaz', 'Kaya', 'Demir', 'Şahin', 'Çelik', 'Yıldız', 'Yıldırım', 'Öztürk', 'Aydın', 'Özdemir',
            'Arslan', 'Doğan', 'Kılıç', 'Aslan', 'Çetin', 'Kara', 'Koç', 'Kurt', 'Özcan', 'Şimşek',
            'Polat', 'Korkmaz', 'Zengin', 'Güler', 'Yalçın', 'Güneş', 'Yener', 'Koral', 'Ergin', 'Vural',
            'Aksoy', 'Uysal', 'Şen', 'Taş', 'Soylu', 'Bulut', 'Turan', 'Gök', 'Acar', 'Erdoğan',
            'Albayrak', 'Bozkurt', 'Can', 'Dede', 'Eren', 'Fırat', 'Gürbüz', 'Işık', 'Kabak', 'Levent'
        ];

        $bloodTypes = ['A Rh+', 'A Rh-', 'B Rh+', 'B Rh-', 'AB Rh+', 'AB Rh-', '0 Rh+', '0 Rh-'];
        $chronicList = ['Hipertansiyon', 'Tip 2 Diyabet', 'KOAH', 'Astım', 'Aritmi', 'Tiroid Yetmezliği', 'Migren', 'Romatizma', 'Yok'];
        $allergyList = ['Penisilin', 'Toz Akarları', 'Arı Zehri', 'Aspirin', 'Sulfa İlaçları', 'Polen', 'Lateks', 'Yok'];
        $cities = ['İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya', 'Adana', 'Konya', 'Gaziantep', 'Kocaeli', 'Kayseri'];

        $patients = [];

        // 100 HASTA OLUŞTURMA
        for ($i = 1; $i <= 100; $i++) {
            $isMale = $i % 2 === 1;
            $firstName = $isMale 
                ? $firstNamesMale[($i - 1) % count($firstNamesMale)] 
                : $firstNamesFemale[($i - 1) % count($firstNamesFemale)];
            $lastName = $lastNames[($i - 1) % count($lastNames)];

            $tckn = (string)(10000000000 + ($i * 7392817) % 89999999999);
            $birthYear = rand(1950, 2018);
            $birthMonth = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $birthDay = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
            $birthDate = "{$birthYear}-{$birthMonth}-{$birthDay}";

            $phone = '053' . rand(1, 9) . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $city = $cities[$i % count($cities)];
            $address = "Merkez Mah. Atatürk Cad. No: {$i} {$city}";
            $blood = $bloodTypes[$i % count($bloodTypes)];
            $chronic = $chronicList[$i % count($chronicList)];
            $allergy = $allergyList[$i % count($allergyList)];
            $emergencyContact = "Yakup {$lastName} (Yakını) - 0542" . rand(1000000, 9999999);

            $patient = Patient::create([
                'national_id' => $tckn,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'birth_date' => $birthDate,
                'gender' => $isMale ? 'male' : 'female',
                'phone' => $phone,
                'address' => $address,
                'blood_type' => $blood,
                'allergies' => $allergy,
                'chronic_conditions' => $chronic,
                'emergency_contact' => $emergencyContact,
            ]);

            $patients[] = $patient;
        }

        // KANLI KANLI TEST VERİLERİ (KLİNİK, ACİL, SEVK VE RANDEVULAR)
        // A) 15 Adet Muayene & Encounter Kaydı
        foreach (array_slice($patients, 0, 15) as $idx => $p) {
            $doc = $doctors->random();
            $ep = EpisodeOfCare::create([
                'patient_id' => $p->id,
                'title' => "{$p->chronic_conditions} ve Rutin Muayene Takibi",
                'status' => 'active',
                'start_date' => now()->subDays(rand(1, 30)),
            ]);

            Encounter::create([
                'patient_id' => $p->id,
                'episode_of_care_id' => $ep->id,
                'physician_id' => $doc->user_id ?? $userId,
                'type' => 'outpatient',
                'status' => $idx % 2 === 0 ? 'completed' : 'in_progress',
                'encounter_date' => now()->subDays(rand(0, 5)),
            ]);
        }

        // B) 12 Adet Canlı Acil Triyaj Kaydı (Kırmızı, Sarı, Yeşil)
        $triageCategories = ['red', 'yellow', 'green'];
        $triageComplaints = [
            'red' => 'Şiddetli Göğüs Ağrısı ve Nefes Darlığı (MI Şüphesi)',
            'yellow' => 'Karın Bölgesinde Akut Ağrı ve Bulantı',
            'green' => 'Boğaz Ağrısı, Hafif Ateş ve Öksürük',
        ];

        foreach (array_slice($patients, 15, 12) as $idx => $p) {
            $cat = $triageCategories[$idx % 3];
            $doc = $doctors->random();

            EmergencyTriage::create([
                'patient_id' => $p->id,
                'triage_category' => $cat,
                'chief_complaint' => $triageComplaints[$cat],
                'vital_signs' => [
                    'blood_pressure' => ($cat === 'red' ? '170/110' : '120/80'),
                    'pulse' => ($cat === 'red' ? '115' : '78'),
                    'fever' => ($cat === 'green' ? '37.8' : '36.6'),
                    'spo2' => ($cat === 'red' ? '92' : '98'),
                ],
                'assigned_doctor_id' => $doc->id,
                'status' => $idx % 4 === 0 ? 'in_treatment' : 'waiting',
            ]);
        }

        // C) 10 Adet Sevk & Transfer Kaydı (İç ve Dış Sevk)
        foreach (array_slice($patients, 27, 10) as $idx => $p) {
            $isInternal = $idx % 2 === 0;
            $refDoc = $doctors->random();
            $targetClinic = $clinics->random();

            Referral::create([
                'referral_code' => 'SVK-' . date('Y') . '-' . rand(10000, 99999),
                'patient_id' => $p->id,
                'referring_doctor_id' => $refDoc->id,
                'referral_type' => $isInternal ? 'internal' : 'external',
                'target_clinic_id' => $isInternal ? $targetClinic->id : null,
                'target_hospital' => $isInternal ? null : 'Şehir Hastanesi İleri Kardiyoloji Merkezi',
                'reason' => $isInternal ? 'İleri Tetkik ve Konsültasyon Talebi' : '3. Basamak Yoğun Bakım Nakli',
                'transport_type' => $isInternal ? 'self' : 'ambulance',
                'status' => $idx % 3 === 0 ? 'approved' : 'pending',
            ]);
        }

        // D) 25 Adet Poliklinik Randevusu
        $timeSlots = ['08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00'];
        foreach (array_slice($patients, 37, 25) as $idx => $p) {
            $doc = $doctors->random();
            $slot = $timeSlots[$idx % count($timeSlots)];
            $date = now()->addDays(floor($idx / count($timeSlots)))->format('Y-m-d');

            try {
                Appointment::create([
                    'patient_id' => $p->id,
                    'doctor_id' => $doc->id,
                    'clinic_id' => $doc->clinic_id,
                    'appointment_date' => $date,
                    'appointment_time' => $slot,
                    'status' => $idx % 3 === 0 ? 'completed' : 'pending',
                    'notes' => 'Rutin Poliklinik Muayene Randevusu',
                ]);
            } catch (\Throwable $e) {
                // Ignore rare slot collision during random seeding
            }
        }
    }
}
