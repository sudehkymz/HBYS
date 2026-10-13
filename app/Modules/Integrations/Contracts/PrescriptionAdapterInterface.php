<?php

namespace App\Modules\Integrations\Contracts;

interface PrescriptionAdapterInterface
{
    /**
     * E-reçeteyi SGK/MEDULA sistemine iletir ve e-reçete takip numarası alır.
     */
    public function sendPrescription(array $prescriptionData): array;

    /**
     * İletilen e-reçeteyi iptal eder.
     */
    public function cancelPrescription(string $prescriptionCode, string $reason): array;

    /**
     * İlaç etken maddeleri arasındaki etkileşimleri ve uyarıları sorgular.
     */
    public function checkDrugInteractions(array $drugCodes): array;
}
