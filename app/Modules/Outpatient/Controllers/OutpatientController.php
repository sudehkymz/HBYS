<?php

namespace App\Modules\Outpatient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Outpatient\Models\OutpatientExamination;
use App\Modules\Outpatient\Services\OutpatientService;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Appointment\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutpatientController extends Controller
{
    protected OutpatientService $outpatientService;

    public function __construct(OutpatientService $outpatientService)
    {
        $this->outpatientService = $outpatientService;
    }

    /**
     * Poliklinik Sıra ve Muayene Takip Ekranı
     */
    public function index(Request $request): View
    {
        $doctorId = $request->integer('doctor_id') ?: null;
        $queueData = $this->outpatientService->getQueueData($doctorId);
        $doctors = Doctor::orderBy('name')->get();

        return view('modules.outpatient.index', array_merge($queueData, ['doctors' => $doctors, 'selectedDoctorId' => $doctorId]));
    }

    /**
     * Hasta Muayene Odası / Doktor Ekranı
     */
    public function examine(Patient $patient, Request $request): View
    {
        $patient->load(['episodesOfCare', 'encounters.physician', 'prescriptions']);
        
        // Aktif veya en son muayene kaydı
        $examination = OutpatientExamination::where('patient_id', $patient->id)
            ->latest()
            ->first();

        if (!$examination) {
            $appointmentId = $request->integer('appointment_id') ?: null;
            $doctorId = $request->integer('doctor_id') ?: null;
            $examination = $this->outpatientService->startExamination($patient, $doctorId, $appointmentId);
        }

        // Popüler ICD-10 Kodları (Hızlı Seçim)
        $icd10Codes = [
            'I10 - Esansiyel (Primer) Hipertansiyon',
            'E11 - Tip 2 Diabetes Mellitus',
            'J06 - Akut Üst Solunum Yolu Enfeksiyonu',
            'J45 - Astım',
            'K29 - Gastrit ve Duodenit',
            'M54 - Sırt Ağrısı / Lumbago',
            'R51 - Baş Ağrısı',
        ];

        return view('modules.outpatient.examine', compact('patient', 'examination', 'icd10Codes'));
    }

    /**
     * Muayeneyi Başlatma (Kuyruktan Hasta Çağırma)
     */
    public function start(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'doctor_id'      => 'nullable|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        $patient = Patient::findOrFail($validated['patient_id']);
        $examination = $this->outpatientService->startExamination(
            $patient,
            $validated['doctor_id'] ?? null,
            $validated['appointment_id'] ?? null
        );

        return redirect()->route('outpatient.examine', $patient)
            ->with('success', "{$patient->full_name} isimli hastanın muayenesi başlatıldı.");
    }

    /**
     * Muayeneyi Tamamlama ve Sonlandırma
     */
    public function complete(Request $request, OutpatientExamination $examination): RedirectResponse
    {
        $validated = $request->validate([
            'chief_complaint'      => 'nullable|string',
            'physical_examination' => 'nullable|string',
            'icd10_code'           => 'required|string|max:150',
            'treatment_plan'       => 'nullable|string',
            'status'               => 'required|in:completed,referred,admitted',
        ]);

        $this->outpatientService->completeExamination($examination, $validated);

        $patient = $examination->patient;

        return redirect()->route('outpatient.index')
            ->with('success', "{$patient->full_name} isimli hastanın muayenesi tamamlandı ve kaydedildi.");
    }
}
