<?php

namespace App\Modules\Integrations\Adapters;

use App\Modules\Integrations\Contracts\AiAdapterInterface;

class MockAiAdapter implements AiAdapterInterface
{
    private string $modelName = 'YebSoft-Clinical-AI-Mock';
    private string $modelVersion = 'v1.2.0-stub';

    public function generatePatientSummary(array $maskedPatientData): array
    {
        $ageGroup = $maskedPatientData['age_group'] ?? 'Yetişkin';
        $encountersCount = $maskedPatientData['encounters_count'] ?? 1;

        return [
            'status' => 'success',
            'model' => $this->modelName,
            'version' => $this->modelVersion,
            'confidence_score' => 0.94,
            'created_at' => now()->toIso8601String(),
            'summary' => "Hasta ({$ageGroup}) son 12 ay içerisinde {$encountersCount} başvuru gerçekleştirmiştir. Geçmiş tetkikler göz önüne alındığında düzenli kronik takip önerilmektedir.",
            'disclaimer' => 'Bu özet yapay zekâ karar desteği tarafından üretilmiştir. Nihai değerlendirme ve teşhis hekime aittir.',
            'sources' => ['Geçmiş Poliklinik Kayıtları', 'Laboratuvar Geçmişi'],
        ];
    }

    public function analyzeLabResults(array $maskedLabData): array
    {
        $metrics = $maskedLabData['metrics'] ?? [];
        $highlights = [];

        foreach ($metrics as $metric => $val) {
            if (isset($val['value'], $val['ref_high']) && $val['value'] > $val['ref_high']) {
                $highlights[] = "{$metric}: {$val['value']} {$val['unit']} (Yüksek - Referans: {$val['ref_high']})";
            }
        }

        return [
            'status' => 'success',
            'model' => $this->modelName,
            'version' => $this->modelVersion,
            'confidence_score' => 0.91,
            'created_at' => now()->toIso8601String(),
            'highlights' => $highlights ?: ['Laboratuvar değerlerinde belirgin sapma tespit edilmedi.'],
            'disclaimer' => 'Laboratuvar sonuç analizi hekimin klinik yorumu yerine geçmez.',
        ];
    }

    public function getClinicalSuggestions(array $maskedClinicalContext): array
    {
        return [
            'status' => 'success',
            'model' => $this->modelName,
            'version' => $this->modelVersion,
            'created_at' => now()->toIso8601String(),
            'suggested_examinations' => [
                'Açlık Kan Şekeri Kontrolü',
                'Kardiyoloji Kontrol Muayenesi (15 Gün Sonra)',
                'HbA1c Takibi'
            ],
            'potential_warnings' => [
                'Son 3 ölçümde tansiyon hafif yüksek seyretmektedir.'
            ],
            'disclaimer' => 'Klinik öneriler kılavuzlar doğrultusunda bilgi amaçlı üretilmiştir.',
        ];
    }

    public function generateClinicalNoteDraft(array $maskedEncounterData): array
    {
        $complaint = $maskedEncounterData['complaint'] ?? 'Belirtilmedi';

        return [
            'status' => 'success',
            'model' => $this->modelName,
            'version' => $this->modelVersion,
            'created_at' => now()->toIso8601String(),
            'draft_note' => "HASTA ANAMNEZ VE KLİNİK ÖZET TASLAĞI:\nHasta {$complaint} şikayeti ile başvurmuştur. Genel durumu orta-iyi. Sistem sorgulamasında ek akut patoloji saptanmadı.",
            'disclaimer' => 'Taslak metin hekim tarafından kontrol edilip onaylanmadan kaydedilemez ve imzalanamaz.',
        ];
    }
}