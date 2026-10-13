<?php

namespace App\Modules\Prescription\Services;

use App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider;

class DrugSafetyService
{
    protected MockPatientDataProvider $patientDataProvider;

    // Yaygın İlaç - Etken Madde Veritabanı (Sanal / Mock Sözlük)
    protected array $activeIngredients = [
        'parol' => 'Parasetamol',
        'minoset' => 'Parasetamol',
        'vermidon' => 'Parasetamol',
        'coraspin' => 'Asetilsalisilik Asit',
        'aspirin' => 'Asetilsalisilik Asit',
        'candesartan' => 'Kandesartan Cileksetil',
        'atacand' => 'Kandesartan Cileksetil',
        'augmentin' => 'Amoksisilin / Klavulanik Asit',
        'penoksilin' => 'Penisilin G',
        'penisilin' => 'Penisilin G',
        'apranax' => 'Naproksen Sodyum',
        'majezik' => 'Flurbiprofen',
        'voltaren' => 'Diklofenak Sodyum',
        'beloc' => 'Metoprolol',
        'dideral' => 'Propranolol',
        'crestor' => 'Rosuvastatin',
        'tetradox' => 'Doksisiklin',
        'cipro' => 'Siprofloksasin',
        'xanax' => 'Alprazolam'
    ];

    public function __construct(MockPatientDataProvider $patientDataProvider)
    {
        $this->patientDataProvider = $patientDataProvider;
    }

    /**
     * Yazılan ilacın alerji, gebelik, kronik hastalık ve çift doz kontrollerini yapar.
     */
    public function checkDrugSafety(string $drugName, int $patientId = 1): array
    {
        $patientProfile = $this->patientDataProvider->getVirtualPatientProfile($patientId);
        $warnings = [];

        $normalizedDrug = mb_strtolower(trim($drugName));
        $activeIngredient = $this->findActiveIngredient($normalizedDrug);

        // 1. Alerji Kontrolü
        $allergies = $patientProfile['allergies'] ?? [];
        foreach ($allergies as $allergy) {
            $normalizedAllergy = mb_strtolower($allergy);
            
            $isPenicillinAllergy = (str_contains($normalizedAllergy, 'penisilin') || str_contains($normalizedAllergy, 'penasilin')) && 
                                  (str_contains($normalizedDrug, 'augmentin') || str_contains($normalizedDrug, 'pen'));

            $isNsaidAllergy = (str_contains($normalizedAllergy, 'nsa') || str_contains($normalizedAllergy, 'aspirin')) && 
                              (str_contains($normalizedDrug, 'apranax') || str_contains($normalizedDrug, 'majezik') || str_contains($normalizedDrug, 'voltaren') || str_contains($normalizedDrug, 'coraspin') || str_contains($normalizedDrug, 'aspirin'));

            if (
                $isPenicillinAllergy ||
                $isNsaidAllergy ||
                str_contains($normalizedDrug, $normalizedAllergy) || 
                str_contains($normalizedAllergy, $normalizedDrug) ||
                ($activeIngredient && str_contains(mb_strtolower($activeIngredient), $normalizedAllergy))
            ) {
                $warnings[] = [
                    'type' => 'allergy_warning',
                    'title' => '⚠️ KRİTİK ALERJİ UYARISI',
                    'description' => "Hastanın '{$allergy}' alerjisi mevcuttur! Reçete edilmek istenen '{$drugName}' ilacı hayati alerjik reaksiyon (Anafilaksi) riski taşımaktadır.",
                    'severity' => 'danger'
                ];
            }
        }

        // 2. Gebelik (Hamilelik) Kontrendikasyon Kontrolü
        $chronicList = array_map('mb_strtolower', $patientProfile['chronic_diseases'] ?? []);
        $chronicStr = implode(' ', $chronicList);
        $isPregnant = str_contains($chronicStr, 'gebelik') || str_contains($chronicStr, 'hamile') || str_contains($chronicStr, 'gebe');

        if ($isPregnant) {
            $isUnsafePregnancyDrug = str_contains($normalizedDrug, 'candesartan') ||
                                    str_contains($normalizedDrug, 'crestor') ||
                                    str_contains($normalizedDrug, 'tetradox') ||
                                    str_contains($normalizedDrug, 'apranax') ||
                                    str_contains($normalizedDrug, 'voltaren') ||
                                    str_contains($normalizedDrug, 'cipro') ||
                                    str_contains($normalizedDrug, 'xanax');

            if ($isUnsafePregnancyDrug) {
                $warnings[] = [
                    'type' => 'pregnancy_contraindication',
                    'title' => '⚠️ GEBELİK KONTRENDİKASYONU UYARISI',
                    'description' => "Hasta gebedir! '{$drugName}' ilacı fetal toksisite ve teratojenik risk nedeniyle gebelikte KULLANILAMAZ!",
                    'severity' => 'danger'
                ];
            }
        }

        // 3. Kronik Hastalık Kontrendikasyon Kontrolü
        $isAsthmaOrCopd = str_contains($chronicStr, 'astım') || str_contains($chronicStr, 'koah') || str_contains($chronicStr, 'j45') || str_contains($chronicStr, 'j44');
        if ($isAsthmaOrCopd) {
            if (str_contains($normalizedDrug, 'beloc') || str_contains($normalizedDrug, 'dideral')) {
                $warnings[] = [
                    'type' => 'disease_contraindication',
                    'title' => '⚠️ ASTIM / KOAH KONTRENDİKASYONU',
                    'description' => "Hastanın Alerjik Astım/KOAH tanısı mevcuttur! Beta-Blokör içeren '{$drugName}' ilacı bronkospazmı tetikleyebilir!",
                    'severity' => 'danger'
                ];
            }
            if (str_contains($normalizedDrug, 'apranax') || str_contains($normalizedDrug, 'voltaren') || str_contains($normalizedDrug, 'majezik')) {
                $warnings[] = [
                    'type' => 'disease_contraindication',
                    'title' => '⚠️ ASTIM TETİKLEME UYARISI',
                    'description' => "Hastanın Astım/KOAH öyküsü mevcuttur. NSAİİ içerikli '{$drugName}' ilacı Aspirin/NSAİİ ilişkili bronkospazma yol açabilir.",
                    'severity' => 'warning'
                ];
            }
        }

        // 4. Aynı Etken Madde Kontrolü (Duplicate Active Ingredient)
        $activeMeds = $patientProfile['medication_history'] ?? [];
        foreach ($activeMeds as $med) {
            $activeMedName = mb_strtolower($med['drug_name']);
            $existingActiveIngredient = $this->findActiveIngredient($activeMedName);

            if ($activeIngredient && $existingActiveIngredient && $activeIngredient === $existingActiveIngredient) {
                $warnings[] = [
                    'type' => 'duplicate_ingredient',
                    'title' => '⚠️ AYNI ETKEN MADDE UYARISI',
                    'description' => "Hastanın aktif tedavilerinde zaten aynı etken maddeye ({$activeIngredient}) sahip '{$med['drug_name']}' ilacı bulunmaktadır. Çift doz uyarısı!",
                    'severity' => 'warning'
                ];
            }
        }

        return [
            'has_warnings' => !empty($warnings),
            'drug_name' => $drugName,
            'active_ingredient' => $activeIngredient ?? 'Genel Etken Madde',
            'warnings' => $warnings
        ];
    }

    protected function findActiveIngredient(string $normalizedDrugName): ?string
    {
        foreach ($this->activeIngredients as $key => $ingredient) {
            if (str_contains($normalizedDrugName, $key)) {
                return $ingredient;
            }
        }
        return null;
    }
}
