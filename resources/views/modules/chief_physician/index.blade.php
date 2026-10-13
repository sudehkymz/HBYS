@extends('layouts.app')

@section('title', 'Başhekim Paneli & Hastane Yönetim Masası')

@push('styles')
<style>
    body { background-color: #f8fafc; color: #0f172a; }
    
    .card-chief {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    
    .stat-badge {
        font-size: 0.85rem;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
    }

    .nav-pills-chief .nav-link {
        color: #475569;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .nav-pills-chief .nav-link.active {
        background-color: #0f75bc;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 117, 188, 0.25);
    }

    .nav-pills-chief .nav-link:hover:not(.active) {
        background-color: #e2e8f0;
        color: #0f172a;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- BAŞHEKİM ÖZEL HEADER BANNER (YALNIZCA BAŞHEKİM YETKİSİ) -->
    <div class="card card-chief mb-4 border-top border-4 border-primary">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary p-3 d-flex align-items-center justify-content-center text-white" style="width: 54px; height: 54px;">
                        <i class="fa-solid fa-user-shield fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-gear text-primary"></i>Başhekim Paneli & Hastane Yönetim Masası
                        </h2>
                        <p class="text-muted small mb-0">Rapor onaylama masası, hastane yatan hasta doluluk takibi, yoğun bakım & hekim nöbet yönetim portalı.</p>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="stat-badge bg-primary-subtle text-primary border border-primary-subtle">
                        <i class="fa-solid fa-user-doctor me-1 text-primary"></i> <strong>Prof. Dr. Ahmet Başhekim</strong>
                    </span>
                    <span class="stat-badge bg-success-subtle text-success border border-success-subtle">
                        <i class="fa-solid fa-bed me-1"></i> Yatan Hasta: <strong>{{ $occupiedBedsCount }} / {{ $totalBedsCount }} (%{{ $occupancyRate }})</strong>
                    </span>
                    <span class="stat-badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">
                        <i class="fa-solid fa-hourglass-half me-1"></i> Onay Bekleyen Rapor: <strong>{{ $pendingCount }}</strong>
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- TAB NAVIGATION -->
    <ul class="nav nav-pills nav-pills-chief mb-4 gap-2 border-bottom pb-3" id="chiefTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="tab-approval-tab" data-bs-toggle="tab" data-bs-target="#tab-approval" type="button" role="tab">
                <i class="fa-solid fa-file-signature me-2 text-warning"></i>1. Doktor Rapor Onay & e-Rapor Masası ({{ $pendingCount }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="tab-inpatients-tab" data-bs-toggle="tab" data-bs-target="#tab-inpatients" type="button" role="tab">
                <i class="fa-solid fa-hospital-user me-2 text-primary"></i>2. Toplam Yatan Hastalar & Servis Doluluk ({{ count($inpatientAdmissions) }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="tab-icu-tab" data-bs-toggle="tab" data-bs-target="#tab-icu" type="button" role="tab">
                <i class="fa-solid fa-triangle-exclamation me-2 text-danger"></i>3. Yoğun Bakım, Kritik Vakalar & Nöbet Çizelgesi
            </button>
        </li>
    </ul>

    <div class="tab-content" id="chiefTabsContent">
        <!-- 📑 TAB 1: DOKTOR RAPOR ONAY & E-RAPOR MASASI (GÖRSELDEKİ MASANIN BİREBİR AYNISI) -->
        <div class="tab-pane fade show active" id="tab-approval" role="tabpanel">
            <div class="card card-chief mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-clipboard-check text-primary"></i>Doktor Rapor Onay & e-Rapor Masası
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-6 rounded-pill font-monospace">
                            {{ $totalCount }} Kayıtlı Rapor
                        </span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-6 rounded-pill">
                            <i class="fa-solid fa-file-signature me-1"></i>Resmi Hekim & SGK e-Raporları
                        </span>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive border rounded-3 shadow-sm" style="max-height: 520px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light position-sticky top-0 shadow-sm" style="z-index: 10;">
                                <tr>
                                    <th class="ps-3">Rapor No</th>
                                    <th>Tür / Tanı</th>
                                    <th>Onay Durumu</th>
                                    <th class="pe-3 text-end">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $r)
                                <tr>
                                    <td class="ps-3 fw-bold text-dark font-monospace">{{ $r->report_number }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $r->report_type }}</div>
                                        <div class="text-muted small">{{ $r->diagnosis }} ({{ $r->rest_days }} Gün)</div>
                                    </td>
                                    <td>
                                        @if($r->chief_physician_approval_status === 'approved')
                                            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fa-solid fa-circle-check me-1"></i>Onaylandı</span>
                                            <div class="small text-success font-monospace fw-bold mt-1" style="font-size:0.75rem;">{{ $r->e_rapor_no }}</div>
                                        @elseif($r->chief_physician_approval_status === 'rejected')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fa-solid fa-circle-xmark me-1"></i>Reddedildi</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fa-solid fa-clock me-1"></i>Onay Bekliyor</span>
                                        @endif
                                    </td>
                                    <td class="pe-3 text-end">
                                        <button type="button" class="btn btn-outline-primary btn-sm fw-semibold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#reportModal{{ $r->id }}">
                                            <i class="fa-solid fa-file-lines me-1"></i>İncele & Onayla
                                        </button>
                                    </td>
                                </tr>

                                <!-- REPORT PREVIEW & APPROVAL MODAL -->
                                <div class="modal fade" id="reportModal{{ $r->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-3">
                                            <div class="modal-header bg-primary text-white py-3">
                                                <h5 class="modal-header-title fw-bold mb-0 text-white">
                                                    <i class="fa-solid fa-file-signature me-2"></i>Başhekim e-Rapor İnceleme & Onay Masası
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="p-3 bg-light rounded border mb-4">
                                                    <div class="row g-2">
                                                        <div class="col-md-6">
                                                            <strong>Rapor Protokol No:</strong> <span class="font-monospace fw-bold">{{ $r->report_number }}</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Rapor Türü:</strong> {{ $r->report_type }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Teşhis (ICD-10):</strong> {{ $r->diagnosis }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>İstirahat Süresi:</strong> {{ $r->rest_days }} Gün
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <h6 class="fw-bold text-secondary">Rapor Açıklaması & Hekim Klinik Notu:</h6>
                                                    <p class="p-3 bg-white border rounded text-dark">{{ $r->report_content }}</p>
                                                </div>

                                                @if(isset($r->ai_analysis))
                                                <div class="p-3 bg-info-subtle border border-info rounded mb-4">
                                                    <h6 class="fw-bold text-info-emphasis"><i class="fa-solid fa-robot me-1"></i>AI Karar Destek Güvenlik Analizi:</h6>
                                                    <p class="mb-0 small text-dark">{{ $r->ai_analysis['recommendation'] ?? 'Rapor klinik standartlara ve protokol şartlarına uygundur.' }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <form action="{{ route('chief_physician.reject_report', $r->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger me-2">
                                                        <i class="fa-solid fa-xmark me-1"></i>Raporu Reddet
                                                    </button>
                                                </form>

                                                <form action="{{ route('chief_physician.approve_report', $r->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success fw-bold px-4">
                                                        <i class="fa-solid fa-check-double me-1"></i>Onayla & SGK e-Rapor Kodunu Üret
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">Onay bekleyen veya kayıtlı doktor raporu bulunmamaktadır.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🏥 TAB 2: TOPLAM YATAN HASTALAR & SERVİS DOLULUK MASASI -->
        <div class="tab-pane fade" id="tab-inpatients" role="tabpanel">
            <div class="card card-chief mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-hospital-user text-primary"></i>Hastane Yatan Hasta & Servis Doluluk Listesi
                    </h5>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 rounded-pill">
                        Toplam Yatak Kapasitesi: {{ $occupiedBedsCount }} / {{ $totalBedsCount }} (%{{ $occupancyRate }} Dolu)
                    </span>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive border rounded-3 shadow-sm" style="max-height: 520px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light position-sticky top-0 shadow-sm" style="z-index: 10;">
                                <tr>
                                    <th class="ps-3">Hasta Adı / TC</th>
                                    <th>Oda / Yatak</th>
                                    <th>Klinik Servis</th>
                                    <th>Tıbbi Tanı</th>
                                    <th>Sorumlu Hekim</th>
                                    <th>Yatış Tarihi</th>
                                    <th class="pe-3 text-end">Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inpatientAdmissions as $adm)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">{{ $adm['patient_name'] }}</div>
                                        <div class="text-muted small font-monospace">TC: {{ $adm['national_id'] }} ({{ $adm['age'] }} Y / {{ $adm['gender'] }})</div>
                                    </td>
                                    <td><span class="badge bg-secondary font-monospace">Oda {{ $adm['room'] }} (Yatak {{ $adm['bed'] ?? 'A' }})</span></td>
                                    <td><span class="fw-bold text-primary">{{ $adm['service'] }}</span></td>
                                    <td><span class="text-dark">{{ Str::limit($adm['diagnosis'], 35) }}</span></td>
                                    <td><span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>{{ $adm['attending_physician'] }}</span></td>
                                    <td><span class="small text-muted">{{ $adm['admission_date'] ?? '28.07.2026' }}</span></td>
                                    <td class="pe-3 text-end"><span class="badge bg-success px-3 py-2 rounded-pill">Yatış Aktif</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">Kayıtlı aktif yatan hasta bulunmamaktadır.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🚨 TAB 3: YOĞUN BAKIM, KRİTİK VAKALAR & NÖBET ÇİZELGESİ -->
        <div class="tab-pane fade" id="tab-icu" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-chief h-100 p-4 border-start border-4 border-danger">
                        <h5 class="fw-bold text-danger mb-3"><i class="fa-solid fa-triangle-exclamation me-2"></i>Yoğun Bakım & Kritik Hasta Takip Paneli</h5>
                        <div class="p-3 bg-danger-subtle rounded border border-danger-subtle mb-3">
                            <h6 class="fw-bold text-danger mb-1">Mustafa Solmaz (68 Y - KOAH Alevlenmesi & Pnömoni)</h6>
                            <p class="mb-0 small text-dark">SpO2: %88, Dahiliye Yoğun Bakım Yatak 202-A | Mekanik Ventilatör Desteğinde Takip Ediliyor.</p>
                        </div>
                        <div class="p-3 bg-warning-subtle rounded border border-warning-subtle mb-3">
                            <h6 class="fw-bold text-warning-emphasis mb-1">Merve Karaca (34 Y - Preeklampsi & Fetal Büyüme Kısıtlılığı)</h6>
                            <p class="mb-0 small text-dark">Perinatoloji Yoğun Bakım Standby | Kan Basıncı 150/95 mmHg, Günde 2 Kez NST İzlemi.</p>
                        </div>
                        <div class="p-3 bg-info-subtle rounded border border-info-subtle">
                            <h6 class="fw-bold text-info-emphasis mb-1">Gamze Aksoy (29 Y - 32H4D Gebelik & Erken Eylem Şüphesi)</h6>
                            <p class="mb-0 small text-dark">Obstetrik Yoğun Bakım | Fetal Kalp Hızı 142 bpm Reaktif NST Takibinde.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-chief h-100 p-4 border-start border-4 border-success">
                        <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-user-doctor me-2"></i>Nöbetçi Uzman Hekim & Personel Çizelgesi</h5>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">Prof. Dr. Ahmet Başhekim</h6>
                                    <small class="text-muted">Başhekimlik & Hastane Genel Koordinasyonu</small>
                                </div>
                                <span class="badge bg-primary px-3 py-2 rounded-pill">Başhekim Nöbetçi</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">Prof. Dr. Ayşe Şevket</h6>
                                    <small class="text-muted">Kadın Hastalıkları ve Doğum Polikliniği</small>
                                </div>
                                <span class="badge bg-success px-3 py-2 rounded-pill">Aktif Nöbetçi</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">Doç. Dr. Nesrin Başar</h6>
                                    <small class="text-muted">Anesteziyoloji, Reanimasyon & Algoloji</small>
                                </div>
                                <span class="badge bg-info px-3 py-2 rounded-pill">Yoğun Bakım Nöbetçisi</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">Dr. Kürşat Kıran</h6>
                                    <small class="text-muted">Genel Cerrahi & Ameliyathane Sorumlusu</small>
                                </div>
                                <span class="badge bg-secondary px-3 py-2 rounded-pill">Cerrahi Nöbetçi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
