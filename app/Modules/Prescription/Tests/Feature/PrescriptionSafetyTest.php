<?php

namespace App\Modules\Prescription\Tests\Feature;

use App\Modules\ArtificialIntelligence\Services\MockPatientDataProvider;
use App\Modules\Integrations\Adapters\EPrescription\MockEPrescriptionAdapter;
use App\Modules\Prescription\Services\DrugSafetyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrescriptionSafetyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Alerji Uyarısı Test Senaryosu (Sanal Veri)
     */
    public function test_allergy_warning_triggered_for_allergic_drug(): void
    {
        $patientDataProvider = new MockPatientDataProvider();
        $safetyService = new DrugSafetyService($patientDataProvider);

        // Sanal hasta Penasilin alerjisine sahiptir
        $result = $safetyService->checkDrugSafety('Penoksilin 500mg', 1);

        $this->assertTrue($result['has_warnings']);
        $this->assertEquals('allergy_warning', $result['warnings'][0]['type']);
        $this->assertStringContainsString('KRİTİK ALERJİ UYARISI', $result['warnings'][0]['title']);
    }

    /**
     * Aynı Etken Madde Çift Doz Uyarısı Test Senaryosu
     */
    public function test_duplicate_active_ingredient_warning(): void
    {
        $patientDataProvider = new MockPatientDataProvider();
        $safetyService = new DrugSafetyService($patientDataProvider);

        // Sanal hasta zaten Candesartan 16mg kullanmaktadır. Atacand aynı etken maddelidir.
        $result = $safetyService->checkDrugSafety('Atacand 16mg Tablet', 1);

        $this->assertTrue($result['has_warnings']);
        $this->assertEquals('duplicate_ingredient', $result['warnings'][0]['type']);
        $this->assertStringContainsString('AYNI ETKEN MADDE UYARISI', $result['warnings'][0]['title']);
    }

    /**
     * EPrescriptionAdapter SGK E-Reçete Kodu Üretim Test Senaryosu
     */
    public function test_eprescription_adapter_generates_erecepta_code(): void
    {
        $adapter = new MockEPrescriptionAdapter();
        $result = $adapter->sendPrescription([
            'prescription_code' => 'REC-99887766',
            'patient_id' => 1
        ]);

        $this->assertEquals('success', $result['status']);
        $this->assertStringStartsWith('EREP-', $result['erecepta_no']);
        $this->assertStringStartsWith('SGK-OK-', $result['sgk_approval_code']);
    }

    /**
     * Çoklu İlaç Reçete Kaydı ve Hasta Geçmişi Senkronizasyonu Testi
     */
    public function test_multi_drug_prescription_saving_and_patient_history_sync(): void
    {
        $patientDataProvider = new MockPatientDataProvider();
        $safetyService = new DrugSafetyService($patientDataProvider);
        $adapter = new MockEPrescriptionAdapter();
        $prescriptionService = new \App\Modules\Prescription\Services\PrescriptionService($safetyService, $adapter);

        $result = $prescriptionService->createPrescription([
            'patient_id' => 1,
            'physician_id' => 1,
            'diagnosis_code' => 'I10 - Essansiyel Hipertansiyon',
            'notes' => 'Çoklu ilaç reçete testi',
            'items' => [
                ['drug_name' => 'Parol 500mg Tablet', 'dosage' => '3x1', 'box_count' => 2, 'usage_route' => 'oral'],
                ['drug_name' => 'Apranax Fort 550mg', 'dosage' => '2x1', 'box_count' => 1, 'usage_route' => 'oral'],
                ['drug_name' => 'Muscoril 4mg Kapsül', 'dosage' => '2x1', 'box_count' => 1, 'usage_route' => 'oral']
            ]
        ]);

        $prescription = $result['prescription'];
        $this->assertNotNull($prescription);
        $this->assertCount(3, $prescription->items);

        $sendResult = $prescriptionService->sendToERecepta($prescription);
        $this->assertTrue($prescription->fresh()->is_erecepta_sent);
        $this->assertNotNull($prescription->fresh()->erecepta_no);

        // Sanal hasta profilinde yeni yazılan ilaçların senkronize olduğunu doğrula
        $patient = $patientDataProvider->getVirtualPatientProfile(1);
        $medNames = array_column($patient['medication_history'], 'drug_name');

        $this->assertContains('Parol 500mg Tablet', $medNames);
        $this->assertContains('Apranax Fort 550mg', $medNames);
        $this->assertContains('Muscoril 4mg Kapsül', $medNames);
    }

    /**
     * Reçete Oluşturma ve Varsayılan Dozaj Kullanımı Testi
     */
    public function test_prescription_creation_with_dosage_only(): void
    {
        $patientDataProvider = new MockPatientDataProvider();
        $safetyService = new DrugSafetyService($patientDataProvider);
        $adapter = new MockEPrescriptionAdapter();

        $prescriptionService = new \App\Modules\Prescription\Services\PrescriptionService($safetyService, $adapter);
        $result = $prescriptionService->createPrescription([
            'patient_id' => 1,
            'diagnosis_code' => 'I10 - Essansiyel Hipertansiyon',
            'items' => [
                [
                    'drug_name' => 'Candesartan 16mg Tablet',
                    'dosage' => '1x1',
                    'box_count' => 1
                ]
            ]
        ]);

        $this->assertNotNull($result['prescription']);
        $this->assertStringStartsWith('REC-', $result['prescription']->prescription_code);
    }
}
