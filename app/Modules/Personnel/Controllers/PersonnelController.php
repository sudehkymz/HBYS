<?php

namespace App\Modules\Personnel\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Personnel\Models\Personnel;
use App\Modules\Personnel\Requests\StorePersonnelRequest;
use App\Modules\Personnel\Requests\UpdatePersonnelRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonnelController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $careRank = trim((string) $request->input('care_rank', ''));

        $query = Personnel::with('clinic');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('care_rank', 'like', "%{$search}%");
            });
        }

        if (!empty($careRank)) {
            $query->where('care_rank', $careRank);
        }

        $personnels = $query->get();

        $careRanks = Personnel::distinct()->whereNotNull('care_rank')->pluck('care_rank');

        return view('personnel.personnels.index', compact('personnels', 'search', 'careRank', 'careRanks'));
    }

    public function create(): View
    {
        // get clinics for selection
        $clinics = \App\Modules\Organization\Models\Clinic::all();
        return view('personnel.personnels.create', compact('clinics'));
    }

    public function store(StorePersonnelRequest $request): RedirectResponse
    {
        Personnel::create($request->validated());
        return redirect()->route('personnel.personnels.index')
            ->with('success', 'Personel başarıyla eklendi.');
    }

    public function edit(Personnel $personnel): View
    {
        $clinics = \App\Modules\Organization\Models\Clinic::all();
        return view('personnel.personnels.edit', compact('personnel', 'clinics'));
    }

    public function update(UpdatePersonnelRequest $request, Personnel $personnel): RedirectResponse
    {
        $personnel->update($request->validated());
        return redirect()->route('personnel.personnels.index')
            ->with('success', 'Personel başarıyla güncellendi.');
    }

    public function destroy(Personnel $personnel): RedirectResponse
    {
        $personnel->delete();
        return redirect()->route('personnel.personnels.index')
            ->with('success', 'Personel silindi.');
    }
}
