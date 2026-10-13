<?php

namespace App\Modules\Pharmacy\Controllers;

use App\Modules\Pharmacy\Services\PharmacyService;
use App\Modules\Prescription\Services\PrescriptionService;
use Illuminate\Http\Request;

class PharmacyController
{
    protected PharmacyService $pharmacyService;
    protected PrescriptionService $prescriptionService;

    public function __construct(PharmacyService $pharmacyService, PrescriptionService $prescriptionService)
    {
        $this->pharmacyService = $pharmacyService;
        $this->prescriptionService = $prescriptionService;
    }

    public function index(Request $request)
    {
        $activeTab = (string) $request->input('tab', 'dispensing');
        $prescriptionCode = (string) ($request->input('prescription_code') ?? '');
        $nationalId = (string) ($request->input('national_id') ?? '');
        $patientName = (string) ($request->input('patient_name') ?? '');
        $step = (int) $request->input('step', 0);

        $result = $this->pharmacyService->searchPrescriptionAndWorkflow($prescriptionCode, $nationalId, $patientName, $step);
        $prescription = $result['prescription'];
        $workflow = $result['workflow'];
        $hasSearchTerm = $result['has_search_term'] ?? false;

        // Yatan hasta varsayılan reçetesi (arama yapılmamışsa varsayılan kayıt)
        $inpatientCode = $prescriptionCode ?: 'EREP-2026-554422';
        $inpatientResult = $this->pharmacyService->searchPrescriptionAndWorkflow($inpatientCode, $nationalId, $patientName, $step);
        $inpatientPrescription = $inpatientResult['prescription'];
        $inpatientWorkflow = $inpatientResult['workflow'];

        // Stok & Depo Yönetimi verileri
        $items = $this->pharmacyService->getPharmacyInventory();
        $totalItems = count($items);
        $criticalCount = count(array_filter($items, fn($i) => $i['status'] === 'critical'));
        $expiringCount = count(array_filter($items, fn($i) => $i['status'] === 'expiring'));

        return view('modules.pharmacy.index', compact(
            'activeTab',
            'prescription',
            'workflow',
            'prescriptionCode',
            'nationalId',
            'patientName',
            'hasSearchTerm',
            'inpatientPrescription',
            'inpatientWorkflow',
            'items',
            'totalItems',
            'criticalCount',
            'expiringCount'
        ));
    }

    public function inpatient(Request $request)
    {
        $request->merge(['tab' => 'inpatient']);
        return $this->index($request);
    }

    public function searchInpatientAjax(Request $request)
    {
        $query = trim($request->input('q', ''));
        $results = $this->pharmacyService->searchInpatientPrescriptionsMany($query);

        return response()->json([
            'status' => 'success',
            'count' => count($results),
            'items' => $results
        ]);
    }

    public function inventory(Request $request)
    {
        $request->merge(['tab' => 'inventory']);
        return $this->index($request);
    }

    public function pharmacistQuery(Request $request)
    {
        return $this->index($request);
    }

    public function dispense(Request $request)
    {
        $prescriptionCode = $request->input('prescription_code', 'EREP-2026-998811');
        $receiptNo = 'FIS-' . date('Y') . '-' . rand(100000, 999999);
        $dispenseDate = date('d.m.Y H:i');

        session([
            "pharmacy_dispensed_{$prescriptionCode}" => true,
            "pharmacy_receipt_{$prescriptionCode}" => $receiptNo,
            "pharmacy_dispense_date_{$prescriptionCode}" => $dispenseDate
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reçete başarıyla karşılandı, SGK Medula düşümü yapıldı ve e-İrsaliye fişi oluşturuldu.',
            'receipt_no' => $receiptNo,
            'dispense_date' => $dispenseDate
        ]);
    }
}
