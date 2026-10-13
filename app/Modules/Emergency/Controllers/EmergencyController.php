<?php

namespace App\Modules\Emergency\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Emergency\Models\EmergencyTriage;
use App\Modules\Emergency\Services\EmergencyService;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmergencyController extends Controller
{
    protected EmergencyService $emergencyService;

    public function __construct(EmergencyService $emergencyService)
    {
        $this->emergencyService = $emergencyService;
    }

    /**
     * Acil Servis Canlı Triyaj Paneli
     */
    public function index(): View
    {
        $data = $this->emergencyService->getEmergencyDashboardData();
        $doctors = Doctor::select(['id', 'name', 'specialty'])->orderBy('name')->get();
        $patients = Patient::select(['id', 'first_name', 'last_name', 'national_id'])->orderBy('first_name')->get();

        return view('modules.emergency.index', array_merge($data, ['doctors' => $doctors, 'patients' => $patients]));
    }

    /**
     * Yeni Acil Kayıt ve Triyaj Giriş Sayfası
     */
    public function create(Request $request): View
    {
        $patients = Patient::select(['id', 'first_name', 'last_name', 'national_id'])->orderBy('first_name')->get();
        $doctors  = Doctor::select(['id', 'name', 'specialty'])->orderBy('name')->get();
        $selectedPatientId = $request->input('patient_id');

        return view('modules.emergency.create', compact('patients', 'doctors', 'selectedPatientId'));
    }

    /**
     * Acil Kayıt ve Triyaj Sınıflandırmasını Kaydetme
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id'         => 'required|exists:patients,id',
            'triage_category'    => 'required|in:red,yellow,green',
            'chief_complaint'    => 'required|string',
            'blood_pressure'     => 'nullable|string',
            'pulse'              => 'nullable|numeric',
            'fever'              => 'nullable|numeric',
            'spo2'               => 'nullable|numeric',
            'assigned_doctor_id' => 'nullable|exists:doctors,id',
        ]);

        $triage = $this->emergencyService->createTriage($validated);

        return redirect()->route('emergency.index')
            ->with('success', "{$triage->patient->full_name} isimli hastanın triyaj kaydı ({$triage->category_label}) oluşturuldu.");
    }

    /**
     * Triyaj Durumu Güncelleme (Müdahaleye Al / Taburcu Et)
     */
    public function updateStatus(Request $request, EmergencyTriage $triage): RedirectResponse
    {
        $validated = $request->validate([
            'status'             => 'required|in:waiting,in_treatment,discharged,transferred',
            'assigned_doctor_id' => 'nullable|exists:doctors,id',
        ]);

        $this->emergencyService->updateStatus($triage, $validated['status'], $validated['assigned_doctor_id'] ?? null);

        return redirect()->route('emergency.index')
            ->with('success', "{$triage->patient->full_name} isimli hastanın acil durumu '{$triage->status_label}' olarak güncellendi.");
    }
}
