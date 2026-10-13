<?php

namespace App\Modules\Integrations\Contracts;

interface ReportAdapterInterface
{
    /**
     * Tıbbi raporu harici kamu/SGK servisine (e-Rapor) gönderir.
     */
    public function submitReport(array $reportData): array;

    /**
     * Oluşturulmuş bir raporu iptal eder.
     */
    public function cancelReport(string $reportNumber, string $reason): array;

    /**
     * Raporun kamu servisindeki durumunu sorgular.
     */
    public function getReportStatus(string $reportNumber): array;
}