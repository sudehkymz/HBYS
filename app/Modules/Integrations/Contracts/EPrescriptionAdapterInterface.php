<?php

namespace App\Modules\Integrations\Contracts;

interface EPrescriptionAdapterInterface
{
    /**
     * Reçeteyi SGK E-Reçete web servisine iletir ve onaylı E-Reçete No döner.
     */
    public function sendPrescription(array $prescriptionData): array;

    /**
     * E-Reçete No ile SGK servisinden reçete sorgular.
     */
    public function queryPrescription(string $ereceptaNo): array;
}
