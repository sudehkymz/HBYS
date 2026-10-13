<?php

namespace App\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Models\Floor;
use App\Modules\Organization\Requests\StoreFloorRequest;
use App\Modules\Organization\Requests\UpdateFloorRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FloorController extends Controller
{
    public function index(): View
    {
        $floors = Floor::with(['building'])->withCount('clinics')->paginate(10);
        return view('organization.floors.index', compact('floors'));
    }

    public function create(): View
    {
        $buildings = Building::all();
        return view('organization.floors.create', compact('buildings'));
    }

    public function store(StoreFloorRequest $request): RedirectResponse
    {
        Floor::create($request->validated());
        return redirect()->route('organization.floors.index')
            ->with('success', 'Kat başarıyla eklendi.');
    }

    public function edit(Floor $floor): View
    {
        $buildings = Building::all();
        return view('organization.floors.edit', compact('floor', 'buildings'));
    }

    public function update(UpdateFloorRequest $request, Floor $floor): RedirectResponse
    {
        $floor->update($request->validated());
        return redirect()->route('organization.floors.index')
            ->with('success', 'Kat başarıyla güncellendi.');
    }

    public function destroy(Floor $floor): RedirectResponse
    {
        $floor->delete();
        return redirect()->route('organization.floors.index')
            ->with('success', 'Kat silindi.');
    }
}
