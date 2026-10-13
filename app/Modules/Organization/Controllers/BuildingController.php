<?php

namespace App\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Requests\StoreBuildingRequest;
use App\Modules\Organization\Requests\UpdateBuildingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BuildingController extends Controller
{
    public function index(): View
    {
        $buildings = Building::withCount('floors')->with(['floors.clinics.polikliniks'])->get();
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
            ->with('success', 'Bina başarıyla eklendi.');
    }

    public function edit(Building $building): View
    {
        return view('organization.buildings.edit', compact('building'));
    }

    public function update(UpdateBuildingRequest $request, Building $building): RedirectResponse
    {
        $building->update($request->validated());
        return redirect()->route('organization.buildings.index')
            ->with('success', 'Bina başarıyla güncellendi.');
    }

    public function destroy(Building $building): RedirectResponse
    {
        $building->delete();
        return redirect()->route('organization.buildings.index')
            ->with('success', 'Bina silindi.');
    }
}
