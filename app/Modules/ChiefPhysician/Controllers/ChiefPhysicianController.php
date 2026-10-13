<?php

namespace App\Modules\ChiefPhysician\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\MedicalReport\Models\MedicalReport;
use App\Modules\MedicalReport\Services\MedicalReportService;

class ChiefPhysicianController extends Controller
{
    protected MedicalReportService $medicalReportService;

    public function __construct(MedicalReportService $medicalReportService)
    {
        $this->medicalReportService = $medicalReportService;
    }

    public function index(Request $request)
    {
        // 🔒 SADECE VE SADECE BAŞHEKİM (chief_physician) VE ADMİN GİREBİLİR
        if (auth()->check() && !auth()->user()->hasRole(['admin', 'chief_physician'])) {
            return redirect()->route('dashboard')->with('error', 'Bu sayfaya erişim yetkiniz bulunmamaktadır. Yalnızca Başhekim (Chief Physician) yetkisine sahip kullanıcılar girebilir.');
        }

        // 1. Resmi Doktor & SGK e-Raporları (Yapay Zekâ Röntgen & Lab Analiz Raporları Hariç Tutulur)
        $reports = MedicalReport::with('approvals')
            ->where('report_type', 'NOT LIKE', '%Yapay Zekâ%')
            ->where('report_type', 'NOT LIKE', '%Röntgen%')
            ->where('report_type', 'NOT LIKE', '%Lab%')
            ->latest()
            ->get();

        foreach ($reports as $report) {
            $report->ai_analysis = $this->medicalReportService->getChiefPhysicianAiAnalysis($report);
        }

        $pendingReports = $reports->where('chief_physician_approval_status', 'pending');
        $approvedReports = $reports->where('chief_physician_approval_status', 'approved');
        $rejectedReports = $reports->where('chief_physician_approval_status', 'rejected');

        $pendingCount = $pendingReports->count();
        $approvedCount = $approvedReports->count();
        $totalCount = $reports->count();

        // 2. Yatan Hastalar & Yatak Doluluk Metrikleri
        $inpatientAdmissions = session('admissions', []);
        $allBeds = session('beds', []);
        $totalBedsCount = count($allBeds) > 0 ? count($allBeds) : 100;
        $occupiedBedsCount = count(array_filter($allBeds, fn($b) => ($b['status'] ?? '') === 'dolu')) ?: count($inpatientAdmissions);
        $occupancyRate = round(($occupiedBedsCount / $totalBedsCount) * 100);

        return view('modules.chief_physician.index', compact(
            'reports',
            'pendingReports',
            'approvedReports',
            'rejectedReports',
            'pendingCount',
            'approvedCount',
            'totalCount',
            'inpatientAdmissions',
            'totalBedsCount',
            'occupiedBedsCount',
            'occupancyRate'
        ));
    }

    public function approveReport(Request $request, $id)
    {
        $report = MedicalReport::findOrFail($id);
        $report->chief_physician_approval_status = 'approved';
        $report->e_rapor_no = 'SGK-E-' . date('Ymd') . '-' . rand(1000, 9999);
        $report->save();

        return redirect()->route('chief_physician.index')->with('success', "{$report->report_number} numaralı e-Rapor Başhekim tarafından onaylandı.");
    }

    public function rejectReport(Request $request, $id)
    {
        $report = MedicalReport::findOrFail($id);
        $report->chief_physician_approval_status = 'rejected';
        $report->save();

        return redirect()->route('chief_physician.index')->with('success', "{$report->report_number} numaralı e-Rapor reddedildi.");
    }
}
