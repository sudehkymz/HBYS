<?php

namespace App\Modules\Integrations\Adapters\EReport;

use App\Modules\Integrations\Contracts\EReportAdapterInterface;

class MockEReportAdapter implements EReportAdapterInterface
{
    public function sendReport(array $reportData): array
    {
        $eRaporNo = 'ERAP-' . date('Y') . '-' . rand(100000, 999999);

        return [
            'status' => 'success',
            'e_rapor_no' => $eRaporNo,
            'ministry_approval_code' => 'SB-ERAPOR-OK-' . rand(1000, 9999),
            'message' => 'Tıbbi Rapor Başhekimlik onayı sonrası e-Rapor sistemine (Sağlık Bakanlığı / SGK) başarıyla aktarıldı.',
            'timestamp' => date('d.m.Y H:i:s')
        ];
    }

    public function queryReport(string $eRaporNo): array
    {
        return [
            'status' => 'success',
            'e_rapor_no' => $eRaporNo,
            'patient_name' => 'A*** Y*****',
            'physician_name' => 'Dr. Mehmet Öz',
            'chief_physician_name' => 'Prof. Dr. Ahmet Başhekim',
            'report_type' => 'İş Göremezlik Raporu',
            'rest_days' => 5,
            'approval_status' => 'SGK / e-Rapor Onaylı'
        ];
    }
}
