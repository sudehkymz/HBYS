@extends('layouts.app')

@section('title', 'Kadın Doğum ve Yenidoğan Modülü')

@push('styles')
<style>
    .obs-card {
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
    .badge-status {
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
                <i class="fa-solid fa-baby-carriage text-primary me-2"></i>Kadın Doğum & Yenidoğan Kayıt Paneli
            </h1>
            <p class="text-muted mb-0">Gebe takibi yapın, doğum işlemlerini tamamlayın ve yenidoğan kartlarını yönetin.</p>
        </div>
    </div>

    <div class="row">
        <!-- Patient List Sidebar -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card obs-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold text-secondary mb-0">
                        <i class="fa-solid fa-person-dress me-2"></i>Gebelik Takip Listesi (Kadın Hastalar)
                    </h5>
                </div>
                <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                    @forelse($femaleAdmissions as $adm)
                        <a href="{{ route('obstetrics.index', ['admission_id' => $adm['id']]) }}" 
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
                            <i class="fa-solid fa-venus fa-3x mb-3 opacity-30"></i>
                            <p class="mb-0">Aktif kadın hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Work Area -->
        <div class="col-lg-8 col-12">
            @if(count($femaleAdmissions) > 0)
                @foreach($femaleAdmissions as $adm)
                    @php
                        $activePregnancy = isset($pregnancies[$adm['id']]) ? $pregnancies[$adm['id']] : null;
                        $activeDelivery = isset($deliveries[$adm['id']]) ? $deliveries[$adm['id']] : null;
                        $isActivePane = ($selectedAdmission && $selectedAdmission['id'] == $adm['id']);
                    @endphp
                    <div class="patient-dashboard-pane" id="patient-pane-{{ $adm['id'] }}" style="display: {{ $isActivePane ? 'block' : 'none' }}">
                        <!-- Patient Info Card -->
                        <div class="card obs-card mb-4 border-start border-primary border-4">
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
                                        @if($activePregnancy)
                                            <span class="badge-status bg-info text-white" id="badge-status-{{ $adm['id'] }}">{{ $activePregnancy['status'] }}</span>
                                        @else
                                            <span class="badge-status bg-warning text-dark" id="badge-status-{{ $adm['id'] }}">Kart Açılmamış</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-4" id="obsTab-{{ $adm['id'] }}" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold" id="pre-tab-{{ $adm['id'] }}" data-bs-toggle="tab" data-bs-target="#pre-{{ $adm['id'] }}" type="button" role="tab">
                                    <i class="fa-solid fa-file-waveform me-2"></i>1. Gebelik & Takip Kaydı
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="birth-tab-{{ $adm['id'] }}" data-bs-toggle="tab" data-bs-target="#birth-{{ $adm['id'] }}" type="button" role="tab" @if(!$activePregnancy) disabled @endif>
                                    <i class="fa-solid fa-child me-2"></i>2. Doğum Girişi (Yenidoğan)
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="obsTabContent-{{ $adm['id'] }}">
                            <!-- 1. Pregnancy Tab -->
                            <div class="tab-pane fade show active" id="pre-{{ $adm['id'] }}" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card obs-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-notes-medical me-2"></i>Gebelik Takip Formu</h5>
                                            <form action="{{ route('obstetrics.pregnancy') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Son Adet Tarihi (SAT)</label>
                                                    <input type="text" class="form-control" name="lmp" placeholder="Örn: 15.10.2025" value="{{ $activePregnancy['lmp'] ?? '' }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Gebelik Haftası</label>
                                                    <input type="number" class="form-control" name="week" placeholder="Örn: 38" value="{{ $activePregnancy['week'] ?? '' }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Risk Seviyesi</label>
                                                    <select class="form-select" name="risk" required>
                                                        <option value="Normal" {{ ($activePregnancy && $activePregnancy['risk'] == 'Normal') ? 'selected' : '' }}>Normal (Düşük Risk)</option>
                                                        <option value="Yüksek Riskli" {{ ($activePregnancy && $activePregnancy['risk'] == 'Yüksek Riskli') ? 'selected' : '' }}>Yüksek Riskli</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Sorumlu Ebe</label>
                                                    <input type="text" class="form-control" name="midwife" placeholder="Ebe Adı Soyadı" value="{{ $activePregnancy['midwife'] ?? 'Ebe Fatma Şen' }}" required>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fa-solid fa-save me-1"></i>Gebelik Kaydını Oluştur / Güncelle
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card obs-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-info-circle me-2"></i>Takip Detayı</h5>
                                            @if($activePregnancy)
                                                <div class="bg-light p-3 rounded">
                                                    <p class="mb-2"><strong>Son Adet Tarihi:</strong> {{ $activePregnancy['lmp'] }}</p>
                                                    <p class="mb-2"><strong>Gebelik Haftası:</strong> {{ $activePregnancy['week'] }}</p>
                                                    <p class="mb-2"><strong>Risk Seviyesi:</strong> {{ $activePregnancy['risk'] }}</p>
                                                    <p class="mb-2"><strong>Sorumlu Ebe:</strong> {{ $activePregnancy['midwife'] }}</p>
                                                    <p class="mb-0"><strong>Kart Durumu:</strong> <span class="badge bg-success">{{ $activePregnancy['status'] }}</span></p>
                                                </div>
                                            @else
                                                <p class="text-muted text-center py-5">Bu hasta için henüz gebelik takibi başlatılmamıştır.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Delivery Tab -->
                            <div class="tab-pane fade" id="birth-{{ $adm['id'] }}" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card obs-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-baby me-2"></i>Doğum Sonu Bebek Girişi</h5>
                                            <form action="{{ route('obstetrics.delivery') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Doğum Tarihi & Saat</label>
                                                    <input type="text" class="form-control" name="birth_date" placeholder="Örn: 27.07.2026 14:00" value="{{ now()->format('d.m.Y H:i') }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Cinsiyet</label>
                                                    <select class="form-select" name="baby_gender" required>
                                                        <option value="Kız">Kız</option>
                                                        <option value="Erkek">Erkek</option>
                                                    </select>
                                                </div>

                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label fw-semibold">Doğum Ağırlığı</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="weight" placeholder="Örn: 3200" required>
                                                            <span class="input-group-text">gr</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label fw-semibold">Boy</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="height" placeholder="Örn: 50" required>
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">APGAR Skoru (1. / 5. dakika)</label>
                                                    <input type="number" class="form-control" name="apgar" placeholder="0-10 arası" min="0" max="10" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Nöbetçi Çocuk Uzmanı</label>
                                                    <input type="text" class="form-control" name="pediatrician" value="Dr. Selin Saygı" required>
                                                </div>

                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="fa-solid fa-check me-1"></i>Doğumu Kaydet & Bebek Kartı Aç
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 mb-4">
                                        <div class="card obs-card p-4">
                                            <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-child-dress me-2"></i>Doğum Kaydı</h5>
                                            @if($activeDelivery)
                                                <div class="alert alert-success">
                                                    <i class="fa-solid fa-circle-check me-2"></i>Doğum Kaydı Tamamlandı
                                                </div>
                                                <div class="bg-light p-3 rounded" id="birthRecordArea-{{ $adm['id'] }}">
                                                    <p class="mb-2"><strong>Anne Adı:</strong> {{ $adm['patient_name'] }}</p>
                                                    <p class="mb-2"><strong>Doğum Tarihi:</strong> {{ $activeDelivery['birth_date'] }}</p>
                                                    <p class="mb-2"><strong>Cinsiyet:</strong> {{ $activeDelivery['baby_gender'] }}</p>
                                                    <p class="mb-2"><strong>Ağırlık/Boy:</strong> {{ $activeDelivery['weight'] }} gr / {{ $activeDelivery['height'] }} cm</p>
                                                    <p class="mb-2"><strong>APGAR Skoru:</strong> {{ $activeDelivery['apgar'] }}</p>
                                                    <p class="mb-0"><strong>Çocuk Uzmanı:</strong> {{ $activeDelivery['pediatrician'] }}</p>
                                                </div>
                                                <button class="btn btn-outline-primary btn-sm mt-3 w-100" onclick="printDiv('birthRecordArea-{{ $adm['id'] }}', 'Yenidoğan Doğum Kayıt Belgesi')">
                                                    <i class="fa-solid fa-print me-1"></i>Doğum Kaydını Yazdır
                                                </button>
                                            @else
                                                <p class="text-muted text-center py-5">Doğum kaydı henüz bulunmamaktadır. Bilgileri girdikten sonra yenidoğan hasta kartı sistemde otomatik olarak açılacaktır.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card obs-card p-5 text-center text-muted">
                    <i class="fa-solid fa-hospital-user fa-4x mb-3 opacity-30"></i>
                    <h5 class="fw-bold text-secondary">Hasta Seçimi Yapın</h5>
                    <p class="mb-0">Kadın doğum ve yenidoğan işlemlerine başlamak için sol menüden bir hasta seçin.</p>
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
