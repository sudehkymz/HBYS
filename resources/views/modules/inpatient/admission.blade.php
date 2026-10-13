@extends('layouts.app')

@section('title', 'Yatan Hasta ve Yatak Yönetimi')

@push('styles')
<style>
    /* Premium Bed Management Styling */
    .inpatient-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .inpatient-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
    }
    .bed-grid-item {
        cursor: pointer;
        border-radius: 10px;
        padding: 12px;
        transition: all 0.2s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }
    .bed-grid-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .bed-grid-item.active-selection {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.25) !important;
        transform: scale(1.03);
    }
    /* Bed Status Colors */
    .bed-bos {
        background-color: #d1e7dd;
        color: #0f5132;
        border: 1px solid #a3cfbb;
    }
    .bed-dolu {
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
    }
    .bed-temizlik {
        background-color: #fff3cd;
        color: #664d03;
        border: 1px solid #ffecb5;
    }
    .bed-izolasyon {
        background-color: #f3e5f5;
        color: #4a148c;
        border: 1px solid #e1bee7;
    }
    .bed-izole {
        background-color: #fdf2f8;
        color: #9d174d;
        border: 1px solid #fbcfe8;
    }
    .bed-rezerve {
        background-color: #e2e3e5;
        color: #383d41;
        border: 1px solid #d6d8db;
    }
    .status-dot {
        height: 8px;
        width: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .dot-bos { background-color: #198754; }
    .dot-dolu { background-color: #dc3545; }
    .dot-temizlik { background-color: #ffc107; }
    .dot-izolasyon { background-color: #9c27b0; }
    .dot-izole { background-color: #db2777; }
    .dot-rezerve { background-color: #6c757d; }
    
    .stat-badge {
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-bed text-primary me-2"></i>Yatan Hasta & Yatak Yönetim Paneli
            </h1>
            <p class="text-muted mb-0">Hastanemizin servis doluluk oranlarını izleyin, hasta yatış ve yatak transfer işlemlerini yönetin.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('inpatient.timeline') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-clock-rotate-left me-1"></i>Servis Akış Çizelgesi
            </a>
            <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#transferModal">
                <i class="fa-solid fa-arrows-rotate me-1"></i>Hasta Transfer Et
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBedModal">
                <i class="fa-solid fa-plus me-1"></i>Yeni Yatak Ekle
            </button>
        </div>
    </div>

    <!-- Last Epicrisis Summary Modal Trigger (Autoloaded if session exists) -->
    @if(session('last_epicrisis'))
        <div class="modal fade show d-block" id="epicrisisResultModal" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold">
                            <i class="fa-solid fa-file-invoice-solid me-2"></i>Oluşturulan Taburcu Epikriz Belgesi
                        </h5>
                        <button type="button" class="btn-close btn-close-white" onclick="closeEpicrisisModal()"></button>
                    </div>
                    <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold mb-0 text-secondary">YEBSOFT SAĞLIK GRUBU</h4>
                            <p class="text-muted small">RESMİ HASTA TABURCU EPİKRİZ RAPORU</p>
                        </div>
                        
                        <div class="row g-3 mb-4 bg-light p-3 rounded">
                            <div class="col-md-6"><strong>Döküman No:</strong> {{ session('last_epicrisis')['document_no'] }}</div>
                            <div class="col-md-6 text-md-end"><strong>Düzenlenme Tarihi:</strong> {{ session('last_epicrisis')['issue_date'] }}</div>
                            <div class="col-md-6"><strong>Hasta Adı Soyadı:</strong> {{ session('last_epicrisis')['patient_name'] }}</div>
                            <div class="col-md-6 text-md-end"><strong>TC Kimlik No:</strong> {{ session('last_epicrisis')['national_id'] }}</div>
                            <div class="col-md-6"><strong>Yaş / Cinsiyet:</strong> {{ session('last_epicrisis')['age'] }} / {{ session('last_epicrisis')['gender'] }}</div>
                            <div class="col-md-6 text-md-end"><strong>Yatış / Taburcu Tarihi:</strong> {{ session('last_epicrisis')['admission_date'] }} / {{ session('last_epicrisis')['discharge_date'] }}</div>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold text-primary border-bottom pb-1"><i class="fa-solid fa-stethoscope me-1"></i>Klinik Bilgiler</h6>
                            <p><strong>Yatış Tanısı:</strong> {{ session('last_epicrisis')['admission_diagnosis'] }}</p>
                            <p><strong>Taburculuk Tanısı:</strong> {{ session('last_epicrisis')['discharge_diagnosis'] }}</p>
                            <p><strong>Yapılan Tıbbi İşlemler:</strong> {{ session('last_epicrisis')['procedures'] }}</p>
                            <p><strong>Ameliyat / Cerrahi Müdahaleler:</strong> {{ session('last_epicrisis')['surgeries'] }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold text-primary border-bottom pb-1"><i class="fa-solid fa-flask me-1"></i>Tetkik Sonuçları Özeti</h6>
                            <p><strong>Laboratuvar Bulgu Özeti:</strong> {{ session('last_epicrisis')['lab_summary'] }}</p>
                            <p><strong>Radyolojik Görüntüleme Özeti:</strong> {{ session('last_epicrisis')['radiology_summary'] }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold text-primary border-bottom pb-1"><i class="fa-solid fa-pills me-1"></i>Tedavi Planı ve Reçete</h6>
                            <p><strong>Taburcu Reçetesi İlaçları:</strong> {{ session('last_epicrisis')['discharge_medications'] }}</p>
                            <p><strong>E-Reçete Kodu:</strong> <code class="fs-5 fw-bold text-danger">{{ session('last_epicrisis')['prescription_code'] }}</code></p>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold text-primary border-bottom pb-1"><i class="fa-solid fa-circle-info me-1"></i>Evde Bakım ve Kontrol Önerileri</h6>
                            <p><strong>Beslenme Önerileri:</strong> {{ session('last_epicrisis')['nutrition_recommendations'] }}</p>
                            <p><strong>Aktivite / İstirahat Önerileri:</strong> {{ session('last_epicrisis')['activity_recommendations'] }}</p>
                            <p><strong>Kontrol Randevusu:</strong> {{ session('last_epicrisis')['follow_up_date'] }} - {{ session('last_epicrisis')['follow_up_clinic'] }}</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <div>
                                <small class="text-muted d-block">Sorumlu Hekim</small>
                                <strong>{{ session('last_epicrisis')['physician_name'] }}</strong>
                                <div class="text-muted small">Klinik Operasyonlar Uzmanı</div>
                            </div>
                            <div class="text-center">
                                <span class="badge bg-success p-2 px-3 fs-6">DURUM: {{ session('last_epicrisis')['discharge_status'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" onclick="closeEpicrisisModal()">Kapat</button>
                        <button type="button" class="btn btn-primary" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Raporu Yazdır</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function closeEpicrisisModal() {
                document.getElementById('epicrisisResultModal').classList.remove('d-block');
                document.getElementById('epicrisisResultModal').classList.add('d-none');
            }
        </script>
    @endif

    <!-- Stats Panel -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card inpatient-card p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">Toplam Yatak Kapasitesi</span>
                        <h3 class="mb-0 fw-bold mt-1">{{ $stats['total'] }}</h3>
                    </div>
                    <span class="btn btn-sm bg-primary-subtle text-primary p-2 fs-5"><i class="fa-solid fa-hotel"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card inpatient-card p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">Dolu Yatak Sayısı</span>
                        <h3 class="mb-0 fw-bold mt-1 text-danger">
                            {{ $stats['dolu'] }}
                            <span class="text-muted fs-6 fw-normal">/ {{ round(($stats['dolu'] / $stats['total']) * 100) }}% Doluluk</span>
                        </h3>
                    </div>
                    <span class="btn btn-sm bg-danger-subtle text-danger p-2 fs-5"><i class="fa-solid fa-procedures"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card inpatient-card p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">Boş Yatak Sayısı</span>
                        <h3 class="mb-0 fw-bold mt-1 text-success">{{ $stats['bos'] }}</h3>
                    </div>
                    <span class="btn btn-sm bg-success-subtle text-success p-2 fs-5"><i class="fa-solid fa-circle-check"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card inpatient-card p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">İzlem/Bakım/Temizlik</span>
                        <h3 class="mb-0 fw-bold mt-1 text-warning">{{ $stats['other'] }}</h3>
                    </div>
                    <span class="btn btn-sm bg-warning-subtle text-warning p-2 fs-5"><i class="fa-solid fa-broom"></i></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Bed Grid View (Interactive Visual Map) -->
    <div class="card inpatient-card mb-4 border-0">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold text-secondary mb-0">
                <i class="fa-solid fa-cubes me-2"></i>İnteraktif Yatak Haritası (Klinik Bazlı)
            </h5>
            <div class="d-flex gap-3 small text-muted">
                <span><span class="status-dot dot-bos"></span>Boş</span>
                <span><span class="status-dot dot-dolu"></span>Dolu</span>
                <span><span class="status-dot dot-temizlik"></span>Temizlik</span>
                <span><span class="status-dot dot-izolasyon"></span>İzolasyon</span>
                <span><span class="status-dot dot-izole"></span>İzole Edildi</span>
                <span><span class="status-dot dot-rezerve"></span>Rezerve</span>
            </div>
        </div>
        <div class="card-body bg-light rounded-bottom p-4">
            @php
                $groupedBeds = collect($beds)->groupBy('service');
            @endphp

            <!-- Multi-Select Mode Switch & Action Bar -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="multiSelectToggle">
                    <label class="form-check-label fw-bold text-secondary ms-2" for="multiSelectToggle">
                        <i class="fa-solid fa-list-check me-1"></i>Çoklu Seçim Modu (Yatak Durumlarını Toplu Güncelle)
                    </label>
                </div>
            </div>

            <div id="bulkActionBar" class="alert alert-info py-2 px-3 mb-3 d-none align-items-center justify-content-between">
                <div>
                    <i class="fa-solid fa-circle-check text-primary me-2"></i>
                    <span id="bulkSelectedCountText">0 yatak seçildi.</span>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-primary fw-bold me-2" onclick="openBulkStatusModal()">
                        <i class="fa-solid fa-sliders me-1"></i>Durumları Toplu Güncelle
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearBulkSelection()">
                        Seçimi Temizle
                    </button>
                </div>
            </div>

            <!-- Service Selection Tabs -->
            <ul class="nav nav-pills justify-content-center mb-4 gap-2" id="serviceBedsTab" role="tablist">
                @foreach($groupedBeds as $service => $serviceBeds)
                    @php
                        $slug = \Illuminate\Support\Str::slug($service);
                        $isActive = $loop->first;
                    @endphp
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-2 fw-bold rounded-pill @if($isActive) active @endif" 
                                id="tab-{{ $slug }}" 
                                data-bs-toggle="pill" 
                                data-bs-target="#pane-{{ $slug }}" 
                                type="button" 
                                role="tab">
                            <i class="fa-solid fa-hospital-user me-2"></i>{{ $service }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <!-- Service Tab Contents -->
            <div class="tab-content" id="serviceBedsTabContent">
                @foreach($groupedBeds as $service => $serviceBeds)
                    @php
                        $slug = \Illuminate\Support\Str::slug($service);
                        $isActive = $loop->first;
                    @endphp
                    <div class="tab-pane fade @if($isActive) show active @endif" id="pane-{{ $slug }}" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-bed-pulse me-2"></i>{{ $service }} Servisi Odaları ve Yatak Haritası</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    @foreach($serviceBeds as $bed)
                                        <div class="col-lg-2 col-md-3 col-6">
                                            <div class="bed-grid-item bed-{{ $bed['status'] }}" id="bed_card_{{ $bed['id'] }}" data-id="{{ $bed['id'] }}" data-service="{{ $bed['service'] }}" data-status="{{ $bed['status'] }}" onclick="handleBedSelect(this)" style="min-height: 80px; display: flex; flex-direction: column; justify-content: space-between;">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold" style="font-size: 0.95rem;">
                                                        <i class="fa-solid fa-bed me-1"></i>{{ $bed['bed'] }}
                                                    </span>
                                                    <span class="badge bg-white bg-opacity-70 text-dark fs-8">Oda {{ $bed['room'] }}</span>
                                                </div>
                                                <div class="mt-2 text-truncate small" style="font-size: 0.8rem;">
                                                    @if($bed['patient_name'])
                                                        <strong>{{ $bed['patient_name'] }}</strong>
                                                    @else
                                                        <span class="opacity-75">{{ $bed['status_tr'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Admission Entry & Active Inpatients Workspace -->
    <div class="row g-4">
        <!-- New Inpatient Admission Form (Left Column) -->
        <div class="col-lg-5 col-12">
            <div class="card inpatient-card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="card-title fw-bold text-primary mb-0">
                        <i class="fa-solid fa-notes-medical me-2"></i>Yeni Hasta Yatış Girişi
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('inpatient.admission.store') }}" method="POST" id="admissionForm">
                        @csrf
                        
                        <!-- Selected Bed and Service (Set dynamically by Javascript from interactive grid) -->
                        <input type="hidden" name="bed_id" id="selected_bed_id" required>
                        <input type="hidden" name="service" id="selected_service" required>

                        <!-- Selected Bed Indicator Badge -->
                        <div class="alert alert-secondary py-2 px-3 mb-3 d-flex align-items-center justify-content-between" id="selectedBedIndicator">
                            <div>
                                <i class="fa-solid fa-info-circle me-1"></i>
                                <span id="selectedBedText">Lütfen yukarıdaki haritadan <strong>Boş</strong> bir yatak seçin.</span>
                            </div>
                            <span class="badge bg-primary d-none" id="selectedBedBadge">Seçildi</span>
                        </div>

                        <!-- Patient Selection -->
                        <div class="mb-3">
                            <label for="patient_id" class="form-label fw-semibold">Hasta Seçin <span class="text-danger">*</span></label>
                            <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" required>
                                <option value="" disabled selected>-- Yatışı Yapılacak Hastayı Seçin --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient['id'] }}" data-diagnosis="{{ $patient['diagnosis'] }}">
                                        {{ $patient['name'] }} (TC: {{ $patient['national_id'] }} - {{ $patient['age'] }} Yaş)
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Diagnosis -->
                        <div class="mb-3">
                            <label for="diagnosis" class="form-label fw-semibold">Yatış Ön Tanısı / Tanısı <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" rows="2" placeholder="Yatış kararını belirleyen tanı..." required></textarea>
                            @error('diagnosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Attending Physician -->
                        <div class="mb-3">
                            <label for="attending_physician" class="form-label fw-semibold">Sorumlu Hekim <span class="text-danger">*</span></label>
                            <select class="form-select @error('attending_physician') is-invalid @enderror" id="attending_physician" name="attending_physician" required>
                                <option value="" disabled selected>Hekim Seçin</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc['name'] }}">{{ $doc['name'] }} ({{ $doc['specialty'] }})</option>
                                @endforeach
                            </select>
                            @error('attending_physician')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Companion Info -->
                        <div class="mb-4">
                            <label for="companion" class="form-label fw-semibold">Refakatçi Bilgisi (Varsa)</label>
                            <input type="text" class="form-control @error('companion') is-invalid @enderror" id="companion" name="companion" placeholder="Örn: Ayşe Kaya (Eşi)">
                            @error('companion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold" id="submitBtn" disabled>
                                <i class="fa-solid fa-clipboard-check me-2"></i>Hasta Yatış İşlemini Başlat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Active Inpatients List (Right Column) -->
        <div class="col-lg-7 col-12">
            <div class="card inpatient-card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold text-secondary mb-0">
                        <i class="fa-solid fa-list-check me-2"></i>Aktif Yatan Hasta Listesi (Servis İzlem)
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary">{{ count($admissions) }} Hasta Yatıyor</span>
                        <button class="btn btn-outline-primary btn-sm" onclick="printDiv('activeInpatientsTable', 'Aktif Yatan Hasta Listesi')">
                            <i class="fa-solid fa-print"></i> Yazdır
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" id="activeInpatientsTable">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Hasta Bilgisi</th>
                                    <th>Servis / Yatak</th>
                                    <th>Hekim / Tanı</th>
                                    <th class="text-end pe-3">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admissions as $adm)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold">{{ $adm['patient_name'] }}</div>
                                            <div class="text-muted small">TC: {{ $adm['national_id'] }}</div>
                                            <div class="text-muted small">{{ $adm['age'] }} Yaş • {{ $adm['gender'] }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary mb-1 d-inline-block">{{ $adm['service'] }}</span>
                                            <div class="fw-bold" style="font-size: 0.9rem;">
                                                Oda {{ $adm['room'] }} • Yatak {{ $adm['bed'] }}
                                            </div>
                                            <div class="text-muted small">Giriş: {{ $adm['admission_date'] }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-primary" style="font-size: 0.85rem;">{{ $adm['attending_physician'] }}</div>
                                            <div class="text-truncate small text-muted" style="max-width: 180px;" title="{{ $adm['diagnosis'] }}">
                                                {{ $adm['diagnosis'] }}
                                            </div>
                                            <div class="text-muted small">Refakatçi: {{ $adm['companion'] }}</div>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-info" onclick="openTransferModal({{ $adm['id'] }}, '{{ $adm['patient_name'] }}', '{{ $adm['service'] }}', '{{ $adm['room'] }}', '{{ $adm['bed'] }}')">
                                                    <i class="fa-solid fa-arrows-rotate"></i> Transfer
                                                </button>
                                                <a href="{{ route('inpatient.discharge.index', $adm['id']) }}" class="btn btn-outline-danger">
                                                    <i class="fa-solid fa-door-open"></i> Taburcu
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-bed fa-3x mb-3 opacity-30"></i>
                                            <p class="mb-0">Servislerde yatan aktif hasta bulunmamaktadır.</p>
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

<!-- Transfer Modal -->
<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('inpatient.admission.transfer') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold" id="transferModalLabel">
                        <i class="fa-solid fa-exchange-alt me-2"></i>Hasta Servis/Yatak Transferi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Patient Choice -->
                    <div class="mb-3">
                        <label for="transfer_admission_id" class="form-label fw-semibold">Transfer Edilecek Hasta</label>
                        <select class="form-select" name="admission_id" id="transfer_admission_id" required onchange="handleTransferPatientChange(this)">
                            <option value="" disabled selected>Hasta Seçin</option>
                            @foreach($admissions as $adm)
                                <option value="{{ $adm['id'] }}" data-current="Oda {{ $adm['room'] }} • Yatak {{ $adm['bed'] }} ({{ $adm['service'] }})">
                                    {{ $adm['patient_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Current Position Display -->
                    <div class="alert alert-warning py-2 d-none" id="transferCurrentPositionPanel">
                        <strong>Mevcut Konum:</strong> <span id="transferCurrentPositionText">-</span>
                    </div>

                    <!-- New Bed Choice -->
                    <div class="mb-3">
                        <label for="transfer_new_bed_id" class="form-label fw-semibold">Yeni Hedef Yatak (Sadece Boş Olanlar)</label>
                        <select class="form-select" name="new_bed_id" id="transfer_new_bed_id" required>
                            <option value="" disabled selected>Yeni Yatak Seçin</option>
                            @foreach($beds as $bed)
                                @if($bed['status'] === 'bos')
                                    <option value="{{ $bed['id'] }}">
                                        {{ $bed['service'] }} • Oda {{ $bed['room'] }} • Yatak {{ $bed['bed'] }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-info text-white fw-bold"><i class="fa-solid fa-save me-1"></i>Transferi Tamamla</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Bed Modal -->
<div class="modal fade" id="addBedModal" tabindex="-1" aria-labelledby="addBedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('inpatient.beds.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="addBedModalLabel">
                        <i class="fa-solid fa-bed me-2"></i>Yeni Yatak Tanımla
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Service selection -->
                    <div class="mb-3">
                        <label for="bed_service" class="form-label fw-semibold">Servis/Klinik <span class="text-danger">*</span></label>
                        <select class="form-select" name="service" id="bed_service" required>
                            <option value="" disabled selected>Servis Seçin</option>
                            <option value="Genel Cerrahi">Genel Cerrahi</option>
                            <option value="Dahiliye">Dahiliye</option>
                            <option value="Kadın Doğum">Kadın Doğum</option>
                            <option value="Çocuk Sağlığı">Çocuk Sağlığı</option>
                        </select>
                    </div>

                    <!-- Room -->
                    <div class="mb-3">
                        <label for="bed_room" class="form-label fw-semibold">Oda Numarası <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="room" id="bed_room" placeholder="Örn: 102" required>
                    </div>

                    <!-- Bed -->
                    <div class="mb-3">
                        <label for="bed_name" class="form-label fw-semibold">Yatak Numarası/Kodu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="bed" id="bed_name" placeholder="Örn: 102-B" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="bed_status" class="form-label fw-semibold">Yatak Başlangıç Durumu <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" id="bed_status" required>
                            <option value="bos">Boş</option>
                            <option value="temizlik">Temizlik Bekliyor</option>
                            <option value="izolasyon">İzolasyon</option>
                            <option value="izole">İzole Edildi</option>
                            <option value="rezerve">Rezerve</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="fa-solid fa-save me-1"></i>Yatağı Kaydet</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bed Status Manage Modal -->
<div class="modal fade" id="bedStatusModal" tabindex="-1" aria-labelledby="bedStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('inpatient.beds.status.update') }}" method="POST">
            @csrf
            <input type="hidden" name="bed_id" id="status_bed_id">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title fw-bold" id="bedStatusModalLabel">
                        <i class="fa-solid fa-sliders me-2"></i>Yatak Durumunu Güncelle
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-secondary py-2 mb-3">
                        <strong class="d-block" id="statusModalBedName">-</strong>
                        <small class="text-muted" id="statusModalBedService">-</small>
                    </div>

                    <div class="mb-3">
                        <label for="new_status_select" class="form-label fw-semibold">Yeni Yatak Durumu <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" id="new_status_select" required>
                            <option value="bos">Boş (Yatışa Hazır)</option>
                            <option value="temizlik">Temizlik Bekliyor</option>
                            <option value="izolasyon">İzolasyon</option>
                            <option value="izole">İzole Edildi</option>
                            <option value="rezerve">Rezerve</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-info py-2 small" id="statusWarningAlert">
                        <i class="fa-solid fa-info-circle me-1"></i>Durum değiştirildiğinde yatağın hasta ataması güncellenecektir.
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="fa-solid fa-save me-1"></i>Durumu Güncelle</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let selectedBulkBedIds = [];

    // Reset bulk selection on toggle change
    document.getElementById('multiSelectToggle').addEventListener('change', function() {
        clearBulkSelection();
        // Remove active class from single selection too
        document.querySelectorAll('.bed-grid-item').forEach(item => {
            item.classList.remove('active-selection');
        });
        document.getElementById('selected_bed_id').value = '';
        document.getElementById('selected_service').value = '';
        document.getElementById('selectedBedIndicator').className = 'alert alert-secondary py-2 px-3 mb-3 d-flex align-items-center justify-content-between';
        document.getElementById('selectedBedText').innerHTML = 'Lütfen yukarıdaki haritadan <strong>Boş</strong> bir yatak seçin.';
        document.getElementById('selectedBedBadge').classList.add('d-none');
        document.getElementById('submitBtn').disabled = true;
    });

    function clearBulkSelection() {
        selectedBulkBedIds = [];
        document.querySelectorAll('.bed-grid-item').forEach(item => {
            item.classList.remove('border', 'border-3', 'border-primary', 'shadow');
        });
        document.getElementById('bulkActionBar').classList.add('d-none');
        document.getElementById('bulkSelectedCountText').textContent = '0 yatak seçildi.';
    }

    function openBulkStatusModal() {
        if (selectedBulkBedIds.length === 0) return;
        const modal = new bootstrap.Modal(document.getElementById('bedStatusModal'));
        const bedIds = selectedBulkBedIds.join(',');
        document.getElementById('status_bed_id').value = bedIds;
        document.getElementById('statusModalBedName').textContent = `Çoklu Seçilen Yataklar (${selectedBulkBedIds.length} Adet)`;
        document.getElementById('statusModalBedService').textContent = 'Toplu Durum Değişikliği';
        document.getElementById('new_status_select').value = 'bos';
        modal.show();
    }

    // Handles interactive bed click from map
    function handleBedSelect(element) {
        const bedId = parseInt(element.getAttribute('data-id'));
        const service = element.getAttribute('data-service');
        const status = element.getAttribute('data-status');
        const bedName = element.querySelector('.fw-bold').textContent.trim();

        const isMultiSelect = document.getElementById('multiSelectToggle').checked;

        if (isMultiSelect) {
            // Bulk selection logic
            const index = selectedBulkBedIds.indexOf(bedId);
            if (index > -1) {
                // Deselect
                selectedBulkBedIds.splice(index, 1);
                element.classList.remove('border', 'border-3', 'border-primary', 'shadow');
            } else {
                // Select
                selectedBulkBedIds.push(bedId);
                element.classList.add('border', 'border-3', 'border-primary', 'shadow');
            }

            // Update action bar
            const actionBar = document.getElementById('bulkActionBar');
            if (selectedBulkBedIds.length > 0) {
                actionBar.classList.remove('d-none');
                actionBar.style.display = 'flex';
                document.getElementById('bulkSelectedCountText').textContent = `${selectedBulkBedIds.length} yatak seçildi.`;
            } else {
                actionBar.classList.add('d-none');
                actionBar.style.display = 'none';
            }
            return;
        }

        if (status !== 'bos') {
            // Open Bed Status Modal
            const modal = new bootstrap.Modal(document.getElementById('bedStatusModal'));
            document.getElementById('status_bed_id').value = bedId;
            document.getElementById('statusModalBedName').textContent = `Oda & Yatak: ${bedName}`;
            document.getElementById('statusModalBedService').textContent = `${service} Servisi`;
            document.getElementById('new_status_select').value = status;
            modal.show();
            return;
        }

        // Remove active class from all bed elements
        document.querySelectorAll('.bed-grid-item').forEach(item => {
            item.classList.remove('active-selection');
        });

        // Add active class to clicked element
        element.classList.add('active-selection');

        // Set form inputs
        document.getElementById('selected_bed_id').value = bedId;
        document.getElementById('selected_service').value = service;

        // Update selected bed indicator panel
        const indicator = document.getElementById('selectedBedIndicator');
        const text = document.getElementById('selectedBedText');
        const badge = document.getElementById('selectedBedBadge');

        indicator.className = 'alert alert-success py-2 px-3 mb-3 d-flex align-items-center justify-content-between';
        text.innerHTML = `<i class="fa-solid fa-circle-check text-success me-1"></i>Seçilen: <strong>${service} Servisi, Yatak ${bedName}</strong>`;
        badge.classList.remove('d-none');

        // Enable form submit button
        document.getElementById('submitBtn').disabled = false;
    }

    // Pre-fills diagnosis field when patient is selected
    document.getElementById('patient_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const diagnosis = selectedOption.getAttribute('data-diagnosis');
            document.getElementById('diagnosis').value = diagnosis;
        }
    });

    // Modal helpers for Transfer
    function openTransferModal(admissionId, patientName, service, room, bed) {
        const modal = new bootstrap.Modal(document.getElementById('transferModal'));
        const select = document.getElementById('transfer_admission_id');
        
        // Find option and select it
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].value == admissionId) {
                select.selectedIndex = i;
                break;
            }
        }

        document.getElementById('transferCurrentPositionText').textContent = `Oda ${room} • Yatak ${bed} (${service})`;
        document.getElementById('transferCurrentPositionPanel').classList.remove('d-none');
        
        modal.show();
    }

    function handleTransferPatientChange(select) {
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption.value) {
            const currentText = selectedOption.getAttribute('data-current');
            document.getElementById('transferCurrentPositionText').textContent = currentText;
            document.getElementById('transferCurrentPositionPanel').classList.remove('d-none');
        } else {
            document.getElementById('transferCurrentPositionPanel').classList.add('d-none');
        }
    }

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
                ${divToPrint.innerHTML}
            </body>
            </html>
        `);
        newWin.document.close();
    }
</script>
@endpush
