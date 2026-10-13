<?php

namespace App\Modules\Integrations\Contracts;

interface AiAdapterInterface
{
    /**
     * Hastanın geçmişini ve sağlık durumunu özetler.
     */
    public function summarizePatient(array $patientData): array;

    /**
     * Muayene notu / Epikriz taslağı oluşturur.
     */
    public function generateClinicalNoteDraft(array $encounterData): array;

    /**
     * Klinik karar desteği ve uyarılar sunar (tetkik, ilaç etkileşimi, takip).
     */
    public function generateDecisionSupport(array $clinicalData): array;
}
