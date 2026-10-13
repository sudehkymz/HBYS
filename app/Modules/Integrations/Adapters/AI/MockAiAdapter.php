<?php

namespace App\Modules\Integrations\Adapters\AI;

use App\Modules\Integrations\Contracts\AiAdapterInterface;

class MockAiAdapter implements AiAdapterInterface
{
    public function summarizePatient(array $patientData): array
    {
        $name = trim(($patientData['first_name'] ?? '') . ' ' . ($patientData['last_name'] ?? ''));
        if (empty($name)) $name = 'Hasta (Anonim)';

        $gender = $patientData['gender'] ?? 'Erkek';
        $diseases = implode(', ', $patientData['chronic_diseases'] ?? ['Tıbbi Kayıt Yetersiz']);
        $allergies = implode(', ', $patientData['allergies'] ?? ['Yok']);
        $meds = implode(', ', array_column($patientData['medication_history'] ?? [], 'drug_name'));
        if (empty($meds)) $meds = 'Aktif İlaç Kaydı Yok';

        $labsStr = '';
        foreach ($patientData['lab_results'] ?? [] as $lab) {
            $labsStr .= "{$lab['test_name']}: {$lab['value']} {$lab['unit']} ({$lab['status']}), ";
        }
        $labsStr = rtrim($labsStr, ', ');

        return [
            'summary_text' => "KLİNİK HASTA ÖZETİ ($name):\n\n" .
                              "• Demografik & Cinsiyet: $gender | Kan Grubu: " . ($patientData['blood_type'] ?? 'A Rh+') . "\n" .
                              "• Takipçi Poliklinik: Kardiyoloji Polikliniği\n" .
                              "• Kronik Tanıları: $diseases\n" .
                              "• Alerji Profili: $allergies\n" .
                              "• Aktif İlaçları: $meds\n" .
                              "• Son Laboratuvar Sonuçları: $labsStr\n\n" .
                              "AI Değerlendirmesi: Hasta klinik takipli olup, aktif tanıları ve ilaç kullanım geçmişi yukarıdaki gibidir. " .
                              "Son muayene ve lab değerlerine göre tedavi planı güncellenmelidir.",
            'confidence_score' => 0.96,
            'uncertainties' => [
                "Hasta özgeçmişindeki dış merkez kayıtları henüz entegre edilmedi.",
                "Eczane ilaç kullanım uyum verisi doğrulanmalı."
            ],
            'sources' => [
                "Hastane EHR Veritabanı ($name Klinik Dosyası)",
                "Laboratuvar LIS Sistemi",
                "E-Reçete İlaç Takip Sistemi"
            ]
        ];
    }

    public function generateClinicalNoteDraft(array $encounterData): array
    {
        $name = trim(($encounterData['first_name'] ?? '') . ' ' . ($encounterData['last_name'] ?? ''));
        if (empty($name)) $name = 'Hasta (Anonim)';

        $diseases = implode(', ', $encounterData['chronic_diseases'] ?? ['Rutin Muayene']);
        $vitals = $encounterData['vitals'] ?? [];
        $bp = $vitals['blood_pressure'] ?? '120/80 mmHg';
        $pulse = $vitals['pulse'] ?? '80 bpm';
        $spo2 = $vitals['oxygen_saturation'] ?? '%98';

        $encounterNotes = $encounterData['recent_encounters'][0]['notes'] ?? 'Hastanın klinik muayenesi tamamlandı.';
        $complaint = $encounterData['recent_encounters'][0]['complaint'] ?? 'Genel kontrol';

        return [
            'summary_text' => "HASTA MUAYENE VE EPİKRİZ TASLAĞI ($name):\n\n" .
                              "Şikayet & Anamnez: $complaint. Bilinen Kronik Tanıları: $diseases.\n" .
                              "Fizik Muayene / Vital Bulgular: Kan Basıncı: $bp, Nabız: $pulse, SpO2: $spo2.\n" .
                              "Hekim Klinik Değerlendirmesi: $encounterNotes\n\n" .
                              "Önerilen Tedavi ve Takip: Protokol rehberine uygun olarak hastaya bilgilendirme yapıldı, ilaç reçetesi düzenlendi ve kontrol randevusu planlandı.",
            'confidence_score' => 0.93,
            'uncertainties' => [
                "Fizik muayene bulguları sorumlu hekim tarafından onaylanmalıdır."
            ],
            'sources' => [
                "Poliklinik Muayene Formu",
                "SUT ve Klinik Uygulama Kılavuzları"
            ]
        ];
    }

    public function generateDecisionSupport(array $clinicalData): array
    {
        $name = trim(($clinicalData['first_name'] ?? '') . ' ' . ($clinicalData['last_name'] ?? ''));
        if (empty($name)) $name = 'Hasta (Anonim)';

        $allergies = implode(', ', $clinicalData['allergies'] ?? []);
        $pid = $clinicalData['patient_id'] ?? 1;

        if ($pid == 2) {
            // Ayşe Demir (Gebelik 24. Hafta)
            $text = "T.C. SAĞLIK BAKANLIĞI ICD-10 ENTEGRELİ KLİNİK KARAR DESTEK UYARILARI ($name):\n\n" .
                    "1. [🤰 O14.1 - Şiddetli Pre-Eklampsi / Gebelik Uyarısı]: Hasta 24. Hafta gebedir. NSAİİ (Aspirin/İbuprofen) grubu ilaçlar kontrendikedir.\n" .
                    "2. [⚠️ Z88.9 - Alerji Öyküsü]: Hastanın Aspirin ve NSAİİ grubu ilaçlara onaylı alerjisi bulunmaktadır.\n" .
                    "3. [🩸 D50.9 - Demir Eksikliği Anemisi, Tanımlanmamış]: Hemoglobin (10.5 g/dL) anemi düzeyindedir. Demir takviyesi önerilir.";
            $suggestions = [
                ['type' => 'pregnancy_warning', 'icd_code' => 'O14.1', 'icd_description' => 'Şiddetli Pre-Eklampsi', 'title' => 'Gebelik Kontrendikasyon Uyarısı (O14.1)', 'description' => 'NSAİİ grubu ilaç verilmemelidir.', 'severity' => 'critical'],
                ['type' => 'anemia_recommendation', 'icd_code' => 'D50.9', 'icd_description' => 'Demir Eksikliği Anemisi', 'title' => 'Anemi Takibi (D50.9)', 'description' => 'Demir takviyesi dozu gözden geçirilmelidir.', 'severity' => 'warning']
            ];
        } elseif ($pid == 3) {
            // Mehmet Kaya (KOAH & Kalp Yetmezliği)
            $text = "T.C. SAĞLIK BAKANLIĞI ICD-10 ENTEGRELİ KLİNİK KARAR DESTEK UYARILARI ($name):\n\n" .
                    "1. [🚨 I50.9 - Kalp Yetmezliği, Tanımlanmamış]: BNP Peptit değeri (450 pg/mL) kritik yüksek seviyededir. Kalp yetmezliği alevlenme riski mevcuttur.\n" .
                    "2. [🫁 J44.9 - Kronik Obstrüktif Akciğer Hastalığı (KOAH)]: SpO2 değeri %92 (düşük). Oksijen desteği ve bronkodilatör değerlendirilmelidir.\n" .
                    "3. [💊 N18.9 - Kronik Böbrek Yetmezliği, Tanımlanmamış]: Kreatinin 1.6 mg/dL yüksek. Diüretik dozajı böbrek fonksiyonuna göre ayarlanmalıdır.";
            $suggestions = [
                ['type' => 'critical_lab', 'icd_code' => 'I50.9', 'icd_description' => 'Kalp Yetmezliği, Tanımlanmamış', 'title' => 'Kritik BNP Yüksekliği (I50.9)', 'description' => 'Kardiyoloji konsültasyonu istenmelidir.', 'severity' => 'critical'],
                ['type' => 'oxygen_warning', 'icd_code' => 'J44.9', 'icd_description' => 'Kronik Obstrüktif Akciğer Hastalığı', 'title' => 'Düşük SpO2 / KOAH Uyarısı (J44.9)', 'description' => 'Göğüs hastalıkları takibi önerilir.', 'severity' => 'warning']
            ];
        } else {
            // Ahmet Yılmaz (Hipertansiyon & Diyabet)
            $text = "T.C. SAĞLIK BAKANLIĞI ICD-10 ENTEGRELİ KLİNİK KARAR DESTEK UYARILARI ($name):\n\n" .
                    "1. [⚠️ I10 - Esansiyel (Primer) Hipertansiyon]: Kan basıncı 140/90 mmHg sınırda. Düzenli tansiyon takibi gereklidir.\n" .
                    "2. [📈 E11.9 - İnsülin Bağımlı Olmayan Diyabetes Mellitüs]: HbA1c (%7.8) ve LDL Kolesterol (142 mg/dL) referans üst sınırının üzerindedir.\n" .
                    "3. [⚡ Z88.0 - Penisilin Alerjisi Öyküsü]: Hastanın Penasilin grubuna onaylı alerjisi mevcuttur.";
            $suggestions = [
                ['type' => 'allergy_warning', 'icd_code' => 'Z88.0', 'icd_description' => 'Penisilin Alerjisi Öyküsü', 'title' => 'Penisilin Alerji Uyarısı (Z88.0)', 'description' => 'Beta-laktam antibiyotiklerden kaçınınız.', 'severity' => 'warning'],
                ['type' => 'lab_warning', 'icd_code' => 'E11.9', 'icd_description' => 'İnsülin Bağımlı Olmayan Diyabetes Mellitüs', 'title' => 'Yüksek HbA1c ve Tip 2 Diyabet (E11.9)', 'description' => 'Diyet ve antidiyabetik tedavi gözden geçirilmelidir.', 'severity' => 'info']
            ];
        }

        return [
            'summary_text' => $text,
            'confidence_score' => 0.96,
            'suggestions' => $suggestions,
            'uncertainties' => ["Nihai klinik tanı T.C. Sağlık Bakanlığı ICD-10 standartlarında sorumlu hekim tarafından onaylanmalıdır."],
            'sources' => [
                "T.C. Sağlık Bakanlığı ICD-10 Standart Tanı Kataloğu",
                "Klinik Karar Destek Güvenlik Veritabanı"
            ]
        ];
    }
}
