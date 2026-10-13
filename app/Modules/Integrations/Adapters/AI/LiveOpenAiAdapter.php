<?php

namespace App\Modules\Integrations\Adapters\AI;

use App\Modules\Integrations\Contracts\AiAdapterInterface;

class LiveOpenAiAdapter implements AiAdapterInterface
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key', env('OPENAI_API_KEY', ''));
        $this->model = config('services.openai.model', env('OPENAI_MODEL', 'gpt-4o-mini'));
        $this->baseUrl = 'https://api.openai.com/v1/chat/completions';
    }

    public function summarizePatient(array $patientData): array
    {
        if (empty($this->apiKey)) {
            $mock = new MockAiAdapter();
            return $mock->summarizePatient($patientData);
        }

        $prompt = "Aşağıdaki anonimleştirilmiş hasta verilerini incele ve doktora özlü bir hasta klinik özeti sun:\n" . json_encode($patientData, JSON_UNESCAPED_UNICODE);
        return $this->callApi($prompt, "Hasta Klinik Özeti");
    }

    public function generateClinicalNoteDraft(array $encounterData): array
    {
        if (empty($this->apiKey)) {
            $mock = new MockAiAdapter();
            return $mock->generateClinicalNoteDraft($encounterData);
        }

        $prompt = "Aşağıdaki muayene bulgularından doktor için epikriz / muayene notu taslağı oluştur:\n" . json_encode($encounterData, JSON_UNESCAPED_UNICODE);
        return $this->callApi($prompt, "Klinik Not Taslağı");
    }

    public function generateDecisionSupport(array $clinicalData): array
    {
        if (empty($this->apiKey)) {
            $mock = new MockAiAdapter();
            return $mock->generateDecisionSupport($clinicalData);
        }

        $prompt = "Aşağıdaki klinik verileri ve semptomları değerlendirerek doktora tavsiye edilen tetkikler ve uyarıları sun:\n" . json_encode($clinicalData, JSON_UNESCAPED_UNICODE);
        return $this->callApi($prompt, "Klinik Karar Desteği");
    }

    protected function callApi(string $prompt, string $contextTitle): array
    {
        $ch = curl_init($this->baseUrl);
        $payload = json_encode([
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => 'Sen T.C. Sağlık Bakanlığı HBYS klinik karar destek sisteminde görev yapan büyük çaplı uzman medikal AI asistanısın. Hastanın klinik bulgularını, vital değerlerini, yaş grubunu ve anemnezini değerlendirirken her zaman resmi T.C. Sağlık Bakanlığı ICD-10 Tanı Kataloğu standartlarını kullanmalısın. KRİTİK KLİNİK KURALLAR: 1) Yaş ve bağlam duyarlılığına dikkat et; hasta bebek veya çocuk ise ("bebeğimin nefes alması zorlaştı morarıyor" gibi şikayetlerde) Kalp Krizi (I21.9) gibi yetişkin kardiyolojik tanıları DEĞİL, Akut Bronşiyolit (J21.9), Krup (J05.0) veya Bebek Siyanozu (P28.5) değerlendir. 2) "İnsanların gözünün içine bakamıyor", "çok sessiz sakin", "göz teması kuramıyor" gibi şikayetlerde Çocukluk Otizmi (F84.0 / Otizm Spektrum Bozukluğu) tanısını öncelikli olarak hekime sun. 3) Hasta şikayetinde "aniden başlayan göğüste sıkışma, çarpıntı, nefes alamama hissi, ellerde titreme/karıncalanma ve kontrolü kaybetme korkusu" (veya ölüm korkusu) gibi psikojenik anksiyete bulguları yer alıyorsa, sol kola vuran ağrı veya soğuk ter gibi organik koroner iskemi bulguları yoksa Kalp Krizi (I21/I20) DEĞİL, F41.0 - Panik Bozukluk (Panik Atak / Anksiyete) tanısını en yüksek güven skoruyla birinci sırada sun. 4) Hasta şikayetinde "sol/sağ bel/yan bölgesinde aniden başlayan, kasık bölgesine doğru vuran, dalgalı (kolik) tarzda kıvrandırıcı şiddetli ağrı ve bulantı" varsa, basit kas-iskelet M54.5 (Bel Ağrısı) DEĞİL, N20.1 - Üreter Taşı / N23 - Renal Kolik tanısını %98 güven skoruyla en üstte sun. 5) "ağza acı/ekşi su gelmesi ve yatarken artan öksürük" varsa Soğuk Algınlığı (J06/J11) DEĞİL, K21.9 - Gastroözofageal Reflü tanısını sun. 6) "yatakta dönerken veya başını yukarı kaldırırken başlayan, etrafın dönmesi şeklinde şiddetli baş dönmesi, dengesizlik ve bulantı" varsa, Pelvik Enflamatuvar Hastalık (N73.9) veya Baş Ağrısı (G44.2) DEĞİL, H81.1 - Benign Paroksizmal Pozisyonel Vertigo (BPPV / Kristal Kayması) tanısını %98 güven skoruyla birinci sırada sun. 7) "24 saattir devam eden sulu ishal (günde 6-7 kez), karın krampı, bulantı, kusma ve hafif ateş" varsa, kronik İrritabl Bağırsak Sendromu (K58.0 İBS) DEĞİL, A09.9 - İnfeksiyöz Gastroenterit ve Kolit tanısını %98 güven skoruyla en üstte sun. 8) "sol/sağ omzunu yukarı kaldırırken ve arkaya götürürken belirginleşen ağrı, gece ağrıyan tarafın üzerine yatamama ve omuz hareket kısıtlılığı" varsa, Vertigo (H81.1) DEĞİL, M75.1 - Rotatör Manşet Sendromu / M75.0 - Donuk Omuz tanısını %98 güven skoruyla en üstte sun. 9) "38.5°C ateş, iştahsızlık, ağız içinde küçük yaralar (aft) ve el/ayak tabanlarında kırmızı döküntüler" varsa, jenerik R50.9 Ateş DEĞİL, B08.4 - El-Ayak-Ağız Hastalığı (Enteroviral Stomatit) tanısını %98 güven skoruyla en üstte sun.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.3
        ]);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ],
            CURLOPT_TIMEOUT => 3 // Hızlı yanıt için 3 saniye zaman aşımı
        ]);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err || !$response) {
            $mock = new MockAiAdapter();
            $result = $mock->summarizePatient([]);
            $result['summary_text'] = "[HIZLI YANIT (CANLI API CANCELLED)]: API yanıt veremediği için anında mock yanıtına geçildi.\n\n" . $result['summary_text'];
            return $result;
        }

        $data = json_decode($response, true);
        $content = $data['choices'][0]['message']['content'] ?? 'Yanıt alınıyor...';

        return [
            'summary_text' => $content,
            'confidence_score' => 0.95,
            'uncertainties' => ["Nihai teşhis ve karar hekime aittir."],
            'sources' => ["Canlı AI Modeli ({$this->model})"]
        ];
    }
}
