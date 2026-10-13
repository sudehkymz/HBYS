@extends('layouts.app')

@section('title', 'Hemşirelik Gözlem ve Hasta Bakım')

@push('styles')
<style>
    .nursing-card {
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
    .vital-badge {
        font-size: 0.9rem;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
    }
    .badge-bp { background-color: #e1f5fe; color: #0288d1; }
    .badge-pulse { background-color: #ffebee; color: #c62828; }
    .badge-temp { background-color: #fff8e1; color: #f57f17; }
    .badge-spo2 { background-color: #e8f5e9; color: #2e7d32; }

    /* Doctor Select Styles */
    .form-check-input:checked + label {
        background-color: #0d6efd !important;
        color: #fff !important;
        border-color: #0d6efd !important;
    }
    .form-check-input:checked + label .badge {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #fff !important;
    }
    .form-check-input:checked + label i {
        color: #fff !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-user-nurse text-primary me-2"></i>Hemşirelik Gözlem & Hasta Bakım Takip
            </h1>
            <p class="text-muted mb-0">Servisteki yatan hastaların hayati bulgularını kaydedin, ilaç uygulamalarını ve bakım notlarını yönetin.</p>
        </div>
    </div>

    <div class="row">
        <!-- Patient List Sidebar -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card nursing-card">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold text-secondary mb-0">
                            <i class="fa-solid fa-users me-2"></i>Aktif Yatan Hastalar
                        </h5>
                        <span class="badge bg-primary rounded-pill">{{ count($admissions) }} Hasta</span>
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0 table-filter-input" data-dynamic-list-search="#nursingPatientList" placeholder="Hasta adı, oda veya servis ara...">
                    </div>
                </div>
                <div class="list-group list-group-flush" id="nursingPatientList" style="max-height: calc(100vh - 260px); min-height: 400px; overflow-y: auto;">
                    @forelse($admissions as $adm)
                        <a href="{{ route('nursing.index', ['admission_id' => $adm['id']]) }}" 
                           data-admission-id="{{ $adm['id'] }}"
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-secondary">Oda: {{ $adm['room'] }} / Yatak: {{ $adm['bed'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mt-1">
                                <span>{{ $adm['service'] }} Servisi</span>
                                <span>Tanı: {{ Str::limit($adm['diagnosis'], 25) }}</span>
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

        <!-- Inpatient Care Dashboard -->
        <div class="col-lg-8 col-12">
            @if(count($admissions) > 0)
                @foreach($admissions as $adm)
                    @php
                        $activeObservations = isset($observations[$adm['id']]) ? $observations[$adm['id']] : [];
                        $activeMedications = isset($medications[$adm['id']]) ? $medications[$adm['id']] : [];
                        $activeNotes = isset($notes[$adm['id']]) ? $notes[$adm['id']] : [];
                        $isActivePane = ($selectedAdmission && $selectedAdmission['id'] == $adm['id']);
                    @endphp
                    <div class="patient-dashboard-pane" id="patient-pane-{{ $adm['id'] }}" style="display: {{ $isActivePane ? 'block' : 'none' }}">
                        <!-- Patient Info Card -->
                        <div class="card nursing-card mb-4 border-start border-primary border-4">
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
                                        <span class="badge bg-light text-dark p-2 border">Refakatçi: {{ $adm['companion'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-4" id="nursingTab-{{ $adm['id'] }}" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold" id="vitals-tab-{{ $adm['id'] }}" data-bs-toggle="tab" data-bs-target="#vitals-{{ $adm['id'] }}" type="button" role="tab">
                                    <i class="fa-solid fa-heart-pulse me-2"></i>Vital Bulgular (Tansiyon/Ateş)
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="meds-tab-{{ $adm['id'] }}" data-bs-toggle="tab" data-bs-target="#meds-{{ $adm['id'] }}" type="button" role="tab">
                                    <i class="fa-solid fa-pills me-2"></i>İlaç Uygulama Takibi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="notes-tab-{{ $adm['id'] }}" data-bs-toggle="tab" data-bs-target="#notes-{{ $adm['id'] }}" type="button" role="tab">
                                    <i class="fa-solid fa-clipboard-list me-2"></i>Hemşirelik Notları
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="nursingTabContent-{{ $adm['id'] }}">
                            <!-- Vital Signs Tab -->
                            <div class="tab-pane fade show active" id="vitals-{{ $adm['id'] }}" role="tabpanel">
                                <div class="row">
                                    <!-- New Observation Form -->
                                    <div class="col-md-5 col-12 mb-4">
                                        <div class="card nursing-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-plus-circle me-2"></i>Bulgu Girişi</h5>
                                            <form action="{{ route('nursing.observe') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Tansiyon (Sistolik / Diastolik)</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="systolic" placeholder="Büyük (Örn: 120)" required>
                                                        <span class="input-group-text">/</span>
                                                        <input type="number" class="form-control" name="diastolic" placeholder="Küçük (Örn: 80)" required>
                                                        <span class="input-group-text">mmHg</span>
                                                    </div>
                                                </div>

                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label fw-semibold">Nabız</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="pulse" placeholder="Nabız" required>
                                                            <span class="input-group-text">/dk</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label fw-semibold">Ateş</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.1" class="form-control" name="temp" placeholder="Ateş" required>
                                                            <span class="input-group-text">°C</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">SpO2 (Oksijen Satürasyonu)</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="spo2" placeholder="Oksijen seviyesi" required>
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fa-solid fa-save me-1"></i>Hayati Bulguyu Kaydet
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Observations History -->
                                    <div class="col-md-7 col-12 mb-4">
                                        <div class="card nursing-card p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-history me-2"></i>Ölçüm Geçmişi</h5>
                                                <button class="btn btn-outline-primary btn-sm" onclick="printDiv('observationHistoryTable-{{ $adm['id'] }}', 'Hasta Hayati Bulgular Ölçüm Geçmişi')">
                                                    <i class="fa-solid fa-print"></i> Yazdır
                                                </button>
                                            </div>
                                            <div class="table-responsive" id="observationHistoryTable-{{ $adm['id'] }}">
                                                <table class="table table-hover align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Tarih/Saat</th>
                                                            <th>Tansiyon</th>
                                                            <th>Nabız</th>
                                                            <th>Ateş</th>
                                                            <th>SpO2</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($activeObservations as $obs)
                                                            <tr>
                                                                <td><small class="text-muted fw-semibold">{{ $obs['time'] }}</small></td>
                                                                <td><span class="vital-badge badge-bp">{{ $obs['systolic'] }}/{{ $obs['diastolic'] }}</span></td>
                                                                <td><span class="vital-badge badge-pulse">{{ $obs['pulse'] }} bpm</span></td>
                                                                <td><span class="vital-badge badge-temp">{{ $obs['temp'] }} °C</span></td>
                                                                <td><span class="vital-badge badge-spo2">%{{ $obs['spo2'] ?? 98 }}</span></td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center py-4 text-muted">Ölçüm geçmişi bulunmamaktadır.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Medication Administration Tab -->
                            <div class="tab-pane fade" id="meds-{{ $adm['id'] }}" role="tabpanel">
                                <div class="row">
                                    <!-- New Medication Log Form -->
                                    <div class="col-md-5 col-12 mb-4">
                                        <div class="card nursing-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-pills me-2"></i>İlaç Uygulama Girişi</h5>
                                            <form action="{{ route('nursing.medicate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">İlaç Adı</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Örn: Parol 500mg Flakon" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Uygulanan Doz / Yol</label>
                                                    <input type="text" class="form-control" name="dose" placeholder="Örn: 1 Flakon IV" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Uygulayan Personel</label>
                                                    <input type="text" class="form-control" name="nurse" value="Hemşire Meltem Öz" required>
                                                </div>

                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="fa-solid fa-check me-1"></i>Uygulama Girişini Tamamla
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Medication History -->
                                    <div class="col-md-7 col-12 mb-4">
                                        <div class="card nursing-card p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-history me-2"></i>İlaç Kartı & Uygulama Logu</h5>
                                                <button class="btn btn-outline-primary btn-sm" onclick="printDiv('medsHistoryLog-{{ $adm['id'] }}', 'İlaç Kartı & Uygulama Logu')">
                                                    <i class="fa-solid fa-print"></i> Yazdır
                                                </button>
                                            </div>
                                            <div class="list-group" id="medsHistoryLog-{{ $adm['id'] }}">
                                                @forelse($activeMedications as $med)
                                                    <div class="list-group-item border-0 border-bottom py-3">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h6 class="fw-bold mb-1 text-success"><i class="fa-solid fa-circle-check me-2"></i>{{ $med['name'] }}</h6>
                                                            <span class="badge bg-success-subtle text-success">{{ $med['status'] }}</span>
                                                        </div>
                                                        <p class="mb-1 text-muted small"><strong>Doz / Yol:</strong> {{ $med['dose'] }}</p>
                                                        <div class="d-flex justify-content-between text-muted small mt-1">
                                                            <span>Uygulayan: {{ $med['nurse'] }}</span>
                                                            <span>Tarih: {{ $med['time'] }}</span>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="text-center py-5 text-muted">
                                                        <i class="fa-solid fa-circle-info fa-2x mb-2 opacity-50"></i>
                                                        <p class="mb-0">Uygulanan ilaç kaydı bulunmamaktadır.</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nursing Notes Tab -->
                            <div class="tab-pane fade" id="notes-{{ $adm['id'] }}" role="tabpanel">
                                <div class="row">
                                    <!-- New Note Form -->
                                    <div class="col-md-5 col-12 mb-4">
                                        <div class="card nursing-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-pen-fancy me-2"></i>Not Ekle</h5>
                                            <form action="{{ route('nursing.note') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Hemşire Adı</label>
                                                    <input type="text" class="form-control" name="nurse" value="Hemşire Meltem Öz" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-secondary">
                                                        <i class="fa-solid fa-user-doctor me-1 text-primary"></i> Doktor Seçin (Notu İletmek İçin)
                                                    </label>
                                                    <div class="d-flex flex-wrap gap-2 p-3 border rounded bg-light" style="max-height: 150px; overflow-y: auto;">
                                                        @foreach($doctors as $doc)
                                                            <div class="form-check form-check-inline m-0">
                                                                <input class="form-check-input d-none" type="checkbox" name="doctor_ids[]" id="doc_{{ $doc->id }}_{{ $adm['id'] }}" value="{{ $doc->id }}">
                                                                <label class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 fw-semibold shadow-sm transition-all" for="doc_{{ $doc->id }}_{{ $adm['id'] }}" style="cursor: pointer; font-size: 0.82rem;">
                                                                    <i class="fa-solid fa-plus me-1 text-primary"></i>{{ $doc->name }} 
                                                                    <span class="badge bg-secondary-subtle text-dark ms-1" style="font-size: 0.65rem;">{{ $doc->specialty ?? 'Doktor' }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="form-text text-muted small">Notun otomatik olarak iletileceği doktorları yukarıdan seçebilirsiniz.</div>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Klinik Notu</label>
                                                    <textarea class="form-control" name="note" rows="5" placeholder="Hastanın klinik durumu ve bakımıyla ilgili not yazın..." required></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-secondary w-100">
                                                    <i class="fa-solid fa-save me-1"></i>Klinik Notu Ekle & Gönder
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Notes History -->
                                    <div class="col-md-7 col-12 mb-4">
                                        <div class="card nursing-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-list-ul me-2"></i>Klinik Not Defteri</h5>
                                            <div class="timeline" style="border-left: 2px solid #dee2e6; padding-left: 20px; margin-left: 10px;">
                                                @forelse($activeNotes as $note)
                                                    <div class="mb-4 position-relative">
                                                        <div class="position-absolute bg-secondary" style="width: 12px; height: 12px; border-radius: 50%; left: -27px; top: 6px;"></div>
                                                        <div class="bg-light p-3 rounded">
                                                            <div class="d-flex justify-content-between text-muted small mb-2 fw-semibold">
                                                                <span>{{ $note['nurse'] }}</span>
                                                                <span>{{ $note['time'] }}</span>
                                                            </div>
                                                            <p class="mb-0 small text-dark">{{ $note['note'] }}</p>
                                                            
                                                            @if(!empty($note['sent_doctors']))
                                                                <div class="mt-2 pt-2 border-top border-secondary-subtle">
                                                                    <small class="text-primary fw-semibold d-block mb-1" style="font-size: 0.78rem;">
                                                                        <i class="fa-solid fa-paper-plane me-1"></i> İletilen Doktorlar:
                                                                    </small>
                                                                    <div class="d-flex flex-wrap gap-1">
                                                                        @foreach($note['sent_doctors'] as $docName)
                                                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-1" style="font-size: 0.72rem; font-weight: 500;">
                                                                                <i class="fa-solid fa-user-doctor me-1"></i>{{ $docName }}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="text-center py-5 text-muted">
                                                        <p class="mb-0">Kayıtlı klinik not bulunmamaktadır.</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card nursing-card p-5 text-center text-muted">
                    <i class="fa-solid fa-hospital-user fa-4x mb-3 opacity-30"></i>
                    <h5 class="fw-bold text-secondary">Hasta Seçimi Yapın</h5>
                    <p class="mb-0">Hemşirelik gözlem ve bakım işlemlerine başlamak için sol menüden bir hasta seçin.</p>
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
