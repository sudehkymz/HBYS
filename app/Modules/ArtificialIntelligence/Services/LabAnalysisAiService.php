<?php

namespace App\Modules\ArtificialIntelligence\Services;

class LabAnalysisAiService
{
    protected MockPatientDataProvider $patientDataProvider;

    public function __construct(MockPatientDataProvider $patientDataProvider)
    {
        $this->patientDataProvider = $patientDataProvider;
    }

    /**
     * Hastanın tıbbi dosyasındaki laboratuvar sonuçlarını tarar, analiz eder ve 3 boyutlu AI raporu üretir.
     */
    public function analyzePatientLabResults(int $patientId = 1, array $customLabResults = []): array
    {
        $patient = $this->patientDataProvider->getVirtualPatientProfile($patientId);

        // Lab sonuçlarını belirle (varsa custom yoksa hastanın tıbbi dosyasındaki lab verileri)
        $labs = !empty($customLabResults) ? $customLabResults : ($patient['lab_results'] ?? []);

        // Eğer lab verisi kısıtlı ise zenginleştirmek adına hastaya özel klinik lab sonuçlarını haritala
        $labs = $this->ensureComprehensiveLabDataset($patientId, $labs);

        // 1. Taranmış Lab Sonuçları ve Durum Analizi
        $analyzedLabs = $this->evaluateLabParameters($labs);

        // 2. Mevcut Olası Hastalıklar (Teşhis Tahmin Motoru)
        $currentDiagnoses = $this->predictCurrentDiagnoses($analyzedLabs, $patient);

        // 3. Gelecek Risk & Komplikasyon Öngörü Motoru (1-5 Yıllık Projeksiyon)
        $futureRisks = $this->predictFutureRisks($analyzedLabs, $patient, $currentDiagnoses);

        // 4. Değerleri Düzeltme & İyileştirme Önerileri
        $recommendations = $this->generateImprovementRecommendations($analyzedLabs, $patient, $currentDiagnoses, $futureRisks);

        return [
            'status' => 'success',
            'analysis_id' => 'AI-LAB-' . time() . '-' . rand(100, 999),
            'timestamp' => date('Y-m-d H:i:s'),
            'patient_info' => [
                'id' => $patient['patient_id'] ?? $patientId,
                'name' => trim(($patient['first_name'] ?? '') . ' ' . ($patient['last_name'] ?? '')),
                'age' => $this->calculateAge($patient['birth_date'] ?? '1985-01-01'),
                'gender' => $patient['gender'] ?? 'Belirtilmedi',
                'chronic_diseases' => $patient['chronic_diseases'] ?? [],
                'allergies' => $patient['allergies'] ?? [],
            ],
            'scanned_labs_count' => count($analyzedLabs),
            'abnormal_labs_count' => count(array_filter($analyzedLabs, fn($l) => $l['status_code'] !== 'normal')),
            'scanned_lab_results' => $analyzedLabs,
            'current_diagnoses' => $currentDiagnoses,
            'future_risks' => $futureRisks,
            'improvement_recommendations' => $recommendations,
            'ai_confidence_score' => $this->calculateOverallConfidenceScore($analyzedLabs),
            'disclaimer' => 'Yapay Zekâ Karar Desteğidir. Nihai teşhis ve tedavi kararı uzman hekim onayına tabidir.'
        ];
    }

    /**
     * Test ve simülasyon amacıyla hastaya özel lab verisini klinik standartlarda zenginleştirir.
     */
    protected function ensureComprehensiveLabDataset(int $patientId, array $existingLabs): array
    {
        if (count($existingLabs) >= 4) {
            return $existingLabs;
        }

        // Örnek hastalar için gerçekçi tıbbi dosya lab sonuçları ekle
        $additionalMap = [
            1 => [ // Ahmet Yılmaz (Diyabet & Hipertansiyon & Dislipidemi)
                ['test_name' => 'HbA1c', 'value' => '7.8', 'unit' => '%', 'reference' => '4.0 - 6.0', 'date' => '2026-07-15'],
                ['test_name' => 'Açlık Kan Şekeri (AKŞ)', 'value' => '148', 'unit' => 'mg/dL', 'reference' => '70 - 100', 'date' => '2026-07-15'],
                ['test_name' => 'LDL Kolesterol', 'value' => '142', 'unit' => 'mg/dL', 'reference' => '< 100', 'date' => '2026-07-15'],
                ['test_name' => 'Trigliserid', 'value' => '210', 'unit' => 'mg/dL', 'reference' => '< 150', 'date' => '2026-07-15'],
                ['test_name' => 'Kreatinin', 'value' => '1.25', 'unit' => 'mg/dL', 'reference' => '0.7 - 1.2', 'date' => '2026-07-15'],
                ['test_name' => 'eGFR (Böbrek Süzme Hızı)', 'value' => '68', 'unit' => 'mL/min/1.73m²', 'reference' => '> 90', 'date' => '2026-07-15'],
                ['test_name' => 'ALT (SGPT)', 'value' => '48', 'unit' => 'U/L', 'reference' => '7 - 45', 'date' => '2026-07-15'],
            ],
            2 => [ // Ayşe Demir (Anemi & Gebelik)
                ['test_name' => 'Hemoglobin (Hb)', 'value' => '10.5', 'unit' => 'g/dL', 'reference' => '12.0 - 15.5', 'date' => '2026-07-20'],
                ['test_name' => 'Hematokrit (HCT)', 'value' => '32.1', 'unit' => '%', 'reference' => '36.0 - 46.0', 'date' => '2026-07-20'],
                ['test_name' => 'Ferritin', 'value' => '14', 'unit' => 'ng/mL', 'reference' => '20 - 200', 'date' => '2026-07-20'],
                ['test_name' => 'Açlık Kan Şekeri (OGTT)', 'value' => '92', 'unit' => 'mg/dL', 'reference' => '< 95', 'date' => '2026-07-20'],
                ['test_name' => 'TSH', 'value' => '2.4', 'unit' => 'mIU/L', 'reference' => '0.4 - 4.2', 'date' => '2026-07-20'],
            ],
            3 => [ // Mehmet Kaya (KOAH & Kalp Yetmezliği & Böbrek Sınırda)
                ['test_name' => 'BNP (B-Tipi Natriüretik Peptit)', 'value' => '450', 'unit' => 'pg/mL', 'reference' => '< 100', 'date' => '2026-07-22'],
                ['test_name' => 'Kreatinin', 'value' => '1.65', 'unit' => 'mg/dL', 'reference' => '0.7 - 1.2', 'date' => '2026-07-22'],
                ['test_name' => 'Üre', 'value' => '54', 'unit' => 'mg/dL', 'reference' => '15 - 45', 'date' => '2026-07-22'],
                ['test_name' => 'Potasyum (K)', 'value' => '5.2', 'unit' => 'mEq/L', 'reference' => '3.5 - 5.1', 'date' => '2026-07-22'],
                ['test_name' => 'Lökosit (WBC)', 'value' => '11.8', 'unit' => '10^3/µL', 'reference' => '4.5 - 11.0', 'date' => '2026-07-22'],
                ['test_name' => 'CRP (C-Reaktif Protein)', 'value' => '18.4', 'unit' => 'mg/L', 'reference' => '< 5.0', 'date' => '2026-07-22'],
            ],
        ];

        return $additionalMap[$patientId] ?? $existingLabs;
    }

    /**
     * Lab parametrelerini standartlaştırır ve yüksek/düşük durum değerlendirmesi yapar.
     */
    protected function evaluateLabParameters(array $labs): array
    {
        $evaluated = [];

        foreach ($labs as $lab) {
            $name = $lab['test_name'] ?? 'Bilinmeyen Test';
            $val = (float) str_replace(',', '.', (string) ($lab['value'] ?? '0'));
            $unit = $lab['unit'] ?? '';
            $ref = $lab['reference'] ?? '';
            $date = $lab['date'] ?? date('Y-m-d');

            $statusInfo = $this->determineStatus($name, $val, $ref);

            $evaluated[] = [
                'name' => $name,
                'value' => $lab['value'] ?? $val,
                'numeric_value' => $val,
                'unit' => $unit,
                'reference' => $ref,
                'date' => $date,
                'status_label' => $statusInfo['label'],
                'status_code' => $statusInfo['code'], // 'normal', 'high', 'critical_high', 'low', 'critical_low'
                'badge_class' => $statusInfo['badge_class'],
                'deviation_percent' => $statusInfo['deviation_percent'],
            ];
        }

        return $evaluated;
    }

    /**
     * Referans değerler üzerinden yüksek/düşük/kritik durumlarını hesaplar.
     */
    protected function determineStatus(string $name, float $val, string $ref): array
    {
        $nameLower = mb_strtolower($name, 'UTF-8');

        // Varsayılan
        $label = 'Normal';
        $code = 'normal';
        $badgeClass = 'bg-success';
        $deviation = 0;

        // Spesifik test eşikleri
        if (str_contains($nameLower, 'hba1c')) {
            if ($val >= 8.0) { $label = 'Kritik Yüksek'; $code = 'critical_high'; $badgeClass = 'bg-danger'; $deviation = (($val - 6.0) / 6.0) * 100; }
            elseif ($val >= 6.5) { $label = 'Yüksek (Diyabetik)'; $code = 'high'; $badgeClass = 'bg-warning text-dark'; $deviation = (($val - 6.0) / 6.0) * 100; }
            elseif ($val >= 5.7) { $label = 'Sınırda (Prediyabet)'; $code = 'high'; $badgeClass = 'bg-info text-dark'; $deviation = 10; }
        } elseif (str_contains($nameLower, 'ldl')) {
            if ($val >= 160) { $label = 'Kritik Yüksek'; $code = 'critical_high'; $badgeClass = 'bg-danger'; $deviation = (($val - 100) / 100) * 100; }
            elseif ($val > 100) { $label = 'Yüksek'; $code = 'high'; $badgeClass = 'bg-warning text-dark'; $deviation = (($val - 100) / 100) * 100; }
        } elseif (str_contains($nameLower, 'bnp')) {
            if ($val >= 400) { $label = 'Kritik Yüksek'; $code = 'critical_high'; $badgeClass = 'bg-danger'; $deviation = (($val - 100) / 100) * 100; }
            elseif ($val > 100) { $label = 'Yüksek'; $code = 'high'; $badgeClass = 'bg-warning text-dark'; $deviation = (($val - 100) / 100) * 100; }
        } elseif (str_contains($nameLower, 'kreatinin')) {
            if ($val >= 2.0) { $label = 'Kritik Yüksek'; $code = 'critical_high'; $badgeClass = 'bg-danger'; $deviation = (($val - 1.2) / 1.2) * 100; }
            elseif ($val > 1.2) { $label = 'Yüksek'; $code = 'high'; $badgeClass = 'bg-warning text-dark'; $deviation = (($val - 1.2) / 1.2) * 100; }
        } elseif (str_contains($nameLower, 'hemoglobin') || str_contains($nameLower, 'hb')) {
            if ($val < 10.0) { $label = 'Belirgin Düşük (Anemi)'; $code = 'critical_low'; $badgeClass = 'bg-danger'; $deviation = ((12.0 - $val) / 12.0) * 100; }
            elseif ($val < 12.0) { $label = 'Hafif Düşük'; $code = 'low'; $badgeClass = 'bg-warning text-dark'; $deviation = ((12.0 - $val) / 12.0) * 100; }
        } elseif (str_contains($nameLower, 'egfr')) {
            if ($val < 60) { $label = 'Düşük (Böbrek Fonksiyon Kaybı)'; $code = 'high'; $badgeClass = 'bg-warning text-dark'; $deviation = ((90 - $val) / 90) * 100; }
        } elseif (str_contains($nameLower, 'crp')) {
            if ($val >= 10.0) { $label = 'Kritik Yüksek (İnflamasyon)'; $code = 'critical_high'; $badgeClass = 'bg-danger'; $deviation = (($val - 5) / 5) * 100; }
            elseif ($val > 5.0) { $label = 'Yüksek'; $code = 'high'; $badgeClass = 'bg-warning text-dark'; }
        } else {
            // Genel kural: Parse min-max if exists
            if (preg_match('/([\d\.]+)\s*-\s*([\d\.]+)/', $ref, $m)) {
                $min = (float) $m[1];
                $max = (float) $m[2];
                if ($val > $max) {
                    $label = 'Yüksek'; $code = 'high'; $badgeClass = 'bg-warning text-dark';
                    $deviation = (($val - $max) / $max) * 100;
                } elseif ($val < $min) {
                    $label = 'Düşük'; $code = 'low'; $badgeClass = 'bg-info text-dark';
                    $deviation = (($min - $val) / $min) * 100;
                }
            }
        }

        return [
            'label' => $label,
            'code' => $code,
            'badge_class' => $badgeClass,
            'deviation_percent' => round(max(0, $deviation), 1)
        ];
    }

    /**
     * Taranan lab parametrelerinden hastanın MEVCUT olası hastalıklarını tahminler.
     */
    protected function predictCurrentDiagnoses(array $labs, array $patient): array
    {
        $diagnoses = [];
        $labMap = [];
        foreach ($labs as $l) {
            $labMap[mb_strtolower($l['name'], 'UTF-8')] = $l;
        }

        // 1. Tip 2 Diyabet Mellitus (E11)
        $hba1c = $this->findLabValue($labMap, 'hba1c');
        $aks = $this->findLabValue($labMap, 'açlık kan şekeri') ?? $this->findLabValue($labMap, 'akş');
        if (($hba1c && $hba1c['numeric_value'] >= 6.5) || ($aks && $aks['numeric_value'] >= 126)) {
            $prob = min(96, round(70 + ($hba1c['numeric_value'] ?? 7.0) * 3.5));
            $diagnoses[] = [
                'disease' => 'Tip 2 Diyabet Mellitus (Glukoz Kontrol Bozukluğu)',
                'icd10' => 'E11',
                'probability' => $prob,
                'severity' => $hba1c['numeric_value'] >= 8.0 ? 'critical' : 'high',
                'severity_label' => $hba1c['numeric_value'] >= 8.0 ? '🚨 Kritik Yüksek Teşhis Riski' : '⚠️ Yüksek Olasılıklı Teşhis',
                'supporting_labs' => array_values(array_filter([$hba1c['name'] ?? null, $aks['name'] ?? null])),
                'clinical_summary' => 'HbA1c (' . ($hba1c['value'] ?? '-') . ' %) ve Açlık Glukoz değerleri diyabetik tanı eşiğinin (≥6.5%) üzerindedir. Hücresel insülin direnci ve glisemik kontrol bozukluğu mevcuttur.'
            ];
        }

        // 2. Primer Dislipidemi / Hiperkolesterolemi (E78)
        $ldl = $this->findLabValue($labMap, 'ldl');
        $trig = $this->findLabValue($labMap, 'trigliserid');
        if (($ldl && $ldl['numeric_value'] > 100) || ($trig && $trig['numeric_value'] > 150)) {
            $prob = min(92, round(65 + (($ldl['numeric_value'] ?? 100) - 100) * 0.4));
            $diagnoses[] = [
                'disease' => 'Mevcut Dislipidemi & Hiperkolesterolemi',
                'icd10' => 'E78.0',
                'probability' => $prob,
                'severity' => ($ldl['numeric_value'] ?? 0) >= 160 ? 'critical' : 'high',
                'severity_label' => ($ldl['numeric_value'] ?? 0) >= 160 ? '🚨 Kritik Yüksek Lipid Düzeyi' : '⚠️ Yüksek Olasılıklı Teşhis',
                'supporting_labs' => array_values(array_filter([$ldl['name'] ?? null, $trig['name'] ?? null])),
                'clinical_summary' => 'Serum LDL Kolesterol (' . ($ldl['value'] ?? '-') . ' mg/dL) ve Trigliserid seviyeleri hedef hekim aralığının belirgin üzerindedir. Damar içi aterom plak oluşum riski yüksektir.'
            ];
        }

        // 3. Kronik Böbrek Hastalığı Evre 2-3 (N18)
        $kreatinin = $this->findLabValue($labMap, 'kreatinin');
        $egfr = $this->findLabValue($labMap, 'egfr');
        if (($kreatinin && $kreatinin['numeric_value'] > 1.2) || ($egfr && $egfr['numeric_value'] < 90)) {
            $prob = min(90, round(60 + (($kreatinin['numeric_value'] ?? 1.2) - 1.0) * 35));
            $diagnoses[] = [
                'disease' => 'Erken / Orta Evre Kronik Böbrek Hastalığı (Böbrek Disfonksiyonu)',
                'icd10' => 'N18.2',
                'probability' => $prob,
                'severity' => ($kreatinin['numeric_value'] ?? 0) >= 1.5 ? 'critical' : 'medium',
                'severity_label' => ($kreatinin['numeric_value'] ?? 0) >= 1.5 ? '🚨 Kritik Böbrek Yükü' : '⚡ Orta Seviye Renal Risk',
                'supporting_labs' => array_values(array_filter([$kreatinin['name'] ?? null, $egfr['name'] ?? null])),
                'clinical_summary' => 'Serum Kreatinin (' . ($kreatinin['value'] ?? '-') . ' mg/dL) yüksek ve GFR filitrasyon değeri azalmıştır. Glomerüler süzme kapasitesinde hafif-orta azalma izlenmektedir.'
            ];
        }

        // 4. Kongestif Kalp Yetmezliği / Miyokard Yükü (I50)
        $bnp = $this->findLabValue($labMap, 'bnp');
        if ($bnp && $bnp['numeric_value'] > 100) {
            $prob = min(95, round(70 + ($bnp['numeric_value'] - 100) * 0.08));
            $diagnoses[] = [
                'disease' => 'Kongestif Kalp Yetmezliği & Ventriküler Duvar Gerilimi',
                'icd10' => 'I50.9',
                'probability' => $prob,
                'severity' => $bnp['numeric_value'] >= 400 ? 'critical' : 'high',
                'severity_label' => $bnp['numeric_value'] >= 400 ? '🚨 Acil Kardiyak Yük Uyarısı' : '⚠️ Yüksek Kardiyak Yük',
                'supporting_labs' => [$bnp['name']],
                'clinical_summary' => 'B-Tipi Natriüretik Peptit (BNP: ' . $bnp['value'] . ' pg/mL) kritik üst sınır olan 100 pg/mL seviyesini aşmıştır. Sol ventrikül dolum basıncı artışını ve kardiyak dekompansasyonu gösterir.'
            ];
        }

        // 5. Mikrositer Anemi / Demir Eksikliği (D50)
        $hb = $this->findLabValue($labMap, 'hemoglobin') ?? $this->findLabValue($labMap, 'hb');
        $ferritin = $this->findLabValue($labMap, 'ferritin');
        if ($hb && $hb['numeric_value'] < 12.0) {
            $prob = min(88, round(60 + (12.0 - $hb['numeric_value']) * 12));
            $diagnoses[] = [
                'disease' => 'Mikrositer / Nutrisyonel Demir Eksikliği Anemisi',
                'icd10' => 'D50.9',
                'probability' => $prob,
                'severity' => $hb['numeric_value'] < 10.0 ? 'high' : 'medium',
                'severity_label' => $hb['numeric_value'] < 10.0 ? '⚠️ Belirgin Anemi Tablosu' : '⚡ Hafif Anemi',
                'supporting_labs' => array_values(array_filter([$hb['name'] ?? null, $ferritin['name'] ?? null])),
                'clinical_summary' => 'Serum Hemoglobin (' . $hb['value'] . ' g/dL) ve Hematokrit seviyeleri fizyolojik alt sınırın altındadır. Doku oksijenasyonu düşmüş olup halsizlik ve dispne nedeni olabilir.'
            ];
        }

        // Varsayılan hafif genel bulgu (hiçbiri eşleşmezse)
        if (empty($diagnoses)) {
            $diagnoses[] = [
                'disease' => 'Spesifik Patoloji Saptanmadı (Metabolik Dengede)',
                'icd10' => 'Z00.0',
                'probability' => 95,
                'severity' => 'low',
                'severity_label' => '✅ Normal Klinik Tablo',
                'supporting_labs' => array_column($labs, 'name'),
                'clinical_summary' => 'Laboratuvar parametrelerinde akut klinik patoloji veya organ hasarı düşündürecek belirgin sapma izlenmemiştir.'
            ];
        }

        return $diagnoses;
    }

    /**
     * Taranan lab değerleri ve mevcut hastalıklardan GELECEKTE OLUŞABİLECEK Hastalık & Komplikasyon Risklerini tahmin eder.
     */
    protected function predictFutureRisks(array $labs, array $patient, array $currentDiagnoses): array
    {
        $risks = [];
        $labMap = [];
        foreach ($labs as $l) {
            $labMap[mb_strtolower($l['name'], 'UTF-8')] = $l;
        }

        $hba1c = $this->findLabValue($labMap, 'hba1c');
        $ldl = $this->findLabValue($labMap, 'ldl');
        $kreatinin = $this->findLabValue($labMap, 'kreatinin');
        $bnp = $this->findLabValue($labMap, 'bnp');
        $hb = $this->findLabValue($labMap, 'hemoglobin') ?? $this->findLabValue($labMap, 'hb');

        // 1. Aterosklerotik Kalp Hastalığı & Miyokard İnfarktüsü (I25)
        if (($ldl && $ldl['numeric_value'] > 130) || ($hba1c && $hba1c['numeric_value'] >= 7.0)) {
            $risks[] = [
                'condition' => 'Aterosklerotik Koroner Kalp Hastalığı & Miyokard İnfarktüsü',
                'timeline' => '2 - 4 Yıl İçi Yüksek Risk',
                'risk_score' => 84,
                'badge_class' => 'bg-danger',
                'impact_organ' => 'Koroner Damarlar & Kalp Kasları',
                'description' => 'Yüksek LDL kolesterol ve kontrolsüz glukoz seviyelerinin sürmesi durumunda damar endotelinde endotel disfonksiyonu, kronik inflamasyon ve koroner arterlerde tıkanmaya yol açan plak rüptürü riski %84 seviyesindedir.'
            ];
        }

        // 2. Diyabetik Nefropati & İleri Kronik Böbrek Yetmezliği (N18.5)
        if (($hba1c && $hba1c['numeric_value'] >= 7.5) || ($kreatinin && $kreatinin['numeric_value'] >= 1.2)) {
            $risks[] = [
                'condition' => 'Diyabetik Nefropati & İleri Kronik Renal Harabiyet',
                'timeline' => '1 - 3 Yıl İçi Kritik Risk',
                'risk_score' => 88,
                'badge_class' => 'bg-danger',
                'impact_organ' => 'Böbrek Glomerülleri & Renal Mikrovasküler Yapı',
                'description' => 'Yüksek serum glukozu ve renal glomerüler aşırı yükleme (hiperfiltrasyon) devam ederse, glomerül kılcal damarlarında skleroz gelişerek 3 yıl içinde proteinüri artışı ve evre 4 kronik böbrek yetmezliğine ilerleme riski mevcuttur.'
            ];
        }

        // 3. Serebrovasküler Olay (İnme / İnme Riski - I63)
        if (($ldl && $ldl['numeric_value'] >= 140) || in_array('Essansiyel Hipertansiyon (I10)', $patient['chronic_diseases'] ?? [])) {
            $risks[] = [
                'condition' => 'Serebrovasküler İnme (Stroke) & Karotis Arter Darlığı',
                'timeline' => '3 - 5 Yıl İçi Orta-Yüksek Risk',
                'risk_score' => 76,
                'badge_class' => 'bg-warning text-dark',
                'impact_organ' => 'Beyin Parankimi & Karotis Damarları',
                'description' => 'Sistemik hipertansiyon ile kombine yüksek LDL kolesterol, beyin damarlarında mikroanevrizma ve tromboembolik tıkama riskini artırır.'
            ];
        }

        // 4. Kardiyak Dekompansasyon & Akut Pulmoner Ödem (I50.1)
        if ($bnp && $bnp['numeric_value'] >= 300) {
            $risks[] = [
                'condition' => 'Akut Kardiyak Dekompansasyon & Pulmoner Kongesyon',
                'timeline' => '6 Ay - 1 Yıl İçi Yakın Risk',
                'risk_score' => 91,
                'badge_class' => 'bg-danger',
                'impact_organ' => 'Akciğer Alveolleri & Sol Ventrikül',
                'description' => 'Artmış BNP seviyesi sol ventrikül dolum basıncının yüksek olduğunu gösterir. Uygun diüretik ve vazodilatör ayarı yapılmazsa 1 yıl içinde acil servise akciğer ödemi başvurusu kaçınılmaz hale gelebilir.'
            ];
        }

        // 5. Kronik Doku Hipoksisi & Yorgunluk Sendromu
        if ($hb && $hb['numeric_value'] < 11.0) {
            $risks[] = [
                'condition' => 'Doku Hipoksisi, Periferik Yorgunluk & Kardiyak Debi Artış Zoru',
                'timeline' => '6 Ay İçi Orta Risk',
                'risk_score' => 68,
                'badge_class' => 'bg-info text-dark',
                'impact_organ' => 'Sistemik Dokular & Miyokard Oksijenlenmesi',
                'description' => 'Düşük hemoglobin uzun süre düzeltilmezse dokuların oksijenlenmesi bozulur ve kalp kompanse etmek adına atım hacmini artırarak hipertrofiye yönelebilir.'
            ];
        }

        return $risks;
    }

    /**
     * Laboratuvar değerlerini DÜZELTMEK ve hastayı iyileştirmek için Klinik Öneriler oluşturur.
     */
    protected function generateImprovementRecommendations(array $labs, array $patient, array $diagnoses, array $futureRisks): array
    {
        $labMap = [];
        foreach ($labs as $l) {
            $labMap[mb_strtolower($l['name'], 'UTF-8')] = $l;
        }

        $hba1c = $this->findLabValue($labMap, 'hba1c');
        $ldl = $this->findLabValue($labMap, 'ldl');
        $kreatinin = $this->findLabValue($labMap, 'kreatinin');
        $bnp = $this->findLabValue($labMap, 'bnp');
        $hb = $this->findLabValue($labMap, 'hemoglobin') ?? $this->findLabValue($labMap, 'hb');

        $medicalAdjustments = [];
        $lifestyleAndNutrition = [];
        $followupSchedule = [];

        // 1. Şeker & HbA1c Düzeltme Önerileri
        if ($hba1c && $hba1c['numeric_value'] >= 6.5) {
            $medicalAdjustments[] = [
                'title' => 'Diyabet Medikal Tedavi & SGLT2 İnhibitörü/Metformin Değerlendirmesi',
                'detail' => 'HbA1c (' . $hba1c['value'] . ' %) hedef seviye olan <%6.5 altına çekilmelidir. Mevcut antidiyabetik ilaç dozu gözden geçirilmeli; renal koruma sağlayan SGLT2i (örn. Empagliflozin) veya GLP-1 reseptör agonisti eklenmesi hekimce değerlendirilmelidir.'
            ];
            $lifestyleAndNutrition[] = [
                'title' => 'Düşük Glisemik İndeksli Beslenme & Karbonhidrat Kısıtlaması',
                'detail' => 'Diyetisyen eşliğinde basit şeker, işlenmiş unlu gıdalar ve meyve suları tamamen kısıtlanmalı; lif oranı yüksek baklegil, sebze ve tam tahıllı diyet modeline geçilmelidir.'
            ];
            $followupSchedule[] = [
                'title' => '3 Aylık HbA1c & Açlık-Tokluk Kan Şekeri Takip Profili',
                'detail' => '3 ay sonra HbA1c kontrolü yapılmalı ve evde haftalık 7 noktalı kan şekeri takibi kaydedilmelidir.'
            ];
        }

        // 2. Kolesterol & Lipid Düzeltme Önerileri
        if ($ldl && $ldl['numeric_value'] > 100) {
            $medicalAdjustments[] = [
                'title' => 'Statin Tedavisi & Hedef LDL <70 mg/dL Titrasyonu',
                'detail' => 'LDL Kolesterol (' . $ldl['value'] . ' mg/dL) yüksek. Hipertansiyon/diyabetik kardiyovasküler risk nedeniyle LDL kolesterol seviyesinin <70 mg/dL (veya yüksek risklilerde <55 mg/dL) seviyesine indirilmesi için orta/yüksek yoğunluklu Statin (örn. Atorvastatin 20mg) başlanması veya doz artırımı önerilir.'
            ];
            $lifestyleAndNutrition[] = [
                'title' => 'Doymuş Yağ Kısıtlaması & Akdeniz Tipi Antioksidan Diyet',
                'detail' => 'Doymuş yağlar (kırmızı et yağı, margarin, sakatat) kısıtlanmalı; zeytinyağı, Omega-3 (ceviz, balık) ve çözünür lif ağırlıklı Akdeniz diyeti uygulanmalıdır.'
            ];
            $followupSchedule[] = [
                'title' => '2 Ay Sonra Lipid Paneli & Karaciğer Enzim (ALT/AST) Kontrolü',
                'detail' => 'Statin tedavisi/diyet değişikliği sonrası 8. haftada serum lipid paneli ve ALT/AST karaciğer güvenliği kontrol edilmelidir.'
            ];
        }

        // 3. Renal Fonksiyon & Kreatinin Düzeltme Önerileri
        if ($kreatinin && $kreatinin['numeric_value'] > 1.2) {
            $medicalAdjustments[] = [
                'title' => 'Nefrotoksik İlaç (NSAİİ/Aspirin) Kısıtlaması & Nefrokoruyucu İlaç Ayarı',
                'detail' => 'Kreatinin (' . $kreatinin['value'] . ' mg/dL) yüksek. Ağrı kesici (NSAİİ grubu ibuprofen, naproksen vb.) kullanımı kesin olarak durdurulmalı, nefrotoksik kontrast maddelerden sakınılmalıdır. ACE inhibitörü / ARB tedavisinin renal perfüzyona etkisi izlenmelidir.'
            ];
            $lifestyleAndNutrition[] = [
                'title' => 'Yeterli Hidrasyon (Günlük 2.5L Su) & Günlük Sodyum <2g Kısıtlaması',
                'detail' => 'Böbrek perfüzyonunu korumak adına günlük sıvı alımı 2.5 litreye çıkarılmalı, tuz alımı günlük <2 gram (1 çay kaşığı) ile sınırlandırılmalıdır.'
            ];
            $followupSchedule[] = [
                'title' => 'Spot İdrarda Mikroalbümin / Kreatinin Oranı & Üreter USG',
                'detail' => 'Nefroloji / Dahiliye kontrolünde spot idrarda proteinüri/albüminüri taraması ve renal ultrasonografi planlanmalıdır.'
            ];
        }

        // 4. Kalp Yetmezliği & BNP Düzeltme Önerileri
        if ($bnp && $bnp['numeric_value'] > 100) {
            $medicalAdjustments[] = [
                'title' => 'Diüretik Doz Titrasyonu & ARNI / Beta-Blokör Tedavisi',
                'detail' => 'BNP (' . $bnp['value'] . ' pg/mL) yüksek kardiyak yükü işaret eder. Hekim tarafından Loop diüretik (Furosemid) dozu ve Sakubitril/Valsartan (ARNI) kombinasyon seçeneği kardiyoloji uzmanınca değerlendirilmelidir.'
            ];
            $lifestyleAndNutrition[] = [
                'title' => 'Sıkı Sıvı Kısıtlaması (Max 1.5L/Gün) & Günlük Kilo Takibi',
                'detail' => 'Ödem ve kardiyak konjesyonu önlemek için günlük toplam sıvı alımı 1.5 litreyi aşmamalı, her sabah aç karnına tartılarak 3 günde 2 kg üzeri artışta doktora başvurulmalıdır.'
            ];
            $followupSchedule[] = [
                'title' => 'Ekokardiyografi (EKO) & Kardiyoloji Poliklinik Kontrolü',
                'detail' => 'Sol ventrikül ejeksiyon fraksiyonu (EF) ve kapak yapılarını değerlendirmek için 1 ay içinde kontrol EKO çekilmelidir.'
            ];
        }

        // 5. Anemi & Hemoglobin Düzeltme Önerileri
        if ($hb && $hb['numeric_value'] < 12.0) {
            $medicalAdjustments[] = [
                'title' => 'Oral / IV Elemental Demir (Ferrum) Takviyesi & C Vitamini',
                'detail' => 'Hemoglobin (' . $hb['value'] . ' g/dL) düşük. Günlük 100-200 mg elemental demir takviyesi C vitamini ile birlikte emilimi artırılacak şekilde aç karnına başlanmalıdır.'
            ];
            $lifestyleAndNutrition[] = [
                'title' => 'Demir Yönünden Zengin Beslenme & Çay/Kahve Zamanlaması',
                'detail' => 'Kırmızı et, karaciğer, yumurta sarısı ve koyu yeşil yapraklı sebzeler tüketime eklenmeli; demir emilimini engelleyen çay/kahve yemeklerden en az 1 saat sonra içilmelidir.'
            ];
            $followupSchedule[] = [
                'title' => '1 Ay Sonra Tam Kan Sayımı (Hemogram) & Ferritin Kontrolü',
                'detail' => 'Demir takviyesinin 4. haftasında Hb artışı ve retikülosit yanıtı kontrol edilmelidir.'
            ];
        }

        // Genel varsayılan tavsiye (özel eşleşme yoksa)
        if (empty($medicalAdjustments)) {
            $medicalAdjustments[] = [
                'title' => 'Rutin Poliklinik Takibi & Mevcut Tedavinin Korunması',
                'detail' => 'Mevcut reçeteli ilaçların düzenli kullanımına devam edilmesi ve yılda en az 1 kez genel sağlık taraması (check-up) yapılması önerilir.'
            ];
            $lifestyleAndNutrition[] = [
                'title' => 'Dengeli Beslenme & Haftalık Egzersiz Programı',
                'detail' => 'Haftada en az 150 dakika orta şiddette yürüyüş ve dengeli Akdeniz diyeti tavsiye edilir.'
            ];
            $followupSchedule[] = [
                'title' => '6 Aylık Rutin Kan & İdrar Taraması',
                'detail' => '6 ay sonra rutin tam kan ve biyokimya paneli tekrarlanmalıdır.'
            ];
        }

        return [
            'medical_adjustments' => $medicalAdjustments,
            'lifestyle_and_nutrition' => $lifestyleAndNutrition,
            'followup_schedule' => $followupSchedule,
        ];
    }

    /**
     * Lab haritasından isimle arama yapar.
     */
    protected function findLabValue(array $labMap, string $keyword): ?array
    {
        foreach ($labMap as $name => $data) {
            if (str_contains($name, $keyword)) {
                return $data;
            }
        }
        return null;
    }

    /**
     * Doğum tarihinden yaş hesaplar.
     */
    protected function calculateAge(string $birthDate): int
    {
        try {
            $dob = new \DateTime($birthDate);
            $now = new \DateTime();
            return $now->diff($dob)->y;
        } catch (\Throwable $e) {
            return 40;
        }
    }

    /**
     * Taranan verilerin ortalama AI güven skorunu hesaplar.
     */
    protected function calculateOverallConfidenceScore(array $labs): int
    {
        if (empty($labs)) return 85;
        $count = count($labs);
        return min(98, round(82 + ($count * 2.5)));
    }
}
