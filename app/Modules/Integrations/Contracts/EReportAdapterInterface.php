<?php

namespace App\Modules\Integrations\Contracts;

interface EReportAdapterInterface
{
    /**
     * Tıbbi raporu Sağlık Bakanlığı e-Rapor servisine iletir ve e-Rapor numarası üretir.
     */
    public function sendReport(array $reportData): array;

    /**
     * e-Rapor numarası ile rapor durumunu ve detaylarını sorgular.
     */
    public function queryReport(string $eRaporNo): array;
}
