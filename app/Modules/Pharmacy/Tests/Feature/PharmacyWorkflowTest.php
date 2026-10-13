<?php

namespace App\Modules\Pharmacy\Tests\Feature;

use App\Modules\Pharmacy\Services\PharmacyService;
use PHPUnit\Framework\TestCase;

class PharmacyWorkflowTest extends TestCase
{
    /**
     * Eczane 8 Aşamalı İlaç İstem Süreci Testi
     */
    public function test_pharmacy_workflow_has_eight_steps(): void
    {
        $pharmacyService = new PharmacyService();
        $workflow = $pharmacyService->getPharmacyWorkflowStatus('ORD-2026-001');

        $this->assertEquals('ORD-2026-001', $workflow['order_code']);
        $this->assertCount(8, $workflow['steps']);
    }

    /**
     * Eczacı Gizlilik ve Kısıtlı Erişim Kuralı Testi (Şartname Bölüm 24 & 30)
     */
    public function test_pharmacist_query_restricts_patient_full_history(): void
    {
        $pharmacyService = new PharmacyService();
        $result = $pharmacyService->queryByPharmacist('REC-123456', 'pharmacist');

        $this->assertEquals('restricted_pharmacist', $result['access_level']);
        $this->assertEquals('A*** Y*****', $result['patient_initials']);
        $this->assertArrayHasKey('drug_list', $result['allowed_info']);
        $this->assertEquals('Erişim Yetkisi Yok (Eczacı Kısıtlaması)', $result['restricted_fields']['patient_full_history']);
    }
}
