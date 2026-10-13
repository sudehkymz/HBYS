<?php

namespace App\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Models\Floor;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Organization\Models\Poliklinik;
use App\Modules\Organization\Models\ExaminationRoom;
use App\Modules\Organization\Requests\StoreBuildingRequest;
use App\Modules\Organization\Requests\UpdateBuildingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    // ──────────────────────── BUILDINGS ────────────────────────
    public function index(): View
    {
        $buildings = Building::with(['floors.clinics.polikliniks.examinationRooms'])->paginate(15);
        return view('organization.buildings.index', compact('buildings'));
    }

    public function create(): View
    {
        return view('organization.buildings.create');
    }

    public function store(StoreBuildingRequest $request): RedirectResponse
    {
        Building::create($request->validated());
        return redirect()->route('organization.buildings.index')
            ->with('success', 'Bina oluşturuldu');
    }

    public function edit(Building $building): View
    {
        return view('organization.buildings.edit', compact('building'));
    }

    public function update(UpdateBuildingRequest $request, Building $building): RedirectResponse
    {
        $building->update($request->validated());
        return redirect()->route('organization.buildings.index')
            ->with('success', 'Bina güncellendi');
    }

    public function destroy(Building $building): RedirectResponse
    {
        $building->delete();
        return redirect()->route('organization.buildings.index')
            ->with('success', 'Bina silindi');
    }

    // ──────────────────────── FLOORS (nested) ────────────────────────
    public function floorsIndex(Building $building): View
    {
        $floors = $building->floors()->paginate(15);
        return view('organization.floors.index', compact('building', 'floors'));
    }

    public function floorsCreate(Building $building): View
    {
        return view('organization.floors.create', compact('building'));
    }

    public function floorsStore(Request $request, Building $building): RedirectResponse
    {
        $data = $request->validate(['name' => 'required|string|max:100']);
        $building->floors()->create($data);
        return redirect()->route('organization.buildings.floors.index', $building)
            ->with('success', 'Kat eklendi');
    }

    // Similar CRUD methods for clinics, polikliniks, examination rooms can be added later.
}