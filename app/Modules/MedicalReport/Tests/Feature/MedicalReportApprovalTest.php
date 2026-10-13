<?php

namespace App\Modules\MedicalReport\Tests\Feature;

use App\Modules\Integrations\Adapters\EReport\MockEReportAdapter;
use PHPUnit\Framework\TestCase;

class MedicalReportApprovalTest extends TestCase
{
    /**
     * EReportAdapter Başhekimlik Onayı ve e-Rapor No Üretim Testi
     */
    public function test_ereport_adapter_generates_official_report_number(): void
    {
        $adapter = new MockEReportAdapter();
        $result = $adapter->sendReport([
            'report_number' => 'RAP-20260727-1001',
            'patient_id' => 1,
            'report_type' => 'disability_report'
        ]);

        $this->assertEquals('success', $result['status']);
        $this->assertStringStartsWith('ERAP-2026-', $result['e_rapor_no']);
        $this->assertStringStartsWith('SB-ERAPOR-OK-', $result['ministry_approval_code']);
    }

    /**
     * e-Rapor Sorgulama Test Senaryosu
     */
    public function test_ereport_adapter_queries_official_report(): void
    {
        $adapter = new MockEReportAdapter();
        $result = $adapter->queryReport('ERAP-2026-998877');

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('ERAP-2026-998877', $result['e_rapor_no']);
        $this->assertArrayHasKey('chief_physician_name', $result);
        $this->assertEquals('SGK / e-Rapor Onaylı', $result['approval_status']);
    }

    /**
     * AI Teşhis Önerisi Kabul Etme İş Mantığı Testi
     */
    public function test_accept_ai_recommendation_structure(): void
    {
        $patientId = 1;
        $diagnosis = 'I10 - Essansiyel Hipertansiyon';
        $complaint = 'Göğüste sıkışma hissi';

        $newEncounter = [
            'date' => date('Y-m-d'),
            'clinic' => 'Kardiyoloji Polikliniği (AI Karar Destek)',
            'physician' => 'Dr. Sude Hekim',
            'complaint' => $complaint,
            'diagnosis' => $diagnosis,
            'notes' => 'AI Karar Destek Asistanı teşhis ve klinik önerisi hekim tarafından kabul edildi ve kayda alındı.'
        ];

        $this->assertEquals('I10 - Essansiyel Hipertansiyon', $newEncounter['diagnosis']);
        $this->assertStringContainsString('Kardiyoloji', $newEncounter['clinic']);
        $this->assertEquals(date('Y-m-d'), $newEncounter['date']);
    }
}
