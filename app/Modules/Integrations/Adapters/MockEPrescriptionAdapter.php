<?php

namespace App\Modules\Integrations\Adapters;

use App\Modules\Integrations\Contracts\PrescriptionAdapterInterface;

class MockEPrescriptionAdapter implements PrescriptionAdapterInterface
{
    public function sendPrescription(array $prescriptionData): array
    {
        $prescriptionCode = 'ERECEPT-' . strtoupper(bin2hex(random_bytes(3))) . '-' . date('Y');

        return [
            'status' => 'SENT',
            'prescription_code' => $prescriptionCode,
            'provizyon_no' => 'PRV-' . rand(100000, 999999),
            'sent_at' => now()->toIso8601String(),
            'medula_response' => '0000_SUCCESS',
            'message' => "E-reçete SGK MEDULA sistemine iletildi. Reçete Kodu: {$prescriptionCode}",
        ];
    }

    public function cancelPrescription(string $prescriptionCode, string $reason): array
    {
        return [
            'status' => 'CANCELLED',
            'prescription_code' => $prescriptionCode,
            'cancelled_at' => now()->toIso8601String(),
            'reason' => $reason,
            'message' => "{$prescriptionCode} kodlu e-Reçete MEDULA sisteminden iptal edildi.",
        ];
    }

    public function checkDrugInteractions(array $drugCodes): array
    {
        $warnings = [];
        if (count($drugCodes) > 1) {
            $warnings[] = [
                'type' => 'INTERACTION_WARNING',
                'severity' => 'MEDIUM',
                'message' => 'Seçilen ilaçlar arasında mide emilimi açısından zaman farkı bırakılması önerilir.',
                'drugs' => array_slice($drugCodes, 0, 2),
            ];
        }

        return [
            'status' => 'COMPLETED',
            'checked_at' => now()->toIso8601String(),
            'warnings' => $warnings,
        ];
    }
}
