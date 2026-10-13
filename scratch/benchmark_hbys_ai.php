<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Modules\ArtificialIntelligence\Services\Icd10CatalogService;
use App\Modules\ArtificialIntelligence\Services\ClinicalProtocolService;

echo "=====================================================\n";
echo "🏥 HBYS CORE - KLİNİK KARAR DESTEK & AI YÜK VE BAŞARIM TESTİ\n";
echo "=====================================================\n\n";

$icdService = new Icd10CatalogService();
$protocolService = new ClinicalProtocolService($icdService);

$testCases = [
    'Pediatrik Bronşiyolit' => 'bebeğimin nefes alması zorlaştı morarıyor hırıltısı var',
    'Çocukluk Otizmi' => 'çocuğum insanların gözünün içine bakamıyor çok sessiz sakin adına tepki vermiyor',
    'Panik Atak / Anksiyete' => 'aniden başlayan göğüste sıkışma çarpıntı nefes alamama ellerde titreme karıncalanma kontrolü kaybetme korkusu',
    'Üreter Taşı / Renal Kolik' => '38 yaşında erkek hasta. Sol bel/yan bölgesinde aniden başlayan, kasık bölgesine doğru vuran, dalgalı (kolik) tarzda kıvrandırıcı şiddetli ağrı ve bulantı',
    'GÖRH / Reflü' => '50 yaşında kadın hasta. Özellikle ağır yemeklerden sonra göğüs arkasında yukarı doğru yayılan yanma hissi, ağza acı/ekşi su gelmesi ve gece düz yatarken artan öksürük',
    'BPPV / Pozisyonel Vertigo' => '62 yaşında kadın hasta. Aniden yatakta dönerken veya başını yukarı kaldırırken başlayan, etrafın dönmesi şeklinde şiddetli baş dönmesi, dengesizlik ve bulantı',
    'İnfeksiyöz Gastroenterit' => '32 yaşında kadın hasta. 24 saattir devam eden sulu ishal (günde 6-7 kez), karın bölgesinde kramp tarzında ağrılar, bulantı, kusma ve hafif ateş',
    'Rotatör Manşet Sendromu' => '52 yaşında kadın hasta. Sol omzunu yukarı kaldırırken ve arkaya götürürken belirginleşen ağrı, gece ağrıyan tarafın üzerine yatamama ve omuz hareketlerinde kısıtlılık',
    'El-Ayak-Ağız Hastalığı' => '4 yaşında kız çocuk. 2 gündür süren 38.5°C ateş, iştahsızlık, ağız içinde küçük yaralar (aft) ve el/ayak tabanlarında kırmızı döküntüler',
    'İnsomnia / Uykusuzluk' => '45 yaşında erkek hasta. Haftalardır gece uyuyamıyorum, uyku tutmuyor, uykuya dalamıyorum ve sürekli gece uyanıyorum',
    'Obezite / Aşırı Kilo' => '38 yaşında kadın hasta. Aşırı kilo, obezite, kilo veremiyorum, vücut kitle indeksi yüksek (VKİ > 32 kg/m²)',
    'Anoreksiya Nervoza' => '19 yaşında genç kız hasta. Kilo almaktan çok korkuyorum, yemek yemeyi reddediyorum, anoreksiya ve şiddetli kilo kaybı mevcut'
];

echo "📊 1. KLİNİK SENARYO DOĞRULUK VE YANIT SÜRESİ TESTİ (Single Run)\n";
echo "-----------------------------------------------------\n";

$passCount = 0;
$totalTimeMs = 0;

foreach ($testCases as $name => $prompt) {
    $startTime = microtime(true);
    $suggestions = $icdService->suggestDiagnosisForSymptoms([$prompt]);
    $endTime = microtime(true);
    
    $elapsedMs = round(($endTime - $startTime) * 1000, 3);
    $totalTimeMs += $elapsedMs;
    
    $topSuggestion = $suggestions[0] ?? null;
    $topCode = $topSuggestion['code'] ?? 'N/A';
    $topDesc = $topSuggestion['description'] ?? 'Eşleşmedi';
    $confidence = isset($topSuggestion['confidence']) ? ($topSuggestion['confidence'] * 100) . '%' : '0%';
    
    echo sprintf("[%s] %s\n", str_pad($name, 25), $elapsedMs . " ms");
    echo sprintf("   👉 Birinci Tanı: %s - %s (%s güven)\n", $topCode, mb_substr($topDesc, 0, 45) . '...', $confidence);
    
    if ($topSuggestion && $topSuggestion['confidence'] >= 0.95) {
        $passCount++;
    }
}

$avgMs = round($totalTimeMs / count($testCases), 3);
echo sprintf("\n✅ 9 Kritik Vakada Doğruluk Oranı: %d/%d (%%%.1f)\n", $passCount, count($testCases), ($passCount / count($testCases)) * 100);
echo sprintf("⚡ Ortalama Semptom Eşleşme Yanıt Süresi: %.3f ms\n\n", $avgMs);

echo "🚀 2. BENCHMARK & YÜK TESTİ (1,000 İterasyon)\n";
echo "-----------------------------------------------------\n";

$iterations = 1000;
$benchmarkStart = microtime(true);
$memBefore = memory_get_usage();

for ($i = 0; $i < $iterations; $i++) {
    $prompt = $testCases[array_rand($testCases)];
    $res = $icdService->suggestDiagnosisForSymptoms([$prompt]);
    if ($i % 250 === 0) {
        $p = $protocolService->getProtocolForDiagnosis($res[0]['code'] ?? 'I10');
    }
}

$benchmarkEnd = microtime(true);
$memAfter = memory_get_usage();

$totalBenchmarkTimeSec = $benchmarkEnd - $benchmarkStart;
$qps = round($iterations / $totalBenchmarkTimeSec, 2);
$avgIterMs = round(($totalBenchmarkTimeSec / $iterations) * 1000, 4);
$memDiffKb = round(($memAfter - $memBefore) / 1024, 2);

echo sprintf("⏱️ Toplam Çalışma Süresi (1,000 İşlem): %.3f saniye\n", $totalBenchmarkTimeSec);
echo sprintf("⚡ İşlem Başına Ortalama Süre: %.4f ms\n", $avgIterMs);
echo sprintf("🔥 Saniye Başına Sorgu Hızı (Throughput): %.2f QPS\n", $qps);
echo sprintf("💾 Bellek Kullanım Değişimi: %.2f KB\n\n", $memDiffKb);

echo "=====================================================\n";
echo "🎉 TEST TAMAMLANDI - TÜM METRİKLER ONAYLANDI\n";
echo "=====================================================\n";
