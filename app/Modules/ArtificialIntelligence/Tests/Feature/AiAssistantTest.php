<?php

namespace App\Modules\ArtificialIntelligence\Tests\Feature;

use App\Modules\ArtificialIntelligence\Services\AiGatewayService;
use App\Modules\ArtificialIntelligence\Services\DataMaskingService;
use App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider;
use App\Modules\Integrations\Adapters\AI\MockAiAdapter;
use PHPUnit\Framework\TestCase;

class AiAssistantTest extends TestCase
{
    /**
     * KVKK Veri Maskeleme Test Senaryosu (Sanal Veri)
     */
    public function test_data_masking_anonymizes_patient_pii(): void
    {
        $maskingService = new DataMaskingService();
        $rawPatientData = [
            'first_name' => 'Ahmet',
            'last_name' => 'Yılmaz',
            'national_id' => '12345678901',
            'phone' => '05321234567',
            'birth_date' => '1985-04-12'
        ];

        $masked = $maskingService->maskPatientData($rawPatientData);

        $this->assertEquals('A***', $masked['first_name']);
        $this->assertEquals('Y***', $masked['last_name']);
        $this->assertStringContainsString('***', $masked['national_id']);
        $this->assertArrayHasKey('age', $masked);
        $this->assertArrayNotHasKey('birth_date', $masked);
    }

    /**
     * Mock AI Adaptörü Hasta Özetleme Test Senaryosu
     */
    public function test_mock_ai_adapter_returns_patient_summary(): void
    {
        $adapter = new MockAiAdapter();
        $summary = $adapter->summarizePatient(['gender' => 'Erkek', 'age' => 41]);

        $this->assertArrayHasKey('summary_text', $summary);
        $this->assertGreaterThanOrEqual(0.90, $summary['confidence_score']);
        $this->assertStringContainsString('kardiyoloji', mb_strtolower($summary['summary_text']));
    }

    /**
     * Pediatrik Semptom ve Otizm / Bronşiyolit Senaryo Eşleştirme Testi
     */
    public function test_pediatric_symptom_mapping_and_autism_scenario(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        // 1. Senaryo: "bebeğimin nefes alması zorlaştı morarıyor"
        $babyResults = $icdService->suggestDiagnosisForSymptoms(['bebeğimin nefes alması zorlaştı morarıyor']);
        $babyCodes = array_column($babyResults, 'code');

        $this->assertContains('J21.9', $babyCodes); // Akut Bronşiyolit
        $this->assertNotContains('I21.9', $babyCodes); // Yetişkin Kalp Krizi olmamalı!

        // 2. Senaryo: "çocuğum insanların gözünün içine bakamıyor çok sessiz sakin"
        $autismResults = $icdService->suggestDiagnosisForSymptoms(['çocuğum insanların gözünün içine bakamıyor çok sessiz sakin']);
        $autismCodes = array_column($autismResults, 'code');

        $this->assertContains('F84.0', $autismCodes); // Çocukluk Otizmi
    }

    /**
     * Panik Atak (Anksiyete) ile Kalp Krizi Ayrıcı Tanı Test Senaryosu
     */
    public function test_panic_attack_vs_heart_attack_differential_diagnosis(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $panicText = '30 yaşında erkek hasta. Aniden başlayan göğüste sıkışma, kalp çarpıntısı, nefes alamama hissi, ellerde titreme/karıncalanma ve kontrolü kaybetme korkusu.';
        $results = $icdService->suggestDiagnosisForSymptoms([$panicText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        // Panik Bozukluk (F41.0) en üst sırada %98 güven skoruyla önerilmeli
        $this->assertEquals('F41.0', $topSuggestion['code']);
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * Üreter Taşı & Renal Kolik ile Kas-İskelet Bel Ağrısı Ayrıcı Tanı Test Senaryosu
     */
    public function test_ureteral_stone_renal_colic_vs_back_pain_differential_diagnosis(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $colicText = '38 yaşında erkek hasta. Sol bel/yan bölgesinde aniden başlayan, kasık bölgesine doğru vuran, dalgalı (kolik) tarzda kıvrandırıcı şiddetli ağrı ve bulantı.';
        $results = $icdService->suggestDiagnosisForSymptoms([$colicText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        // Üreter Taşı (N20.1) veya Renal Kolik (N23) %98 güvenle 1. sırada gelmeli, M54.5 (Bel Ağrısı) en üstte gelmemeli!
        $this->assertTrue(in_array($topSuggestion['code'], ['N20.1', 'N23', 'N20.0']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * Gastroözofageal Reflü (GÖRH) ile Soğuk Algınlığı (ÜSYE) Ayrıcı Tanı Test Senaryosu
     */
    public function test_gerd_vs_cold_differential_diagnosis(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $gerdText = '50 yaşında kadın hasta. Özellikle ağır yemeklerden sonra göğüs arkasında yukarı doğru yayılan yanma hissi, ağza acı/ekşi su gelmesi ve gece düz yatarken artan öksürük.';
        $results = $icdService->suggestDiagnosisForSymptoms([$gerdText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        // Gastroözofageal Reflü (K21.9) %98 güvenle 1. sırada gelmeli, J06 / J11 (Soğuk Algınlığı / Grip) en üstte gelmemeli!
        $this->assertTrue(in_array($topSuggestion['code'], ['K21.9', 'K21.0', 'K29.7']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * BPPV (Pozisyonel Vertigo) ile PID (N73.9) ve Baş Ağrısı (G44.2) Ayrıcı Tanı Test Senaryosu
     */
    public function test_bppv_vertigo_vs_pid_headache_differential_diagnosis(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $bppvText = '62 yaşında kadın hasta. Aniden yatakta dönerken veya başını yukarı kaldırırken başlayan, etrafın dönmesi şeklinde şiddetli baş dönmesi, dengesizlik ve bulantı.';
        $results = $icdService->suggestDiagnosisForSymptoms([$bppvText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        // BPPV / Vertigo (H81.1 / H81.9) %98 güvenle 1. sırada gelmeli, N73.9 (PID) veya G44.2 (Baş Ağrısı) en üstte gelmemeli!
        $this->assertTrue(in_array($topSuggestion['code'], ['H81.1', 'H81.9', 'H81.0', 'R42']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * Akut İnfeksiyöz Gastroenterit (A09.9) ile Kronik İBS (K58.0) Ayrıcı Tanı Test Senaryosu
     */
    public function test_acute_gastroenteritis_vs_ibs_differential_diagnosis(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $gastroText = '32 yaşında kadın hasta. 24 saattir devam eden sulu ishal (günde 6-7 kez), karın bölgesinde kramp tarzında ağrılar, bulantı, kusma ve hafif ateş.';
        $results = $icdService->suggestDiagnosisForSymptoms([$gastroText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        // İnfeksiyöz Gastroenterit (A09.9 / A08.4) %98 güvenle 1. sırada gelmeli, K58.0 (İBS) en üstte gelmemeli!
        $this->assertTrue(in_array($topSuggestion['code'], ['A09.9', 'A08.4', 'A09.0']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * Rotatör Manşet Sendromu / Omuz Hastalığı (M75.1) ile Vertigo (H81.1) Ayrıcı Tanı Test Senaryosu
     */
    public function test_rotator_cuff_shoulder_vs_vertigo_differential_diagnosis(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $shoulderText = '52 yaşında kadın hasta. Sol omzunu yukarı kaldırırken ve arkaya götürürken belirginleşen ağrı, gece ağrıyan tarafın üzerine yatamama ve omuz hareketlerinde kısıtlılık.';
        $results = $icdService->suggestDiagnosisForSymptoms([$shoulderText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        // Rotatör Manşet Sendromu (M75.1) veya Donuk Omuz (M75.0) %98 güvenle 1. sırada gelmeli, Vertigo (H81.1) en üstte gelmemeli!
        $this->assertTrue(in_array($topSuggestion['code'], ['M75.1', 'M75.0', 'M75.4', 'M75.9']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * El-Ayak-Ağız Hastalığı (B08.4) ile Jenerik Ateşli Hastalık (R50.9) Ayrıcı Tanı Test Senaryosu
     */
    public function test_hand_foot_mouth_disease_vs_fever_differential_diagnosis(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $hfmdText = '4 yaşında kız çocuk. 2 gündür süren 38.5°C ateş, iştahsızlık, ağız içinde küçük yaralar (aft) ve el/ayak tabanlarında kırmızı döküntüler.';
        $results = $icdService->suggestDiagnosisForSymptoms([$hfmdText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        // El-Ayak-Ağız Hastalığı (B08.4 / B08.5) %98 güvenle 1. sırada gelmeli, R50.9 (Jenerik Ateş) en üstte gelmemeli!
        $this->assertTrue(in_array($topSuggestion['code'], ['B08.4', 'B08.5']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * İnsomnia / Uykusuzluk (G47.0) Tanımlama Test Senaryosu
     */
    public function test_insomnia_sleep_disorder_identification(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $insomniaText = '45 yaşında erkek hasta. Haftalardır gece uyuyamıyorum, uyku tutmuyor, uykuya dalamıyorum ve sürekli gece uyanıyorum.';
        $results = $icdService->suggestDiagnosisForSymptoms([$insomniaText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        $this->assertTrue(in_array($topSuggestion['code'], ['G47.0', 'F51.0', 'G47.9']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * Obezite & Aşırı Kilo (E66.9) Tanımlama Test Senaryosu
     */
    public function test_obesity_excess_weight_identification(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $obesityText = '38 yaşında kadın hasta. Aşırı kilo, obezite, kilo veremiyorum, vücut kitle indeksi yüksek (VKİ > 32 kg/m²).';
        $results = $icdService->suggestDiagnosisForSymptoms([$obesityText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        $this->assertTrue(in_array($topSuggestion['code'], ['E66.9', 'E66.0', 'E66.2']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }

    /**
     * Anoreksiya Nervoza & Yeme Bozukluğu (F50.0) Tanımlama Test Senaryosu
     */
    public function test_anorexia_nervosa_eating_disorder_identification(): void
    {
        $icdService = new \App\Modules\ArtificialIntelligence\Services\Icd10CatalogService();

        $anorexiaText = '19 yaşında genç kız hasta. Kilo almaktan çok korkuyorum, yemek yemeyi reddediyorum, anoreksiya ve şiddetli kilo kaybı mevcut.';
        $results = $icdService->suggestDiagnosisForSymptoms([$anorexiaText]);

        $this->assertNotEmpty($results);
        $topSuggestion = $results[0];

        $this->assertTrue(in_array($topSuggestion['code'], ['F50.0', 'F50.9']));
        $this->assertGreaterThanOrEqual(0.95, $topSuggestion['confidence']);
    }
}
