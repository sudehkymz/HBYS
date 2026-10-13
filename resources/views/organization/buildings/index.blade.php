@extends('layouts.app')

@section('title', 'Binalar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0"><i class="fa-solid fa-building text-primary me-2"></i>Binalar</h3>
    <a href="{{ route('organization.buildings.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Yeni Bina Ekle
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive dynamic-table-scroll">
            <table class="table table-hover align-middle mb-0">
                <thead class="sticky-table-header">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Bina Adı</th>
                        <th>Adres</th>
                        <th>Kat Sayısı</th>
                        <th class="text-end pe-4">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buildings as $building)
                    <tr>
                        <td class="ps-4 fw-semibold">#{{ $building->id }}</td>
                        <td class="fw-bold">{{ $building->name }}</td>
                        <td class="text-muted">{{ $building->address ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info text-dark rounded-pill">{{ $building->floors_count ?? 0 }} Kat</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('organization.buildings.edit', $building) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fa-solid fa-pen"></i> Düzenle
                            </a>
                            <form action="{{ route('organization.buildings.destroy', $building) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu binayı silmek istediğinize emin misiniz?');">
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
                            <i class="fa-solid fa-building-circle-exclamation fs-3 d-block mb-2"></i>
                            Henüz eklenmiş bir bina bulunmuyor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
