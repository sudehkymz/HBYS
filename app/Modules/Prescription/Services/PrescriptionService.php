<?php

namespace App\Modules\Prescription\Services;

use App\Modules\Integrations\Adapters\EPrescription\MockEPrescriptionAdapter;
use App\Modules\Prescription\Models\Prescription;
use App\Modules\Prescription\Models\PrescriptionItem;
use Illuminate\Support\Str;

class PrescriptionService
{
    protected DrugSafetyService $drugSafetyService;
    protected MockEPrescriptionAdapter $ePrescriptionAdapter;

    public function __construct(DrugSafetyService $drugSafetyService, MockEPrescriptionAdapter $ePrescriptionAdapter)
    {
        $this->drugSafetyService = $drugSafetyService;
        $this->ePrescriptionAdapter = $ePrescriptionAdapter;
    }

    public function createPrescription(array $data): array
    {
        $prescriptionCode = 'REC-' . strtoupper(Str::random(8));
        $patientId = $data['patient_id'] ?? 1;
        $safetyWarnings = [];

        $prescription = Prescription::create([
            'prescription_code' => $prescriptionCode,
            'patient_id' => $patientId,
            'physician_id' => $data['physician_id'] ?? 1,
            'diagnosis_code' => $data['diagnosis_code'] ?? 'I10',
            'status' => 'draft',
            'notes' => $data['notes'] ?? ''
        ]);

        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                // Güvenlik ve İlaç Kontrolü (Alerji ve Aynı Etken Madde)
                $check = $this->drugSafetyService->checkDrugSafety($item['drug_name'], $patientId);
                if ($check['has_warnings']) {
                    $safetyWarnings = array_merge($safetyWarnings, $check['warnings']);
                }

                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'drug_name' => $item['drug_name'],
                    'barcode' => $item['barcode'] ?? '8699500000000',
                    'dosage' => $item['dosage'] ?? '500mg',
                    'frequency' => $item['frequency'] ?? '2x1',
                    'box_count' => $item['box_count'] ?? 1,
                    'usage_route' => $item['usage_route'] ?? 'oral'
                ]);
            }
        }

        return [
            'prescription' => $prescription,
            'warnings' => $safetyWarnings
        ];
    }

    public function sendToERecepta(Prescription $prescription): array
    {
        $itemsData = $prescription->items->map(fn($item) => [
            'name' => $item->drug_name,
            'dosage' => $item->dosage,
            'frequency' => $item->frequency
        ])->toArray();

        // EPrescriptionAdapter üzerinden SGK e-reçete kodu üretilir
        $adapterResult = $this->ePrescriptionAdapter->sendPrescription([
            'prescription_code' => $prescription->prescription_code,
            'patient_id' => $prescription->patient_id,
            'items' => $itemsData
        ]);

        $prescription->update([
            'is_erecepta_sent' => true,
            'erecepta_no' => $adapterResult['erecepta_no'],
            'status' => 'signed'
        ]);

        return array_merge($adapterResult, ['prescription' => $prescription]);
    }

    public function queryERecepta(string $ereceptaNo): array
    {
        return $this->ePrescriptionAdapter->queryPrescription($ereceptaNo);
    }
}
