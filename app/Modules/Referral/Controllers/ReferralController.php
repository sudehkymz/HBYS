<?php

namespace App\Modules\Referral\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Referral\Models\Referral;
use App\Modules\Referral\Services\ReferralService;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Organization\Models\Clinic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReferralController extends Controller
{
    protected ReferralService $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    /**
     * Sevk Paneli ve Sevk Listesi
     */
    public function index(Request $request): View
    {
        $type   = $request->input('type');
        $status = $request->input('status');

        $data = $this->referralService->getReferralDashboardData($type, $status);
        $patients = Patient::select(['id', 'first_name', 'last_name', 'national_id'])->orderBy('first_name')->get();
        $doctors  = Doctor::select(['id', 'name', 'specialty'])->orderBy('name')->get();
        $clinics  = Clinic::select(['id', 'name'])->orderBy('name')->get();

        return view('modules.referral.index', array_merge($data, [
            'selectedType' => $type,
            'selectedStatus' => $status,
            'patients' => $patients,
            'doctors' => $doctors,
            'clinics' => $clinics,
        ]));
    }

    /**
     * Yeni Sevk Kaydı Ekranı
     */
    public function create(Request $request): View
    {
        $patients = Patient::select(['id', 'first_name', 'last_name', 'national_id'])->orderBy('first_name')->get();
        $doctors  = Doctor::select(['id', 'name', 'specialty'])->orderBy('name')->get();
        $clinics  = Clinic::select(['id', 'name'])->orderBy('name')->get();
        $selectedPatientId = $request->input('patient_id');

        return view('modules.referral.create', compact('patients', 'doctors', 'clinics', 'selectedPatientId'));
    }

    /**
     * Sevk Kaydetme
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'          => 'required|exists:patients,id',
            'referring_doctor_id' => 'nullable|exists:doctors,id',
            'referral_type'       => 'required|in:internal,external',
            'target_clinic_id'    => 'required_if:referral_type,internal|nullable|exists:clinics,id',
            'target_hospital'     => 'required_if:referral_type,external|nullable|string|max:200',
            'reason'              => 'required|string',
            'transport_type'      => 'required|in:ambulance,self',
        ]);

        $referral = $this->referralService->createReferral($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$referral->patient->full_name} isimli hasta için #{$referral->referral_code} sevk kaydı oluşturuldu.",
                'referral' => $referral
            ]);
        }

        return redirect()->route('referrals.index')
            ->with('success', "{$referral->patient->full_name} isimli hasta için #{$referral->referral_code} sevk kaydı oluşturuldu.");
    }

    /**
     * Sevk Durumunu Güncelleme
     */
    public function updateStatus(Request $request, Referral $referral): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,transferred,completed,cancelled',
        ]);

        $this->referralService->updateStatus($referral, $validated['status']);

        return redirect()->route('referrals.index')
            ->with('success', "#{$referral->referral_code} kodlu sevk durumu '{$referral->status_label}' olarak güncellendi.");
    }
}
