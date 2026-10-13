<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Requests\StorePatientRequest;
use App\Modules\Patient\Requests\UpdatePatientRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $query = Patient::withCount(['encounters', 'episodesOfCare']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('national_id', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->get();
        return view('patient.index', compact('patients'));
    }

    public function create(): View
    {
        return view('patient.create');
    }

    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Hasta kaydı başarıyla oluşturuldu.',
                'patient' => $patient
            ]);
        }

        return redirect()->route('patients.index')
            ->with('success', 'Hasta kaydı başarıyla oluşturuldu.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['episodesOfCare.encounters.physician', 'encounters.physician', 'prescriptions']);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'patient' => $patient
            ]);
        }

        $doctors = \App\Modules\Personnel\Models\Doctor::select(['id', 'name', 'specialty', 'clinic_id'])
            ->with('clinic:id,name')
            ->orderBy('name')
            ->get();

        $prescriptionCount = $patient->prescriptions->count();

        return view('patient.show', compact('patient', 'doctors', 'prescriptionCount'));
    }

    public function edit(Patient $patient)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'patient' => $patient
            ]);
        }

        return view('patient.edit', compact('patient'));
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Hasta bilgileri başarıyla güncellendi.',
                'patient' => $patient
            ]);
        }

        return redirect()->route('patients.index')
            ->with('success', 'Hasta bilgileri güncellendi.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Hasta kaydı silindi.'
            ]);
        }

        return redirect()->route('patients.index')
            ->with('success', 'Hasta kaydı silindi.');
    }
}