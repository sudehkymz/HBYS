<?php

namespace App\Modules\Personnel\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Personnel\Requests\StoreDoctorRequest;
use App\Modules\Personnel\Requests\UpdateDoctorRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $title = trim((string) $request->input('academic_title', ''));
        $specialty = trim((string) $request->input('specialty', ''));

        $query = Doctor::with(['clinic', 'examinationRoom', 'academicAssignments.juniorDoctor', 'nurseTeams.nurse']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialty', 'like', "%{$search}%")
                  ->orWhere('sub_specialty', 'like', "%{$search}%");
            });
        }

        if (!empty($title)) {
            $query->where('academic_title', $title);
        }

        if (!empty($specialty)) {
            $query->where('specialty', 'like', "%{$specialty}%");
        }

        $doctors = $query->get();

        $academicTitles = \Illuminate\Support\Facades\Cache::remember('doctor_academic_titles', 600, function () {
            return Doctor::distinct()->whereNotNull('academic_title')->pluck('academic_title');
        });
        $specialties = \Illuminate\Support\Facades\Cache::remember('doctor_specialties', 600, function () {
            return Doctor::distinct()->whereNotNull('specialty')->pluck('specialty');
        });

        return view('personnel.doctors.index', compact('doctors', 'search', 'title', 'specialty', 'academicTitles', 'specialties'));
    }

    public function create(): View
    {
        $clinics = \Illuminate\Support\Facades\Cache::remember('organization_clinics_all', 600, function () {
            return \App\Modules\Organization\Models\Clinic::all();
        });
        return view('personnel.doctors.create', compact('clinics'));
    }

    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        Doctor::create($request->validated());
        \Illuminate\Support\Facades\Cache::forget('doctor_academic_titles');
        \Illuminate\Support\Facades\Cache::forget('doctor_specialties');
        return redirect()->route('personnel.doctors.index')
            ->with('success', 'Doktor başarıyla eklendi.');
    }

    public function edit(Doctor $doctor): View
    {
        $clinics = \Illuminate\Support\Facades\Cache::remember('organization_clinics_all', 600, function () {
            return \App\Modules\Organization\Models\Clinic::all();
        });
        return view('personnel.doctors.create', compact('doctor', 'clinics'));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor): RedirectResponse
    {
        $doctor->update($request->validated());
        return redirect()->route('personnel.doctors.index')
            ->with('success', 'Doktor başarıyla güncellendi.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();
        return redirect()->route('personnel.doctors.index')
            ->with('success', 'Doktor silindi.');
    }
}
