@extends('layouts.app')

@section('title', 'Klinikler')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0"><i class="fa-solid fa-clinic-medical text-primary me-2"></i>Klinikler</h3>
    <a href="{{ route('organization.clinics.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Yeni Klinik Ekle
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Klinik Adı</th>
                        <th>Bağlı Kat</th>
                        <th>Bağlı Bina</th>
                        <th>Poliklinik Sayısı</th>
                        <th class="text-end pe-4">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clinics as $clinic)
                    <tr>
                        <td class="ps-4 fw-semibold">#{{ $clinic->id }}</td>
                        <td class="fw-bold">{{ $clinic->name }}</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill">{{ $clinic->floor->name ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-dark rounded-pill">{{ $clinic->floor->building->name ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark rounded-pill">{{ $clinic->polikliniks_count ?? 0 }} Poliklinik</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('organization.clinics.edit', $clinic) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fa-solid fa-pen"></i> Düzenle
                            </a>
                            <form action="{{ route('organization.clinics.destroy', $clinic) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu kliniği silmek istediğinize emin misiniz?');">
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
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fa-solid fa-clinic-medical fs-3 d-block mb-2"></i>
                            Henüz eklenmiş bir klinik bulunmuyor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($clinics->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $clinics->links() }}
    </div>
    @endif
</div>
@endsection
