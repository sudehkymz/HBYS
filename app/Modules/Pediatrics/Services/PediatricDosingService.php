<?php

namespace App\Modules\Pediatrics\Services;

class PediatricDosingService
{
    /**
     * Calculate Body Surface Area (BSA / VYA) in m2 using Mosteller formula:
     * BSA = sqrt( (height_cm * weight_kg) / 3600 )
     */
    public function calculateBSA(float $weightKg, float $heightCm): float
    {
        if ($weightKg <= 0 || $heightCm <= 0) {
            return 0.0;
        }
        return round(sqrt(($heightCm * $weightKg) / 3600), 2);
    }

    /**
     * Calculate weight-based daily dose: Dose = Weight (kg) * mgPerKg
     */
    public function calculateDoseByWeight(float $weightKg, float $mgPerKg): float
    {
        return round($weightKg * $mgPerKg, 2);
    }

    /**
     * Check if prescribed dose exceeds safety limits for pediatric patient.
     */
    public function checkDoseSafety(string $drugName, float $weightKg, float $prescribedMgDose): array
    {
        // Sample pediatric drug catalog limit guidelines (mg/kg/day)
        $drugLimits = [
            'Parasetamol' => ['min_per_kg' => 10, 'max_per_kg' => 15, 'max_daily_mg' => 1000],
            'İbuprofen' => ['min_per_kg' => 5, 'max_per_kg' => 10, 'max_daily_mg' => 400],
            'Amoksisilin' => ['min_per_kg' => 40, 'max_per_kg' => 90, 'max_daily_mg' => 2000],
            'Sefuroksim' => ['min_per_kg' => 20, 'max_per_kg' => 30, 'max_daily_mg' => 1000],
            'Prednol' => ['min_per_kg' => 1, 'max_per_kg' => 2, 'max_daily_mg' => 60],
        ];

        if (!isset($drugLimits[$drugName])) {
            return [
                'safe' => true,
                'warning' => null,
                'recommended_dose' => null
            ];
        }

        $limit = $drugLimits[$drugName];
        $recommendedMin = round($weightKg * $limit['min_per_kg'], 1);
        $recommendedMax = round($weightKg * $limit['max_per_kg'], 1);

        if ($prescribedMgDose > $recommendedMax) {
            return [
                'safe' => false,
                'warning' => "Doz Aşımı Riski! {$weightKg} kg hasta için '{$drugName}' maksimum tek Doz {$recommendedMax} mg olmalıdır. Girdiğiniz Doz: {$prescribedMgDose} mg!",
                'recommended_dose' => "{$recommendedMin} - {$recommendedMax} mg"
            ];
        }

        if ($prescribedMgDose < $recommendedMin) {
            return [
                'safe' => true,
                'warning' => "Düşük Doz Uyarısı: {$weightKg} kg hasta için '{$drugName}' alt sınırı {$recommendedMin} mg'dır. Girdiğiniz Doz: {$prescribedMgDose} mg.",
                'recommended_dose' => "{$recommendedMin} - {$recommendedMax} mg"
            ];
        }

        return [
            'safe' => true,
            'warning' => null,
            'recommended_dose' => "{$recommendedMin} - {$recommendedMax} mg (Uygun Doz)"
        ];
    }
}
