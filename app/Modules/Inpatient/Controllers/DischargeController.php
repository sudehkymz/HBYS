<?php

namespace App\Modules\Inpatient\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Inpatient\Services\EpicrisisService;

class DischargeController extends Controller
{
    protected $epicrisisService;

    public function __construct(EpicrisisService $epicrisisService)
    {
        $this->epicrisisService = $epicrisisService;
    }

    /**
     * Display the discharge form.
     */
    public function index($id = null)
    {
        // Fetch active admissions from session
        $admissions = session('admissions', []);
        
        $selectedAdmission = null;
        if ($id) {
            foreach ($admissions as $adm) {
                if ($adm['id'] == $id) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        return view('modules.inpatient.discharge', compact('admissions', 'selectedAdmission', 'id'));
    }

    /**
     * Discharge a patient and generate epicrisis.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'discharge_date' => 'required|string',
            'discharge_status' => 'required|string',
            'discharge_diagnosis' => 'required|string|max:500',
            'procedures' => 'required|string|max:500',
            'surgeries' => 'nullable|string|max:500',
            'lab_summary' => 'nullable|string|max:500',
            'radiology_summary' => 'nullable|string|max:500',
            'pathology_summary' => 'nullable|string|max:500',
            'active_medications' => 'nullable|string|max:500',
            'stopped_medications' => 'nullable|string|max:500',
            'discharge_medications' => 'nullable|string|max:500',
            'nutrition_recommendations' => 'nullable|string|max:500',
            'activity_recommendations' => 'nullable|string|max:500',
            'wound_care' => 'nullable|string|max:500',
            'follow_up_date' => 'nullable|string',
            'follow_up_clinic' => 'nullable|string',
        ]);

        // Find admission
        $admissions = session('admissions', []);
        $selectedAdmissionIndex = null;
        foreach ($admissions as $index => $adm) {
            if ($adm['id'] == $validated['admission_id']) {
                $selectedAdmissionIndex = $index;
                break;
            }
        }

        if ($selectedAdmissionIndex === null) {
            return redirect()->back()->withErrors(['admission_id' => 'Geçersiz veya aktif olmayan yatış kaydı.']);
        }

        $admission = $admissions[$selectedAdmissionIndex];

        // Free the bed in beds list (set status to 'temizlik')
        $beds = session('beds', []);
        foreach ($beds as $index => $bed) {
            if ($bed['room'] == $admission['room'] && $bed['bed'] == $admission['bed']) {
                $beds[$index]['status'] = 'temizlik';
                $beds[$index]['status_tr'] = 'Temizlik Bekliyor';
                $beds[$index]['patient_name'] = null;
                break;
            }
        }
        session(['beds' => $beds]);

        // Build epicrisis payload
        $dischargePayload = array_merge($validated, [
            'patient_name' => $admission['patient_name'],
            'national_id' => $admission['national_id'],
            'age' => $admission['age'],
            'gender' => $admission['gender'],
            'admission_date' => $admission['admission_date'],
            'admission_diagnosis' => $admission['diagnosis'],
            'physician_name' => $admission['attending_physician'],
        ]);

        // Generate epicrisis document
        $epicrisis = $this->epicrisisService->generateData($dischargePayload);

        // Store epicrisis in session history
        $epicrisisRecords = session('epicrisis_records', []);
        array_unshift($epicrisisRecords, $epicrisis);
        session(['epicrisis_records' => $epicrisisRecords]);

        // Remove from active admissions
        unset($admissions[$selectedAdmissionIndex]);
        // Reindex array
        session(['admissions' => array_values($admissions)]);

        // Save last epicrisis for popup display
        session()->flash('last_epicrisis', $epicrisis);

        // Add to timeline events
        $timelineEvents = session('timeline_events', []);
        array_unshift($timelineEvents, [
            'time' => now()->format('d.m.Y H:i'),
            'type' => 'Taburcu / Epikriz',
            'badge_color' => 'danger',
            'details' => "{$admission['patient_name']} isimli hasta {$admission['service']} servisinden taburcu edildi ({$validated['discharge_status']}). Reçete Kodu: {$epicrisis['prescription_code']}."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('inpatient.admission.index')->with('success', 'Hasta taburculuk işlemi ve epikriz raporu başarıyla tamamlandı!');
    }
}