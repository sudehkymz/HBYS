<?php

namespace App\Modules\ArtificialIntelligence\Services;

class DataMaskingService
{
    /**
     * Hasta verilerini KVKK ve sağlık veri güvenliği standartlarına uygun şekilde anonimleştirir.
     */
    public function maskPatientData(array $data): array
    {
        $maskedData = $data;

        // Ad - Soyad Maskeleme
        if (isset($maskedData['first_name'])) {
            $maskedData['first_name'] = mb_substr($maskedData['first_name'], 0, 1) . '***';
        }
        if (isset($maskedData['last_name'])) {
            $maskedData['last_name'] = mb_substr($maskedData['last_name'], 0, 1) . '***';
        }
        if (isset($maskedData['name'])) {
            $parts = explode(' ', $maskedData['name']);
            $maskedParts = array_map(fn($p) => mb_substr($p, 0, 1) . '***', $parts);
            $maskedData['name'] = implode(' ', $maskedParts);
        }

        // TC Kimlik No Maskeleme (Örn: 12345678901 -> 123*******01)
        if (isset($maskedData['national_id'])) {
            $maskedData['national_id'] = substr($maskedData['national_id'], 0, 3) . '******' . substr($maskedData['national_id'], -2);
        }

        // Telefon Maskeleme
        if (isset($maskedData['phone'])) {
            $maskedData['phone'] = '+90 5** *** ** **';
        }

        // E-Posta Maskeleme
        if (isset($maskedData['email'])) {
            $maskedData['email'] = 'h***@***.com';
        }

        // Doğum tarihi verisini gizleyip sadece Yaş olarak tutma
        if (isset($maskedData['birth_date'])) {
            $maskedData['age'] = $this->calculateAge($maskedData['birth_date']);
            unset($maskedData['birth_date']);
        }

        return $maskedData;
    }

    protected function calculateAge(string $birthDate): int
    {
        try {
            $birth = new \DateTime($birthDate);
            $today = new \DateTime('today');
            return $birth->diff($today)->y;
        } catch (\Exception $e) {
            return 35; // varsayılan yaş
        }
    }
}
