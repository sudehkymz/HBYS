<?php

namespace App\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Organization\Models\Floor;
use App\Modules\Organization\Requests\StoreClinicRequest;
use App\Modules\Organization\Requests\UpdateClinicRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClinicController extends Controller
{
    public function index(): View
    {
        $clinics = Clinic::with(['floor.building'])->withCount('polikliniks')->paginate(10);
        return view('organization.clinics.index', compact('clinics'));
    }

    public function create(): View
    {
        $floors = \Illuminate\Support\Facades\Cache::remember('organization_floors_all', 600, function () {
            return Floor::with('building')->get();
        });
        return view('organization.clinics.create', compact('floors'));
    }

    public function store(StoreClinicRequest $request): RedirectResponse
    {
        Clinic::create($request->validated());
        \Illuminate\Support\Facades\Cache::forget('organization_floors_all');
        return redirect()->route('organization.clinics.index')
            ->with('success', 'Klinik başarıyla eklendi.');
    }

    public function edit(Clinic $clinic): View
    {
        $floors = \Illuminate\Support\Facades\Cache::remember('organization_floors_all', 600, function () {
            return Floor::with('building')->get();
        });
        return view('organization.clinics.edit', compact('clinic', 'floors'));
    }

    public function update(UpdateClinicRequest $request, Clinic $clinic): RedirectResponse
    {
        $clinic->update($request->validated());
        return redirect()->route('organization.clinics.index')
            ->with('success', 'Klinik başarıyla güncellendi.');
    }

    public function destroy(Clinic $clinic): RedirectResponse
    {
        $clinic->delete();
        return redirect()->route('organization.clinics.index')
            ->with('success', 'Klinik silindi.');
    }
}
