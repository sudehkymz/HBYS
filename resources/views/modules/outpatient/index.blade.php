@extends('layouts.app')

@section('title', 'Poliklinik Akışı & Sıra Takibi')

@section('content')
<div class="container-fluid px-0">

    {{-- Başlık & Filtre Barı --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-stethoscope text-primary me-2"></i>Poliklinik Akışı & Muayene Odası Sıra Paneli
            </h3>
            <p class="text-muted small mb-0">Bugünün muayene sırasını takip edin, hastaları muayene odasına çağırın ve sonlandırın.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">
                <i class="fa-solid fa-calendar-check me-1"></i> Randevular
            </a>
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-user-injured me-1"></i> Tüm Hastalar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- İstatistik Rozetleri --}}
    <div class="row g-3 mb-4">
        <!-- Sıra Bekleyen Randevulu -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #fffbeb !important; border-left: 5px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #92400e !important; letter-spacing: 0.5px;">Sıra Bekleyen Randevulu</div>
                        <div class="fs-2 fw-bold" style="color: #92400e !important; font-weight: 800;">{{ $stats['waiting_count'] }} Hasta</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #d97706; font-size: 1.6rem;">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Muayene Odasında (Aktif) -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #eff6ff !important; border-left: 5px solid #2563eb !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #1e40af !important; letter-spacing: 0.5px;">Muayene Odasında (Aktif)</div>
                        <div class="fs-2 fw-bold" style="color: #1e40af !important; font-weight: 800;">{{ $stats['active_count'] }} Hasta</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 1.6rem;">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bugün Tamamlanan Muayene -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #f0fdf4 !important; border-left: 5px solid #16a34a !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #166534 !important; letter-spacing: 0.5px;">Bugün Tamamlanan Muayene</div>
                        <div class="fs-2 fw-bold" style="color: #166534 !important; font-weight: 800;">{{ $stats['completed_count'] }} Hasta</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #dcfce7; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #15803d; font-size: 1.6rem;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Sol Kolon: Bekleyen Hasta Sıra Kuyruğu --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm dynamic-list-card" style="border-radius:14px;">
                <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
                    <span class="fs-6"><i class="fa-solid fa-list-ol text-primary me-2"></i>Bugünün Poliklinik Sıra Kuyruğu</span>
                    <span class="badge bg-warning text-dark" id="outpatientWaitingBadge">{{ count($waiting_appointments) }} Hasta Bekliyor</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive dynamic-table-scroll">
                        <table class="table table-hover align-middle mb-0" data-dynamic-filter="true" data-count-badge="#outpatientWaitingBadge">
                            <thead class="sticky-table-header">
                                <tr>
                                    <th class="ps-3">Saat</th>
                                    <th>Hasta</th>
                                    <th>Doktor</th>
                                    <th class="text-end pe-3">Aksiyon</th>
                                </tr>
                                <tr class="table-filter-row">
                                    <th class="ps-3"><input type="text" class="form-control table-filter-input" data-col-index="0" placeholder="Saat..."></th>
                                    <th><input type="text" class="form-control table-filter-input" data-col-index="1" placeholder="Hasta / TC ara..."></th>
                                    <th><input type="text" class="form-control table-filter-input" data-col-index="2" placeholder="Doktor ara..."></th>
                                    <th class="text-end pe-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($waiting_appointments as $app)
                                    <tr>
                                        <td class="ps-3">
                                            <span class="badge bg-light text-dark border fw-bold fs-6">
                                                {{ $app->appointment_time }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $app->patient->full_name ?? 'Bilinmeyen Hasta' }}</div>
                                            <div class="text-muted small">T.C.: {{ $app->patient->national_id ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div class="small fw-semibold text-secondary">{{ $app->doctor->name ?? 'Doktor' }}</div>
                                        </td>
                                        <td class="text-end pe-3">
                                            <form action="{{ route('outpatient.start') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="patient_id" value="{{ $app->patient_id }}">
                                                <input type="hidden" name="doctor_id" value="{{ $app->doctor_id }}">
                                                <input type="hidden" name="appointment_id" value="{{ $app->id }}">
                                                <button type="submit" class="btn btn-success btn-sm px-3 fw-bold">
                                                    <i class="fa-solid fa-door-open me-1"></i> Muayeneye Çağır
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Bugün için sıra bekleyen randevulu hasta bulunmamaktadır.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sağ Kolon: Muayenedeki ve Tamamlanan Hastalar --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm dynamic-list-card" style="border-radius:14px;">
                <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
                    <span class="fs-6"><i class="fa-solid fa-user-doctor text-success me-2"></i>Aktif ve Tamamlanan Muayeneler</span>
                    <span class="badge bg-primary" id="outpatientActiveBadge">{{ count($examinations) }} Muayene Kaydı</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive dynamic-table-scroll">
                        <table class="table table-hover align-middle mb-0" data-dynamic-filter="true" data-count-badge="#outpatientActiveBadge">
                            <thead class="sticky-table-header">
                                <tr>
                                    <th class="ps-3">Hasta</th>
                                    <th>Tanı / ICD-10</th>
                                    <th>Durum</th>
                                    <th class="text-end pe-3">İşlem</th>
                                </tr>
                                <tr class="table-filter-row">
                                    <th class="ps-3"><input type="text" class="form-control table-filter-input" data-col-index="0" placeholder="Hasta ara..."></th>
                                    <th><input type="text" class="form-control table-filter-input" data-col-index="1" placeholder="Tanı / ICD ara..."></th>
                                    <th>
                                        <select class="form-select table-filter-select" data-col-index="2">
                                            <option value="">Tüm Durumlar</option>
                                            <option value="muayenede">Muayenede</option>
                                            <option value="tamamlandı">Tamamlandı</option>
                                        </select>
                                    </th>
                                    <th class="text-end pe-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($examinations as $exam)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold text-dark">{{ $exam->patient->full_name ?? 'Hasta' }}</div>
                                            <div class="text-muted small">{{ $exam->created_at ? $exam->created_at->format('H:i') : '-' }}</div>
                                        </td>
                                        <td>
                                            <span class="small fw-semibold text-secondary">{{ $exam->icd10_code ?? 'Tanı Girilmedi' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $exam->status_badge }} px-2 py-1 fs-6">
                                                {{ $exam->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="{{ route('outpatient.examine', $exam->patient) }}" class="btn btn-outline-primary btn-sm fw-semibold">
                                                <i class="fa-solid fa-stethoscope me-1"></i> Muayene Ekranı
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Bugün henüz başlatılmış poliklinik muayenesi bulunmuyor.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
