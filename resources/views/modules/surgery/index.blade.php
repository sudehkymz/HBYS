@extends('layouts.app')

@section('title', 'Ameliyathane ve Anestezi Yönetimi')

@push('styles')
<style>
    .surgery-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
    }
    .patient-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    .patient-item:hover {
        background-color: #f8f9fa;
    }
    .patient-item.active {
        background-color: #e8f0fe;
        border-left-color: #0d6efd;
    }
    .status-badge {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-syringe text-primary me-2"></i>Ameliyathane & Anestezi Yönetim Paneli
            </h1>
            <p class="text-muted mb-0">Hastalara ameliyat planlayın, anestezi değerlendirmeleri oluşturun ve ameliyat raporlarını kaydedin.</p>
        </div>
    </div>

    <div class="row">
        <!-- Patient List Sidebar -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card surgery-card">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold text-secondary mb-0">
                            <i class="fa-solid fa-users me-2"></i>Aktif Yatan Hastalar
                        </h5>
                        <span class="badge bg-primary rounded-pill">{{ count($admissions) }} Hasta</span>
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0 table-filter-input" data-dynamic-list-search="#surgeryPatientList" placeholder="Hasta adı, oda veya tanı ara...">
                    </div>
                </div>
                <div class="list-group list-group-flush" id="surgeryPatientList" style="max-height: calc(100vh - 260px); min-height: 400px; overflow-y: auto;">
                    @forelse($admissions as $adm)
                        <a href="{{ route('surgery.index', ['admission_id' => $adm['id']]) }}" 
                           data-admission-id="{{ $adm['id'] }}"
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-secondary">Oda: {{ $adm['room'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mt-1">
                                <span>{{ $adm['service'] }}</span>
                                <span>Tanı: {{ Str::limit($adm['diagnosis'], 20) }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-bed-pulse fa-3x mb-3 opacity-30"></i>
                            <p class="mb-0">Aktif yatan hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Work Area -->
        <div class="col-lg-8 col-12">
            @if(count($admissions) > 0)
                @foreach($admissions as $adm)
                    @php
                        $activeSchedule = isset($schedules[$adm['id']]) ? $schedules[$adm['id']] : null;
                        $activeAnesthesia = isset($anesthesia[$adm['id']]) ? $anesthesia[$adm['id']] : null;
                        $activeReport = isset($reports[$adm['id']]) ? $reports[$adm['id']] : null;
                        $isActivePane = ($selectedAdmission && $selectedAdmission['id'] == $adm['id']);
                    @endphp
                    <div class="patient-dashboard-pane" id="patient-pane-{{ $adm['id'] }}" style="display: {{ $isActivePane ? 'block' : 'none' }}">
                        <!-- Patient Info Card -->
                        <div class="card surgery-card mb-4 border-start border-primary border-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-12">
                                        <h4 class="fw-bold text-primary mb-1">{{ $adm['patient_name'] }}</h4>
                                        <p class="text-muted mb-0 small">
                                            <strong>T.C. Kimlik:</strong> {{ $adm['national_id'] }} | 
                                            <strong>Yaş/Cinsiyet:</strong> {{ $adm['age'] }} Yaş / {{ $adm['gender'] }} | 
                                            <strong>Doktor:</strong> {{ $adm['attending_physician'] }}
                                        </p>
                                        <p class="text-muted mb-0 small mt-1">
                                            <strong>Tanı:</strong> {{ $adm['diagnosis'] }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 col-12 text-md-end mt-3 mt-md-0">
                                        @if($activeSchedule)
                                            <span class="status-badge bg-primary text-white" id="status-badge-{{ $adm['id'] }}">{{ $activeSchedule['status'] }}</span>
                                        @else
                                            <span class="status-badge bg-warning text-dark" id="status-badge-{{ $adm['id'] }}">Ameliyat Planlanmadı</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-4" id="surgeryTab-{{ $adm['id'] }}" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold" id="plan-tab-{{ $adm['id'] }}" data-bs-toggle="tab" data-bs-target="#plan-{{ $adm['id'] }}" type="button" role="tab">
                                    <i class="fa-solid fa-calendar-plus me-2"></i>1. Ameliyat Planlama
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="anesthesia-tab-{{ $adm['id'] }}" data-bs-toggle="tab" data-bs-target="#anesthesia-{{ $adm['id'] }}" type="button" role="tab" @if(!$activeSchedule) disabled @endif>
                                    <i class="fa-solid fa-lungs me-2"></i>2. Anestezi Pre-op
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="report-tab-{{ $adm['id'] }}" data-bs-toggle="tab" data-bs-target="#report-{{ $adm['id'] }}" type="button" role="tab" @if(!$activeAnesthesia) disabled @endif>
                                    <i class="fa-solid fa-file-medical me-2"></i>3. Ameliyat Notu & Rapor
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="surgeryTabContent-{{ $adm['id'] }}">
                            <!-- 1. Planning Tab -->
                            <div class="tab-pane fade show active" id="plan-{{ $adm['id'] }}" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card surgery-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-clock me-2"></i>Yeni Ameliyat Planı</h5>
                                            <form action="{{ route('surgery.schedule') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Uygulanacak Ameliyat (Operasyon)</label>
                                                    <input type="text" class="form-control" name="operation" placeholder="Örn: Laparoskopik Kolesistektomi" value="{{ $activeSchedule['operation'] ?? '' }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Ameliyathane Salonu</label>
                                                    <select class="form-select" name="room" required>
                                                        @foreach($rooms as $r)
                                                            <option value="{{ $r }}" {{ ($activeSchedule && $activeSchedule['room'] == $r) ? 'selected' : '' }}>{{ $r }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Sorumlu Cerrah</label>
                                                    <select class="form-select" name="surgeon" required>
                                                        @foreach($surgeons as $s)
                                                            <option value="{{ $s }}" {{ ($activeSchedule && $activeSchedule['surgeon'] == $s) ? 'selected' : '' }}>{{ $s }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Anestezi Uzmanı</label>
                                                    <select class="form-select" name="anesthesiologist" required>
                                                        @foreach($anesthesiologists as $a)
                                                            <option value="{{ $a }}" {{ ($activeSchedule && $activeSchedule['anesthesiologist'] == $a) ? 'selected' : '' }}>{{ $a }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Planlanan Tarih & Saat</label>
                                                    <input type="text" class="form-control" name="planned_date" placeholder="Örn: 28.07.2026 10:00" value="{{ $activeSchedule['planned_date'] ?? now()->addDay()->format('d.m.Y 10:00') }}" required>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fa-solid fa-save me-1"></i>Ameliyatı Planla ve Kaydet
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card surgery-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-info-circle me-2"></i>Aktif Plan Detayı</h5>
                                            @if($activeSchedule)
                                                <div class="bg-light p-3 rounded">
                                                    <p class="mb-2"><strong>Operasyon:</strong> {{ $activeSchedule['operation'] }}</p>
                                                    <p class="mb-2"><strong>Salon:</strong> {{ $activeSchedule['room'] }}</p>
                                                    <p class="mb-2"><strong>Cerrah:</strong> {{ $activeSchedule['surgeon'] }}</p>
                                                    <p class="mb-2"><strong>Anestezi:</strong> {{ $activeSchedule['anesthesiologist'] }}</p>
                                                    <p class="mb-2"><strong>Tarih/Saat:</strong> {{ $activeSchedule['planned_date'] }}</p>
                                                    <p class="mb-0"><strong>Durum:</strong> <span class="badge bg-info">{{ $activeSchedule['status'] }}</span></p>
                                                </div>
                                            @else
                                                <p class="text-muted text-center py-5">Bu hasta için henüz planlanmış bir ameliyat bulunmamaktadır.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Anesthesia Tab -->
                            <div class="tab-pane fade" id="anesthesia-{{ $adm['id'] }}" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card surgery-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-file-medical-chart me-2"></i>Pre-op Değerlendirme</h5>
                                            <form action="{{ route('surgery.anesthetize') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">ASA Risk Sınıflaması</label>
                                                    <select class="form-select" name="asa_score" required>
                                                        <option value="ASA I" {{ ($activeAnesthesia && $activeAnesthesia['asa_score'] == 'ASA I') ? 'selected' : '' }}>ASA I: Sağlıklı normal hasta</option>
                                                        <option value="ASA II" {{ ($activeAnesthesia && $activeAnesthesia['asa_score'] == 'ASA II') ? 'selected' : '' }}>ASA II: Hafif sistemik hastalığı olan hasta</option>
                                                        <option value="ASA III" {{ ($activeAnesthesia && $activeAnesthesia['asa_score'] == 'ASA III') ? 'selected' : '' }}>ASA III: Ağır sistemik hastalığı olan hasta</option>
                                                        <option value="ASA IV" {{ ($activeAnesthesia && $activeAnesthesia['asa_score'] == 'ASA IV') ? 'selected' : '' }}>ASA IV: Hayatı tehdit eden ağır sistemik hastalığı olan hasta</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Havayolu Değerlendirmesi (Mallampati)</label>
                                                    <select class="form-select" name="airway" required>
                                                        <option value="Mallampati Class I" {{ ($activeAnesthesia && $activeAnesthesia['airway'] == 'Mallampati Class I') ? 'selected' : '' }}>Sınıf I: Yumuşak damak, farenks, uvula, tonsil yatakları tam görünür</option>
                                                        <option value="Mallampati Class II" {{ ($activeAnesthesia && $activeAnesthesia['airway'] == 'Mallampati Class II') ? 'selected' : '' }}>Sınıf II: Yumuşak damak, farenks, uvula görünür</option>
                                                        <option value="Mallampati Class III" {{ ($activeAnesthesia && $activeAnesthesia['airway'] == 'Mallampati Class III') ? 'selected' : '' }}>Sınıf III: Yumuşak damak, uvula tabanı görünür</option>
                                                        <option value="Mallampati Class IV" {{ ($activeAnesthesia && $activeAnesthesia['airway'] == 'Mallampati Class IV') ? 'selected' : '' }}>Sınıf IV: Yumuşak damak hiç görünmez</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Pre-op Anestezi Notu</label>
                                                    <textarea class="form-control" name="preop_note" rows="4" placeholder="Hastanın anestezi geçmişi, alerjileri ve pre-op muayene detayları..." required>{{ $activeAnesthesia['preop_note'] ?? '' }}</textarea>
                                                </div>

                                                <button type="submit" class="btn btn-info text-white w-100">
                                                    <i class="fa-solid fa-clipboard-check me-1"></i>Anestezi Notunu Kaydet & Onayla
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card surgery-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-shield-halved me-2"></i>Anestezi Onay Durumu</h5>
                                            @if($activeAnesthesia)
                                                <div class="alert alert-success d-flex align-items-center">
                                                    <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                                                    <div>
                                                        Anestezi pre-op değerlendirmesi tamamlandı ve hasta ameliyata uygun görüldü.
                                                    </div>
                                                </div>
                                                <div class="bg-light p-3 rounded mt-3">
                                                    <p class="mb-1"><strong>ASA Skoru:</strong> {{ $activeAnesthesia['asa_score'] }}</p>
                                                    <p class="mb-1"><strong>Havayolu:</strong> {{ $activeAnesthesia['airway'] }}</p>
                                                    <p class="mb-0"><strong>Klinik Not:</strong> {{ $activeAnesthesia['preop_note'] }}</p>
                                                </div>
                                            @else
                                                <p class="text-muted text-center py-5">Bu hasta için anestezi değerlendirmesi henüz yapılmamıştır.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Report Tab -->
                            <div class="tab-pane fade" id="report-{{ $adm['id'] }}" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card surgery-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-pen-to-square me-2"></i>Ameliyat Raporu ve Bulgular</h5>
                                            <form action="{{ route('surgery.report') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Ameliyat Bulguları ve Yapılan İşlemler</label>
                                                    <textarea class="form-control" name="findings" rows="5" placeholder="Ameliyat sırasında gözlenen bulgular ve uygulanan cerrahi teknikler..." required>{{ $activeReport['findings'] ?? '' }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Komplikasyonlar (Varsa)</label>
                                                    <input type="text" class="form-control" name="complications" placeholder="Örn: Komplikasyon izlenmedi." value="{{ $activeReport['complications'] ?? 'Komplikasyon izlenmedi.' }}" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Post-op İzlem / Bakım Önerileri</label>
                                                    <input type="text" class="form-control" name="postop_care" placeholder="Örn: 2 saat yakın vital takip, sıvı gıda kısıtlaması." value="{{ $activeReport['postop_care'] ?? '' }}" required>
                                                </div>

                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="fa-solid fa-file-invoice me-1"></i>Ameliyat Raporunu Tamamla & Kapat
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card surgery-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-file-alt me-2"></i>Sonuç Raporu</h5>
                                            @if($activeReport)
                                                <div class="alert alert-success">
                                                    <i class="fa-solid fa-circle-check me-2"></i>Ameliyat Başarıyla Tamamlandı!
                                                </div>
                                                <div class="bg-light p-3 rounded" id="surgeryReportArea-{{ $adm['id'] }}">
                                                    <p class="mb-2"><strong>Hasta Adı:</strong> {{ $adm['patient_name'] }}</p>
                                                    <p class="mb-2"><strong>Tamamlanma Tarihi:</strong> {{ $activeReport['completed_at'] }}</p>
                                                    <p class="mb-2"><strong>Bulgular:</strong> {{ $activeReport['findings'] }}</p>
                                                    <p class="mb-2"><strong>Komplikasyon:</strong> {{ $activeReport['complications'] }}</p>
                                                    <p class="mb-0"><strong>Post-op Bakım:</strong> {{ $activeReport['postop_care'] }}</p>
                                                </div>
                                                <button class="btn btn-outline-primary btn-sm mt-3 w-100" onclick="printDiv('surgeryReportArea-{{ $adm['id'] }}', 'Ameliyat Notu & Sonuç Raporu')">
                                                    <i class="fa-solid fa-print me-1"></i>Raporu Yazdır
                                                </button>
                                            @else
                                                <p class="text-muted text-center py-5">Ameliyat henüz gerçekleşmedi veya rapor henüz doldurulmadı.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card surgery-card p-5 text-center text-muted">
                    <i class="fa-solid fa-hospital-user fa-4x mb-3 opacity-30"></i>
                    <h5 class="fw-bold text-secondary">Hasta Seçimi Yapın</h5>
                    <p class="mb-0">Ameliyat planlama ve yönetim işlemlerine başlamak için sol menüden bir hasta seçin.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function printDiv(divId, title) {
        const divToPrint = document.getElementById(divId);
        const newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write(`
            <html>
            <head>
                <title>${title}</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { padding: 30px; font-family: sans-serif; }
                    .print-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                <div class="print-header">
                    <h3>YEBSOFT SAĞLIK GRUBU</h3>
                    <h5>${title}</h5>
                </div>
        ` + divToPrint.innerHTML + `
            </body>
            </html>
        `);
        newWin.document.close();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const patientItems = document.querySelectorAll('.patient-item');
        patientItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const admissionId = this.getAttribute('data-admission-id');

                // Update URL parameter without reload
                const newUrl = this.getAttribute('href');
                window.history.pushState({path: newUrl}, '', newUrl);

                // Update active state in sidebar
                patientItems.forEach(pi => pi.classList.remove('active'));
                this.classList.add('active');

                // Toggle dashboard content panes
                document.querySelectorAll('.patient-dashboard-pane').forEach(pane => {
                    pane.style.display = 'none';
                });
                const targetPane = document.getElementById('patient-pane-' + admissionId);
                if (targetPane) {
                    targetPane.style.display = 'block';
                }
            });
        });
    });
</script>
@endpush
