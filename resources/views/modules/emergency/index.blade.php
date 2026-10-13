@extends('layouts.app')

@section('title', 'Acil Servis & Canlı Triyaj Paneli')

@section('content')
<div class="container-fluid px-0">

    {{-- Başlık & Aksiyon Barı --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-truck-medical text-danger me-2"></i>Acil Servis & Canlı Triyaj Takip Paneli
            </h3>
            <p class="text-muted small mb-0">Kırmızı, Sarı ve Yeşil alan acil hastalarını canlı izleyin, aciliyet sırasına göre müdahale edin.</p>
        </div>
        <div>
            <!-- Sayfa yönlendirmesi yapmadan açılan In-Page Dynamic Triyaj Modalı -->
            <button type="button" class="btn btn-danger fw-bold px-4 shadow-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#emergencyModal">
                <i class="fa-solid fa-plus me-1"></i> Yeni Acil Giriş / Triyaj Kaydı
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Triyaj Kategorisi İstatistik Kartları --}}
    <div class="row g-3 mb-4">
        <!-- Kırmızı Kod (Kritik / Acil) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #fef2f2 !important; border-left: 5px solid #dc2626 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #991b1b !important; letter-spacing: 0.5px;">Kırmızı Kod (Kritik / Acil)</div>
                        <div class="fs-2 fw-bold" style="color: #991b1b !important; font-weight: 800;">{{ $stats['red_count'] }} Hasta</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #fee2e2; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #dc2626; font-size: 1.6rem;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sarı Kod (Orta Derece Acil) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #fffbeb !important; border-left: 5px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #92400e !important; letter-spacing: 0.5px;">Sarı Kod (Orta Derece Acil)</div>
                        <div class="fs-2 fw-bold" style="color: #92400e !important; font-weight: 800;">{{ $stats['yellow_count'] }} Hasta</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #d97706; font-size: 1.6rem;">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yeşil Kod (Ayaktan / Hafif) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #f0fdf4 !important; border-left: 5px solid #16a34a !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #166534 !important; letter-spacing: 0.5px;">Yeşil Kod (Ayaktan / Hafif)</div>
                        <div class="fs-2 fw-bold" style="color: #166534 !important; font-weight: 800;">{{ $stats['green_count'] }} Hasta</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #dcfce7; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #15803d; font-size: 1.6rem;">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bugün Sonlanan -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #f8fafc !important; border-left: 5px solid #475569 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #334155 !important; letter-spacing: 0.5px;">Bugün Sonlanan</div>
                        <div class="fs-2 fw-bold" style="color: #0f172a !important; font-weight: 800;">{{ $stats['completed_count'] }} Hasta</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #334155; font-size: 1.6rem;">
                        <i class="fa-solid fa-square-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Canlı Acil Hastalar Listesi (Kırmızı > Sarı > Yeşil Sıralı) --}}
    <div class="card border-0 shadow-sm dynamic-list-card" style="border-radius:14px;">
        <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
            <span class="fs-6"><i class="fa-solid fa-heart-pulse text-danger me-2"></i>Acil Servis Aktif Hasta Sırası (Önceliğe Göre Sıralı)</span>
            <span class="badge bg-danger rounded-pill" id="emergencyBadge">{{ count($triages) }} Bekleyen / Müdahalede</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive dynamic-table-scroll">
                <table class="table table-hover align-middle mb-0" data-dynamic-filter="true" data-count-badge="#emergencyBadge">
                    <thead class="sticky-table-header">
                        <tr>
                            <th class="ps-4">Triyaj Kodu</th>
                            <th>Giriş Saati</th>
                            <th>Hasta Bilgisi</th>
                            <th>Şikayet / Travma Notu</th>
                            <th>Son Vitaller</th>
                            <th>Görevli Hekim</th>
                            <th>Durum</th>
                            <th class="text-end pe-4">Aksiyon</th>
                        </tr>
                        <tr class="table-filter-row">
                            <th class="ps-4">
                                <select class="form-select table-filter-select" data-col-index="0">
                                    <option value="">Tüm Kodlar</option>
                                    <option value="kırmızı">🔴 Kırmızı Kod</option>
                                    <option value="sarı">🟡 Sarı Kod</option>
                                    <option value="yeşil">🟢 Yeşil Kod</option>
                                </select>
                            </th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="1" placeholder="Saat ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="2" placeholder="Hasta / TC ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="3" placeholder="Şikayet ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="4" placeholder="Vital ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="5" placeholder="Hekim ara..."></th>
                            <th>
                                <select class="form-select table-filter-select" data-col-index="6">
                                    <option value="">Tüm Durumlar</option>
                                    <option value="bekliyor">Sıra Bekliyor</option>
                                    <option value="müdahalede">Müdahalede</option>
                                </select>
                            </th>
                            <th class="text-end pe-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($triages as $triage)
                            <tr class="{{ $triage->triage_category === 'red' ? 'table-danger' : '' }}">
                                <td class="ps-4">
                                    <span class="badge bg-{{ $triage->category_badge }} px-3 py-2 fs-6 shadow-sm">
                                        @if($triage->triage_category === 'red')
                                            <i class="fa-solid fa-triangle-exclamation me-1 animate-pulse"></i>
                                        @endif
                                        {{ $triage->category_label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $triage->created_at ? $triage->created_at->format('H:i') : '-' }}</div>
                                    <div class="text-muted small" style="font-size:0.75rem;">{{ $triage->created_at ? $triage->created_at->diffForHumans() : '' }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $triage->patient->full_name ?? 'Hasta' }}</div>
                                    <div class="text-muted small">T.C.: {{ $triage->patient->national_id ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="small fw-semibold text-dark">{{ Str::limit($triage->chief_complaint, 45) }}</div>
                                </td>
                                <td>
                                    @if(is_array($triage->vital_signs))
                                        <div class="small" style="font-size:0.8rem;">
                                            <span class="badge bg-light text-dark border">T: {{ $triage->vital_signs['blood_pressure'] ?? '-' }}</span>
                                            <span class="badge bg-light text-dark border">N: {{ $triage->vital_signs['pulse'] ?? '-' }}</span>
                                            <span class="badge bg-light text-dark border">SpO2: %{{ $triage->vital_signs['spo2'] ?? '-' }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="small fw-semibold text-secondary">
                                        {{ $triage->doctor->name ?? 'Atanmadı' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border border-secondary px-2 py-1 fs-6">
                                        {{ $triage->status_label }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group me-1">
                                        <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown">
                                            Aksiyon
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <form action="{{ route('emergency.status', $triage) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="in_treatment">
                                                    <button type="submit" class="dropdown-item text-primary"><i class="fa-solid fa-user-doctor me-2"></i>Müdahaleye Al</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('emergency.status', $triage) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="discharged">
                                                    <button type="submit" class="dropdown-item text-success"><i class="fa-solid fa-circle-check me-2"></i>Taburcu Et (Şifa)</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('emergency.status', $triage) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="transferred">
                                                    <button type="submit" class="dropdown-item text-warning"><i class="fa-solid fa-bed me-2"></i>Servis Yatışı / Sevk</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('ehr.show', $triage->patient_id) }}" class="btn btn-sm btn-outline-primary" title="EHR Dosyası">
                                        <i class="fa-solid fa-folder-open"></i> EHR
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-truck-medical fs-1 text-secondary opacity-50 mb-3"></i>
                                    <p class="mb-0">Acil serviste şu an sıra bekleyen veya müdahaldeki hasta bulunmamaktadır.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- ========================================== -->
<!-- YENİ ACİL GİRİŞ & TRİYAJ MODALI (SAYFA DEĞİŞMEDEN) -->
<!-- ========================================== -->
<div class="modal fade" id="emergencyModal" tabindex="-1" aria-labelledby="emergencyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="emergencyModalLabel">
                    <i class="fa-solid fa-truck-medical me-2"></i>Yeni Acil Giriş & Canlı Triyaj Kaydı
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form action="{{ route('emergency.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        {{-- Hasta Seçimi --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Acil Hasta <span class="text-danger">*</span></label>
                            <select name="patient_id" class="form-select" required>
                                <option value="">--- Hasta Seçiniz ---</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->full_name }} (T.C: {{ $patient->national_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Triyaj Kategorisi (Kırmızı / Sarı / Yeşil) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Triyaj Aciliyet Kodu <span class="text-danger">*</span></label>
                            <select name="triage_category" class="form-select fw-bold" required>
                                <option value="red" class="text-danger">🔴 KIRMIZI KOD (Hayati Tehlike / Resüsitasyon)</option>
                                <option value="yellow" class="text-warning">🟡 SARI KOD (Uzatılmış Bekleme Yapamaz)</option>
                                <option value="green" class="text-success" selected>🟢 YEŞİL KOD (Ayaktan / Hafif)</option>
                            </select>
                        </div>

                        {{-- Görevli Nöbetçi Hekim --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Sorumlu Nöbetçi Hekim</label>
                            <select name="assigned_doctor_id" class="form-select">
                                <option value="">--- Hekim Atayınız (İsteğe Bağlı) ---</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->specialty }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Vital Bulgular --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Tansiyon (TA)</label>
                            <input type="text" name="blood_pressure" class="form-control" placeholder="120/80">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Nabız (Pulse)</label>
                            <input type="number" name="pulse" class="form-control" placeholder="80">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Ateş (°C)</label>
                            <input type="number" step="0.1" name="fever" class="form-control" placeholder="36.6">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">SpO2 (%)</label>
                            <input type="number" name="spo2" class="form-control" placeholder="98">
                        </div>

                        {{-- Şikayet & Anamnez Notu --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Şikayet, Travma ve Anamnez Notu <span class="text-danger">*</span></label>
                            <textarea name="chief_complaint" class="form-control" rows="3" placeholder="Hastanın acil servise geliş şikayeti ve ilk fiziki değerlendirmesi..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-danger px-4 fw-bold">Triyaj Kaydını Başlat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
