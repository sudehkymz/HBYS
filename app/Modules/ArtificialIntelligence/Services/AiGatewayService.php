<?php

namespace App\Modules\ArtificialIntelligence\Services;

use App\Modules\ArtificialIntelligence\Models\AiRequest;
use App\Modules\ArtificialIntelligence\Models\AiResponse;
use App\Modules\Integrations\Adapters\AI\LiveOpenAiAdapter;
use App\Modules\Integrations\Adapters\AI\MockAiAdapter;
use App\Modules\Integrations\Contracts\AiAdapterInterface;

class AiGatewayService
{
    protected DataMaskingService $maskingService;
    protected AiAdapterInterface $aiAdapter;
    protected MockPatientDataProvider $mockPatientDataProvider;

    public function __construct(DataMaskingService $maskingService, MockPatientDataProvider $mockPatientDataProvider)
    {
        $this->maskingService = $maskingService;
        $this->mockPatientDataProvider = $mockPatientDataProvider;
        
        // Eğer env veya config üzerinde OPENAI_API_KEY tanımlı ise canlı API adaptörünü kullanır, yoksa Mock adaptörünü kullanır.
        $apiKey = env('OPENAI_API_KEY', '');
        if (!empty($apiKey)) {
            $this->aiAdapter = new LiveOpenAiAdapter();
        } else {
            $this->aiAdapter = new MockAiAdapter();
        }
    }

    /**
     * AI Gateway üzerinden hasta özeti oluşturur.
     */
    public function generatePatientSummary(array $rawPatientData = [], ?int $userId = null, ?int $patientId = null): array
    {
        if (empty($rawPatientData)) {
            $rawPatientData = $this->mockPatientDataProvider->getVirtualPatientProfile($patientId ?? 1);
        }

        // 1. Veri Azaltma ve Maskeleme
        $maskedData = $this->maskingService->maskPatientData($rawPatientData);

        // 2. İstek Kaydı Oluşturma (AI Request Log)
        $aiRequest = AiRequest::create([
            'user_id' => $userId,
            'patient_id' => $patientId,
            'request_type' => 'patient_summary',
            'model_name' => get_class($this->aiAdapter),
            'anonymized_input' => json_encode($maskedData, JSON_UNESCAPED_UNICODE),
            'status' => 'completed'
        ]);

        // 3. AI Adaptör Çağrısı
        $result = $this->aiAdapter->summarizePatient($maskedData);

        // 4. Yanıt Kaydı Oluşturma (AI Response Log)
        $aiResponse = AiResponse::create([
            'ai_request_id' => $aiRequest->id,
            'raw_response' => json_encode($result, JSON_UNESCAPED_UNICODE),
            'summary_text' => $result['summary_text'] ?? '',
            'clinical_suggestions_json' => $result['suggestions'] ?? [],
            'confidence_score' => $result['confidence_score'] ?? 0.95,
            'uncertainties_json' => $result['uncertainties'] ?? []
        ]);

        return [
            'request_id' => $aiRequest->id,
            'response_id' => $aiResponse->id,
            'summary_text' => $aiResponse->summary_text,
            'confidence_score' => $aiResponse->confidence_score,
            'uncertainties' => $aiResponse->uncertainties_json,
            'suggestions' => $aiResponse->clinical_suggestions_json,
            'model_info' => get_class($this->aiAdapter),
            'created_at' => $aiResponse->created_at->format('d.m.Y H:i')
        ];
    }

    /**
     * AI Gateway üzerinden Klinik Not Taslağı (Epikriz) oluşturur.
     */
    public function generateClinicalNote(array $rawEncounterData, ?int $userId = null, ?int $patientId = null): array
    {
        $maskedData = $this->maskingService->maskPatientData($rawEncounterData);

        $aiRequest = AiRequest::create([
            'user_id' => $userId,
            'patient_id' => $patientId,
            'request_type' => 'clinical_note',
            'model_name' => get_class($this->aiAdapter),
            'anonymized_input' => json_encode($maskedData, JSON_UNESCAPED_UNICODE),
            'status' => 'completed'
        ]);

        $result = $this->aiAdapter->generateClinicalNoteDraft($maskedData);

        $aiResponse = AiResponse::create([
            'ai_request_id' => $aiRequest->id,
            'raw_response' => json_encode($result, JSON_UNESCAPED_UNICODE),
            'summary_text' => $result['summary_text'] ?? '',
            'clinical_suggestions_json' => $result['suggestions'] ?? [],
            'confidence_score' => $result['confidence_score'] ?? 0.92,
            'uncertainties_json' => $result['uncertainties'] ?? []
        ]);

        return [
            'request_id' => $aiRequest->id,
            'response_id' => $aiResponse->id,
            'summary_text' => $aiResponse->summary_text,
            'confidence_score' => $aiResponse->confidence_score,
            'uncertainties' => $aiResponse->uncertainties_json,
            'model_info' => get_class($this->aiAdapter),
            'created_at' => $aiResponse->created_at->format('d.m.Y H:i')
        ];
    }

    /**
     * AI Gateway üzerinden Klinik Karar Desteği ve Uyarılar üretir.
     */
    public function generateDecisionSupport(array $rawClinicalData, ?int $userId = null, ?int $patientId = null): array
    {
        $maskedData = $this->maskingService->maskPatientData($rawClinicalData);

        $aiRequest = AiRequest::create([
            'user_id' => $userId,
            'patient_id' => $patientId,
            'request_type' => 'decision_support',
            'model_name' => get_class($this->aiAdapter),
            'anonymized_input' => json_encode($maskedData, JSON_UNESCAPED_UNICODE),
            'status' => 'completed'
        ]);

        $result = $this->aiAdapter->generateDecisionSupport($maskedData);

        $aiResponse = AiResponse::create([
            'ai_request_id' => $aiRequest->id,
            'raw_response' => json_encode($result, JSON_UNESCAPED_UNICODE),
            'summary_text' => $result['summary_text'] ?? '',
            'clinical_suggestions_json' => $result['suggestions'] ?? [],
            'confidence_score' => $result['confidence_score'] ?? 0.94,
            'uncertainties_json' => $result['uncertainties'] ?? []
        ]);

        return [
            'request_id' => $aiRequest->id,
            'response_id' => $aiResponse->id,
            'summary_text' => $aiResponse->summary_text,
            'confidence_score' => $aiResponse->confidence_score,
            'suggestions' => $aiResponse->clinical_suggestions_json,
            'uncertainties' => $aiResponse->uncertainties_json,
            'model_info' => get_class($this->aiAdapter),
            'created_at' => $aiResponse->created_at->format('d.m.Y H:i')
        ];
    }

    /**
     * AI Gateway üzerinden Seçilen ICD-10 Tanısı, SGK Durumu ve İstirahat Gün Sayısına göre Medikal Rapor İçeriği üretir.
     */
    public function generateMedicalReportDraft(array $data, ?int $userId = null, ?int $patientId = null): array
    {
        $patientProfile = $this->mockPatientDataProvider->getVirtualPatientProfile($patientId ?? 1);
        
        $diagnosis = $data['diagnosis'] ?? 'I10 - Esansiyel Hipertansiyon';
        $reportType = $data['report_type'] ?? 'Ayaktan İstirahat Raporu';
        $restDays = (int) ($data['rest_days'] ?? 5);
        $patientName = trim(($patientProfile['first_name'] ?? 'Ahmet') . ' ' . ($patientProfile['last_name'] ?? 'Yılmaz'));
        $nationalId = $patientProfile['national_id'] ?? '12345678901';
        $sgkType = $patientProfile['sgk_type'] ?? 'SGK 4/a (SSK)';

        $reportText = "T.C. SAĞLIK BAKANLIĞI VE SGK KANUNİ MEVZUATINA UYGUN TIBBİ RAPOR AÇIKLAMASI:\n\n" .
            "Hastanın (Ad Soyad: {$patientName}, T.C. No: {$nationalId}, Sosyal Güvenlik Statüsü: {$sgkType}) Polikliniğimizde yapılan klinik muayene, fiziksel bulgular ve tetkik değerlendirmesi neticesinde '{$diagnosis}' tanısı verilmiştir.\n\n" .
            "Hastanın mevcut sağlık durumu ve SGK kapsama şartları değerlendirilerek, {$reportType} kapsamında {$restDays} ({$this->convertNumberToTurkishWords($restDays)}) gün süreyle ayaktan istirahati, günlük aktivitelerini kısıtlaması ve hekim tavsiyelerine uygun ilaç tedavisini sürdürmesi tıbben uygun görülmüştür.\n\n" .
            "Rapor Bitiş Tarihi: " . date('d.m.Y', strtotime("+{$restDays} days")) . " tarihinde hastanın durumu hekim tarafından yeniden değerlendirilecektir.";

        return [
            'status' => 'success',
            'report_content' => $reportText,
            'diagnosis' => $diagnosis,
            'report_type' => $reportType,
            'rest_days' => $restDays,
            'sgk_type' => $sgkType,
            'patient_name' => $patientName,
            'created_at' => date('d.m.Y H:i')
        ];
    }

    protected function convertNumberToTurkishWords(int $number): string
    {
        $words = [
            1 => 'bir', 2 => 'iki', 3 => 'üç', 4 => 'dört', 5 => 'beş',
            6 => 'altı', 7 => 'yedi', 8 => 'sekiz', 9 => 'dokuz', 10 => 'on',
            14 => 'on dört', 15 => 'on beş', 20 => 'yirmi', 30 => 'otuz'
        ];
        return $words[$number] ?? (string)$number;
    }
}