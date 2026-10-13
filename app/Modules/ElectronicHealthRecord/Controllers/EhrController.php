<?php

namespace App\Modules\ElectronicHealthRecord\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ElectronicHealthRecord\Services\EhrService;
use App\Modules\Patient\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EhrController extends Controller
{
    protected EhrService $ehrService;

    public function __construct(EhrService $ehrService)
    {
        $this->ehrService = $ehrService;
    }

    /**
     * Hastanın Elektronik Hasta Dosyası Özet ve Zaman Tüneli Ekranını gösterir.
     */
    public function show(Patient $patient): View
    {
        $data = $this->ehrService->getPatientEhrSummary($patient);
        return view('modules.electronic_health_record.show', $data);
    }

    /**
     * Hastaya yeni hayati bulgular (Tansiyon, Nabız, Ateş vb.) kaydeder.
     */
    public function storeVitals(Request $request, Patient $patient): RedirectResponse
    {
        $validated = $request->validate([
            'blood_pressure' => 'required|string|max:20',
            'pulse'          => 'required|numeric|min:30|max:220',
            'fever'          => 'required|numeric|min:30|max:45',
            'spo2'           => 'required|numeric|min:50|max:100',
            'respiration'    => 'nullable|numeric|min:5|max:60',
        ]);

        $this->ehrService->saveVitalSigns($patient->id, $validated);

        return redirect()->route('ehr.show', $patient)
            ->with('success', 'Hayati bulgular (Vitals) başarıyla güncellendi ve hasta dosyasına kaydedildi.');
    }

    /**
     * Hasta tıbbi özeti yazdırma görünümü.
     */
    public function printSummary(Patient $patient): View
    {
        $data = $this->ehrService->getPatientEhrSummary($patient);
        return view('modules.electronic_health_record.print', $data);
    }
}
