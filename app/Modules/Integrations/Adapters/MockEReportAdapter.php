<?php

namespace App\Modules\Integrations\Adapters;

use App\Modules\Integrations\Contracts\ReportAdapterInterface;

class MockEReportAdapter implements ReportAdapterInterface
{
    public function submitReport(array $reportData): array
    {
        $reportType = $reportData['report_type'] ?? 'Genel Tıbbi Rapor';
        $reportNumber = 'ERAPOR-' . strtoupper(bin2hex(random_bytes(4))) . '-' . date('Y');

        return [
            'status' => 'APPROVED',
            'transaction_id' => 'TX-REPORT-' . time(),
            'report_number' => $reportNumber,
            'report_type' => $reportType,
            'submitted_at' => now()->toIso8601String(),
            'ministry_response_code' => '200_SUCCESS',
            'message' => "Tıbbi rapor ({$reportType}) Sağlık Bakanlığı e-Rapor sistemine başarıyla kaydedildi.",
        ];
    }

    public function cancelReport(string $reportNumber, string $reason): array
    {
        return [
            'status' => 'CANCELLED',
            'report_number' => $reportNumber,
            'cancelled_at' => now()->toIso8601String(),
            'reason' => $reason,
            'message' => "{$reportNumber} numaralı e-Rapor iptal edildi.",
        ];
    }

    public function getReportStatus(string $reportNumber): array
    {
        return [
            'status' => 'ACTIVE',
            'report_number' => $reportNumber,
            'query_timestamp' => now()->toIso8601String(),
            'valid_until' => now()->addMonths(6)->toDateString(),
            'message' => "Rapor sistemde aktif olarak görünmektedir.",
        ];
    }
}