<?php

namespace App\Modules\Integrations\Adapters\EPrescription;

use App\Modules\Integrations\Contracts\EPrescriptionAdapterInterface;

class MockEPrescriptionAdapter implements EPrescriptionAdapterInterface
{
    public function sendPrescription(array $prescriptionData): array
    {
        $code = 'EREP-' . strtoupper(substr(md5(uniqid()), 0, 8));

        return [
            'status' => 'success',
            'erecepta_no' => $code,
            'sgk_approval_code' => 'SGK-OK-' . rand(1000, 9999),
            'message' => 'Reçete SGK E-Reçete sistemine başarıyla gönderildi ve elektronik olarak imzalandı.',
            'timestamp' => date('d.m.Y H:i:s')
        ];
    }

    public function queryPrescription(string $ereceptaNo): array
    {
        return [
            'status' => 'success',
            'erecepta_no' => $ereceptaNo,
            'patient_name' => 'A*** Y*****',
            'physician_name' => 'Dr. Mehmet Öz',
            'drugs' => [
                ['name' => 'Coraspin 100mg Tablet', 'box_count' => 1, 'dosage' => '1x1'],
                ['name' => 'Candesartan 16mg Tablet', 'box_count' => 1, 'dosage' => '1x1']
            ],
            'dispense_status' => 'Henüz Eczaneden Alınmadı (Bekliyor)'
        ];
    }
}
