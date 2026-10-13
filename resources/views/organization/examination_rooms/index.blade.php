@extends('layouts.app')

@section('title', 'Muayene Odaları')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0"><i class="fa-solid fa-door-open text-primary me-2"></i>Muayene Odaları</h3>
    <a href="{{ route('organization.examination-rooms.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Yeni Muayene Odası Ekle
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Oda Adı</th>
                        <th>Poliklinik</th>
                        <th>Kapasite</th>
                        <th class="text-end pe-4">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($examinationRooms as $room)
                    <tr>
                        <td class="ps-4 fw-semibold">#{{ $room->id }}</td>
                        <td class="fw-bold">{{ $room->name }}</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill">{{ $room->poliklinik->name ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark rounded-pill">{{ $room->capacity }} Kişi</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('organization.examination-rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fa-solid fa-pen"></i> Düzenle
                            </a>
                            <form action="{{ route('organization.examination-rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu muayene odasını silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i> Sil
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fa-solid fa-door-open fs-3 d-block mb-2"></i>
                            Henüz eklenmiş bir muayene odası bulunmuyor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($examinationRooms->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $examinationRooms->links() }}
    </div>
    @endif
</div>
@endsection
