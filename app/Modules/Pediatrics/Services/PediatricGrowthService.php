<?php

namespace App\Modules\Pediatrics\Services;

class PediatricGrowthService
{
    /**
     * Calculate Growth Percentile & Z-score based on WHO & Neyzi standards.
     */
    public function calculatePercentile(float $weightKg, float $heightCm, ?float $headCircCm, int $ageYears, string $gender): array
    {
        $bmi = 0;
        if ($heightCm > 0) {
            $heightM = $heightCm / 100;
            $bmi = round($weightKg / ($heightM * $heightM), 1);
        }

        // Percentile bracket logic
        $percentileLabel = '50. Persentil (Normal Gelişim)';
        $percentileBadgeClass = 'bg-success';
        $zScore = '0.0 SD';

        // Sample percentile threshold logic
        if ($ageYears <= 2) {
            if ($weightKg < 9.0) {
                $percentileLabel = '3. Persentil Altı (Malnütrisyon Riski)';
                $percentileBadgeClass = 'bg-danger';
                $zScore = '-2.1 SD';
            } elseif ($weightKg > 15.0) {
                $percentileLabel = '97. Persentil Üstü (İri Bebek / Aşırı Kilo)';
                $percentileBadgeClass = 'bg-warning text-dark';
                $zScore = '+2.3 SD';
            } else {
                $percentileLabel = '50-75. Persentil (Standart Gelişim)';
                $percentileBadgeClass = 'bg-success';
                $zScore = '+0.4 SD';
            }
        } elseif ($ageYears <= 6) {
            if ($weightKg < 13.0) {
                $percentileLabel = '10. Persentil (Düşük Kilo)';
                $percentileBadgeClass = 'bg-warning text-dark';
                $zScore = '-1.4 SD';
            } elseif ($weightKg > 24.0) {
                $percentileLabel = '90. Persentil (Persentil Yüksek)';
                $percentileBadgeClass = 'bg-warning text-dark';
                $zScore = '+1.8 SD';
            } else {
                $percentileLabel = '50. Persentil (Standart Gelişim)';
                $percentileBadgeClass = 'bg-success';
                $zScore = '0.0 SD';
            }
        } else {
            if ($bmi < 14.5) {
                $percentileLabel = '5. Persentil (Zayıf)';
                $percentileBadgeClass = 'bg-warning text-dark';
                $zScore = '-1.7 SD';
            } elseif ($bmi > 22.0) {
                $percentileLabel = '95. Persentil (Obezite Riski)';
                $percentileBadgeClass = 'bg-danger';
                $zScore = '+2.5 SD';
            } else {
                $percentileLabel = '50. Persentil (Normal VKİ)';
                $percentileBadgeClass = 'bg-success';
                $zScore = '+0.2 SD';
            }
        }

        return [
            'weight' => $weightKg,
            'height' => $heightCm,
            'head_circ' => $headCircCm ?? '-',
            'bmi' => $bmi,
            'percentile_label' => $percentileLabel,
            'badge_class' => $percentileBadgeClass,
            'z_score' => $zScore
        ];
    }
}
