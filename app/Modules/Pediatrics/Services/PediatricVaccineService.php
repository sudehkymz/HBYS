<?php

namespace App\Modules\Pediatrics\Services;

class PediatricVaccineService
{
    /**
     * Get vaccine matrix status for pediatric patient.
     */
    public function getVaccineMatrix(int $ageYears, int $ageMonths = 0): array
    {
        $totalMonths = ($ageYears * 12) + $ageMonths;

        return [
            [
                'name' => 'HepB 1 (Hepatit B - 1. Doz)',
                'period' => 'Doğumda',
                'category' => 'Sağlık Bakanlığı',
                'status' => 'Tamamlandı',
                'status_class' => 'bg-success'
            ],
            [
                'name' => 'BCG (Verem Aşı)',
                'period' => '2. Ay',
                'category' => 'Sağlık Bakanlığı',
                'status' => $totalMonths >= 2 ? 'Tamamlandı' : 'Bekleniyor',
                'status_class' => $totalMonths >= 2 ? 'bg-success' : 'bg-secondary'
            ],
            [
                'name' => 'DaBT-İPA-Hib 1 (Beşli Karma)',
                'period' => '2. Ay',
                'category' => 'Sağlık Bakanlığı',
                'status' => $totalMonths >= 2 ? 'Tamamlandı' : 'Gecikmiş',
                'status_class' => $totalMonths >= 2 ? 'bg-success' : 'bg-danger'
            ],
            [
                'name' => 'KPA 1 (Zatürre / Pnomokok)',
                'period' => '2. Ay',
                'category' => 'Sağlık Bakanlığı',
                'status' => $totalMonths >= 2 ? 'Tamamlandı' : 'Bekleniyor',
                'status_class' => $totalMonths >= 2 ? 'bg-success' : 'bg-secondary'
            ],
            [
                'name' => 'Rotavirüs 1 (İshal Aşısı)',
                'period' => '3. Ay',
                'category' => 'Özel Aşı',
                'status' => $totalMonths >= 3 ? 'Yapıldı (Özel)' : 'Önerildi',
                'status_class' => $totalMonths >= 3 ? 'bg-info' : 'bg-warning text-dark'
            ],
            [
                'name' => 'Meningokok B 1 (Bexsero)',
                'period' => '3-5. Ay',
                'category' => 'Özel Aşı',
                'status' => $totalMonths >= 5 ? 'Yapıldı (Özel)' : 'Önerildi',
                'status_class' => $totalMonths >= 5 ? 'bg-info' : 'bg-warning text-dark'
            ],
            [
                'name' => 'KKK 1 (Kızamık-Kızamıkçık-Kabakulak)',
                'period' => '12. Ay',
                'category' => 'Sağlık Bakanlığı',
                'status' => $totalMonths >= 12 ? 'Tamamlandı' : 'Bekleniyor',
                'status_class' => $totalMonths >= 12 ? 'bg-success' : 'bg-secondary'
            ],
            [
                'name' => 'Suçiçeği 1',
                'period' => '12. Ay',
                'category' => 'Sağlık Bakanlığı',
                'status' => $totalMonths >= 12 ? 'Tamamlandı' : 'Bekleniyor',
                'status_class' => $totalMonths >= 12 ? 'bg-success' : 'bg-secondary'
            ],
            [
                'name' => 'DaBT-İPA 4 (Dörtlü Karma)',
                'period' => '48. Ay (4 Yaş)',
                'category' => 'Sağlık Bakanlığı',
                'status' => $totalMonths >= 48 ? 'Tamamlandı' : 'Gelecek Doz',
                'status_class' => $totalMonths >= 48 ? 'bg-success' : 'bg-secondary'
            ]
        ];
    }
}
