@extends('layouts.app')

@section('title', 'Randevu ve Zaman Çizelgesi Yönetimi')

@section('content')
<div class="container-fluid px-0">

    {{-- Başlık & Aksiyon Barı --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-calendar-check text-primary me-2"></i>Randevu ve Poliklinik Zaman Çizelgesi
            </h3>
            <p class="text-muted small mb-0">Hasta randevularını filtreleyin, durumlarını güncelleyin veya yeni randevu oluşturun.</p>
        </div>
        <div>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary fw-semibold px-4 shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Yeni Randevu Al
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filtreleme Kartı --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('appointments.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted">Hasta Arama (TC / İsim)</label>
                    <input type="text" name="search" class="form-control" placeholder="Örn: 12345678901 veya Ahmet" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted">Doktor Filtresi</label>
                    <select name="doctor_id" class="form-select">
                        <option value="">Tüm Doktorlar</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>
                                {{ $doc->name }} ({{ $doc->specialty ?? 'Genel' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted">Randevu Tarihi</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted">Durum</label>
                    <select name="status" class="form-select">
                        <option value="">Tüm Durumlar</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Bekliyor</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>İptal Edildi</option>
                        <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>Gelmedi</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i>Filtrele</button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-rotate"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Randevu Listesi Tablosu --}}
    <div class="card border-0 shadow-sm dynamic-list-card" style="border-radius:14px;">
        <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
            <span class="fs-6"><i class="fa-solid fa-calendar-check text-primary me-2"></i>Randevu Çizelgesi Listesi</span>
            <span class="badge bg-primary rounded-pill" id="appointmentBadge">{{ count($appointments) }} Randevu Kaydı</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive dynamic-table-scroll">
                <table class="table table-hover align-middle mb-0" data-dynamic-filter="true" data-count-badge="#appointmentBadge">
                    <thead class="sticky-table-header">
                        <tr>
                            <th class="ps-4">Randevu Tarihi & Saat</th>
                            <th>Hasta Bilgileri</th>
                            <th>Doktor & Poliklinik</th>
                            <th>Şikayet / Not</th>
                            <th>Durum</th>
                            <th class="text-end pe-4">İşlemler</th>
                        </tr>
                        <tr class="table-filter-row">
                            <th class="ps-4"><input type="text" class="form-control table-filter-input" data-col-index="0" placeholder="Tarih / Saat ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="1" placeholder="Hasta / TC ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="2" placeholder="Doktor / Klinik ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="3" placeholder="Not ara..."></th>
                            <th>
                                <select class="form-select table-filter-select" data-col-index="4">
                                    <option value="">Tüm Durumlar</option>
                                    <option value="bekliyor">Bekliyor</option>
                                    <option value="tamamlandı">Tamamlandı</option>
                                    <option value="iptal">İptal Edildi</option>
                                    <option value="gelmedi">Gelmedi</option>
                                </select>
                            </th>
                            <th class="text-end pe-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $app)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $app->appointment_date ? $app->appointment_date->format('d.m.Y') : '-' }}</div>
                                    <span class="badge bg-light text-primary border border-primary-subtle fs-6">
                                        <i class="fa-regular fa-clock me-1"></i>{{ $app->appointment_time }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $app->patient->full_name ?? 'Silinmiş Hasta' }}</div>
                                    <div class="text-muted small">T.C.: {{ $app->patient->national_id ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $app->doctor->name ?? 'Doktor Atanmadı' }}</div>
                                    <div class="text-muted small"><i class="fa-solid fa-clinic-medical me-1"></i>{{ $app->doctor->specialty ?? ($app->clinic->name ?? 'Genel') }}</div>
                                </td>
                                <td>
                                    <span class="small text-secondary">{{ $app->notes ? Str::limit($app->notes, 40) : 'Not yok' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $app->status_badge }} px-3 py-2 fs-6">
                                        {{ $app->status_label }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            Durum Değiştir
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <form action="{{ route('appointments.status', $app) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item text-success"><i class="fa-solid fa-check me-2"></i>Tamamlandı</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('appointments.status', $app) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-ban me-2"></i>İptal Et</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('appointments.status', $app) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="no_show">
                                                    <button type="submit" class="dropdown-item text-secondary"><i class="fa-solid fa-user-slash me-2"></i>Gelmedi</button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('appointments.destroy', $app) }}" method="POST" onsubmit="return confirm('Bu randevuyu silmek istediğinize emin misiniz?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i>Sil</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-calendar-xmark fs-1 text-secondary opacity-50 mb-3"></i>
                                    <p class="mb-0">Arama kriterlerine uygun randevu bulunamadı.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($appointments->hasPages())
                <div class="p-4 border-top">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
