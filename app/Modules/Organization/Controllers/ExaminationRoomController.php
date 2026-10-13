<?php

namespace App\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Models\ExaminationRoom;
use App\Modules\Organization\Models\Poliklinik;
use App\Modules\Organization\Requests\StoreExaminationRoomRequest;
use App\Modules\Organization\Requests\UpdateExaminationRoomRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExaminationRoomController extends Controller
{
    public function index(): View
    {
        $examinationRooms = ExaminationRoom::with(['poliklinik.clinic.floor.building'])->paginate(10);
        return view('organization.examination_rooms.index', compact('examinationRooms'));
    }

    public function create(): View
    {
        $polikliniks = Poliklinik::with('clinic')->get();
        return view('organization.examination_rooms.create', compact('polikliniks'));
    }

    public function store(StoreExaminationRoomRequest $request): RedirectResponse
    {
        ExaminationRoom::create($request->validated());
        return redirect()->route('organization.examination-rooms.index')
            ->with('success', 'Muayene Odası başarıyla eklendi.');
    }

    public function edit(ExaminationRoom $examinationRoom): View
    {
        $polikliniks = Poliklinik::with('clinic')->get();
        return view('organization.examination_rooms.edit', compact('examinationRoom', 'polikliniks'));
    }

    public function update(UpdateExaminationRoomRequest $request, ExaminationRoom $examinationRoom): RedirectResponse
    {
        $examinationRoom->update($request->validated());
        return redirect()->route('organization.examination-rooms.index')
            ->with('success', 'Muayene Odası başarıyla güncellendi.');
    }

    public function destroy(ExaminationRoom $examinationRoom): RedirectResponse
    {
        $examinationRoom->delete();
        return redirect()->route('organization.examination-rooms.index')
            ->with('success', 'Muayene Odası silindi.');
    }
}
