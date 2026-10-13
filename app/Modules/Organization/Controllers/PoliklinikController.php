<?php

namespace App\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Organization\Models\Poliklinik;
use App\Modules\Organization\Requests\StorePoliklinikRequest;
use App\Modules\Organization\Requests\UpdatePoliklinikRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PoliklinikController extends Controller
{
    public function index(): View
    {
        $polikliniks = Poliklinik::with(['clinic.floor.building'])->withCount('examinationRooms')->paginate(10);
        return view('organization.polikliniks.index', compact('polikliniks'));
    }

    public function create(): View
    {
        $clinics = Clinic::with('floor.building')->get();
        return view('organization.polikliniks.create', compact('clinics'));
    }

    public function store(StorePoliklinikRequest $request): RedirectResponse
    {
        Poliklinik::create($request->validated());
        return redirect()->route('organization.polikliniks.index')
            ->with('success', 'Poliklinik başarıyla eklendi.');
    }

    public function edit(Poliklinik $poliklinik): View
    {
        $clinics = Clinic::with('floor.building')->get();
        return view('organization.polikliniks.edit', compact('poliklinik', 'clinics'));
    }

    public function update(UpdatePoliklinikRequest $request, Poliklinik $poliklinik): RedirectResponse
    {
        $poliklinik->update($request->validated());
        return redirect()->route('organization.polikliniks.index')
            ->with('success', 'Poliklinik başarıyla güncellendi.');
    }

    public function destroy(Poliklinik $poliklinik): RedirectResponse
    {
        $poliklinik->delete();
        return redirect()->route('organization.polikliniks.index')
            ->with('success', 'Poliklinik silindi.');
    }
}
