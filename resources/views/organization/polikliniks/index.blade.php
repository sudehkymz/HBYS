@extends('layouts.app')

@section('title', 'Poliklinikler')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0"><i class="fa-solid fa-stethoscope text-primary me-2"></i>Poliklinikler</h3>
    <a href="{{ route('organization.polikliniks.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Yeni Poliklinik Ekle
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Poliklinik Adı</th>
                        <th>Bağlı Klinik</th>
                        <th>Oda Sayısı</th>
                        <th class="text-end pe-4">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($polikliniks as $poliklinik)
                    <tr>
                        <td class="ps-4 fw-semibold">#{{ $poliklinik->id }}</td>
                        <td class="fw-bold">{{ $poliklinik->name }}</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill">{{ $poliklinik->clinic->name ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark rounded-pill">{{ $poliklinik->examination_rooms_count ?? 0 }} Muayene Odası</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('organization.polikliniks.edit', $poliklinik) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fa-solid fa-pen"></i> Düzenle
                            </a>
                            <form action="{{ route('organization.polikliniks.destroy', $poliklinik) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu polikliniği silmek istediğinize emin misiniz?');">
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
                            <i class="fa-solid fa-stethoscope fs-3 d-block mb-2"></i>
                            Henüz eklenmiş bir poliklinik bulunmuyor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($polikliniks->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $polikliniks->links() }}
    </div>
    @endif
</div>
@endsection
