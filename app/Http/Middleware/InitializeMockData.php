<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InitializeMockData
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasSession()) {
            if (!session()->has('admissions')) {
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
                        'admission_date' => '26.07.2026 09:00',
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
                        'admission_date' => '28.07.2026 10:00',
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
                        'admission_date' => '27.07.2026 11:00',
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
                        'admission_date' => '29.07.2026 15:00',
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
                        'admission_date' => '28.07.2026 14:00',
                        'companion' => 'Eşi (Murat Demir)'
                    ]
                ];
                session(['admissions' => $defaultAdmissions]);
            }

            if (!session()->has('beds')) {
                $services = ['Genel Cerrahi', 'Dahiliye', 'Kadın Doğum', 'Çocuk Sağlığı'];
                $defaultBeds = [];
                $bedId = 1;
                
                foreach ($services as $serviceIndex => $service) {
                    $baseRoom = ($serviceIndex + 1) * 100;
                    for ($i = 1; $i <= 25; $i++) {
                        $roomOffset = ceil($i / 2);
                        $roomNum = $baseRoom + $roomOffset;
                        $bedLetter = ($i % 2 === 1) ? 'A' : 'B';
                        $bedName = "{$roomNum}-{$bedLetter}";
                        
                        $status = 'bos';
                        $statusTr = 'Boş';
                        $patientName = null;
                        
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
                session(['beds' => $defaultBeds]);
            }
        }

        return $next($request);
    }
}
