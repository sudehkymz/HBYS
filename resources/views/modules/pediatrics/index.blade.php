@extends('layouts.app')

@section('title', 'Pediatri Çekirdek Motoru & 19 Yan Dal Yönetimi')

@push('styles')
<style>
    .ped-card {
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
        background-color: #eef2ff;
        border-left-color: #4f46e5;
    }
    .subtab-btn {
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.82rem;
        padding: 8px 14px;
        margin-right: 4px;
        margin-bottom: 6px;
    }
    .joint-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        font-weight: bold;
        font-size: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Top Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">
                <i class="fa-solid fa-child-reaching text-indigo me-2"></i>Pediatri Çekirdek Motoru & 19 Yan Dal Sistemi
            </h1>
            <p class="text-muted mb-0">Hasta + Vasi Çifti, Hemşire Triyaj Kilo Kuralı, Akıllı Dozaj ($mg/kg$), Persentil & Z-Skor ve Gizli Protokol.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-indigo text-white px-3 py-2 rounded-pill fs-6">
                <i class="fa-solid fa-shield-halved me-1"></i>Çekirdek V2.5 Aktif
            </span>
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
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Patient Selection Column -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card ped-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-children me-2 text-indigo"></i>Pediatrik Hasta Listesi
                    </h5>
                    <span class="badge bg-indigo-subtle text-indigo rounded-pill">{{ count($pediatricAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 700px; overflow-y: auto;">
                    @forelse($pediatricAdmissions as $adm)
                        <a href="{{ route('pediatrics.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge {{ $adm['triage']['completed'] ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border">
                                    {{ $adm['triage']['completed'] ? $adm['triage']['weight'].' kg' : 'Kilo Eksik!' }}
                                </span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-user-nurse me-1"></i>Vasi: {{ $adm['guardian']['name'] ?? 'Tanımsız' }} ({{ $adm['guardian']['relation'] ?? '-' }})</div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-hospital me-1"></i>{{ $adm['service'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-child-reaching fa-3x mb-3 opacity-30"></i>
                            <p>Aktif çocuk hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                @php
                    $triage = $selectedAdmission['triage'];
                    $guardian = $selectedAdmission['guardian'];
                @endphp

                <!-- 1. Patient & Guardian Sticky Header Card -->
                <div class="card ped-card mb-4 border-start border-indigo border-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7 col-12 mb-3 mb-md-0">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-indigo text-white">Pediatri Hasta & Vasi Kartı</span>
                                    <span class="badge bg-light text-dark border"><i class="fa-solid fa-id-card me-1"></i>T.C.: {{ $selectedAdmission['national_id'] }}</span>
                                </div>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>Yaş:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['age_months'] }} Ay) | 
                                    <strong>Cinsiyet:</strong> {{ $selectedAdmission['gender'] }} | 
                                    <strong>Oda:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-shield text-indigo me-1"></i>
                                    <strong>Yasal Vasi:</strong> {{ $guardian['name'] }} ({{ $guardian['relation'] }}) | 
                                    <strong>Vasi T.C.:</strong> {{ $guardian['tc'] }} | 
                                    <strong>Dijital Onam:</strong> 
                                    <span class="badge {{ $guardian['consent_signed'] ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $guardian['consent_signed'] ? 'İmzalandı' : 'Bekleniyor' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5 col-12 text-md-end">
                                <!-- Vitals & Triage Badge Summary -->
                                @if($triage['completed'])
                                    <div class="p-3 bg-indigo-subtle rounded-3 border border-indigo-subtle">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small fw-bold text-indigo">Kilo / Boy:</span>
                                            <span class="fw-bold text-dark">{{ $triage['weight'] }} kg / {{ $triage['height'] }} cm</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small fw-bold text-indigo">BSA (VYA $m^2$):</span>
                                            <span class="fw-bold text-indigo">{{ $bsaM2 }} $m^2$</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="small fw-bold text-indigo">Persentil:</span>
                                            <span class="badge {{ $growthData['badge_class'] ?? 'bg-success' }}">
                                                {{ $growthData['percentile_label'] ?? 'Standart' }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-3 bg-danger-subtle rounded-3 border border-danger-subtle text-center">
                                        <i class="fa-solid fa-lock text-danger fa-2x mb-2"></i>
                                        <div class="fw-bold text-danger">KİLO BİLGİSİ EKSİK!</div>
                                        <div class="small text-muted mb-2">Hemşire Triyajında kilo girilmeden doktor reçetesi pasiftir.</div>
                                        <button class="btn btn-danger btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#triageModal">
                                            <i class="fa-solid fa-weight-scale me-1"></i>Hemşire Triyaj Verisi Gir
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Nurse Triage Modal -->
                <div class="modal fade" id="triageModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow">
                            <div class="modal-header bg-indigo text-white py-3">
                                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-nurse me-2"></i>Hemşire Triyaj & Ölçüm Giriş Formu</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('pediatrics.store_triage') }}" method="POST">
                                @csrf
                                <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-danger">Vücut Ağırlığı (Kilo) *</label>
                                            <div class="input-group">
                                                <input type="number" step="0.1" name="weight" class="form-control fw-bold border-danger" value="{{ $triage['weight'] ?? '' }}" required placeholder="ör: 16.5">
                                                <span class="input-group-text bg-danger text-white">kg</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold">Boy Uzunluğu *</label>
                                            <div class="input-group">
                                                <input type="number" step="0.5" name="height" class="form-control" value="{{ $triage['height'] ?? '' }}" required placeholder="ör: 102">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Baş Çevresi (0-3 Yaş)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.5" name="head_circ" class="form-control" value="{{ $triage['head_circ'] ?? '' }}" placeholder="ör: 50">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Vücut Sıcaklığı (Ateş) *</label>
                                            <div class="input-group">
                                                <input type="number" step="0.1" name="temp" class="form-control" value="{{ $triage['temp'] ?? 36.8 }}" required>
                                                <span class="input-group-text">°C</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Nabız *</label>
                                            <input type="number" name="pulse" class="form-control" value="{{ $triage['pulse'] ?? 100 }}" required placeholder="atım/dk">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Kan Basıncı (Tansiyon)</label>
                                            <input type="text" name="bp" class="form-control" value="{{ $triage['bp'] ?? '95/60' }}" placeholder="ör: 95/60">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-indigo text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i>Triyaj Kaydını Onayla & Reçete Kilidini Aç</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 3. Smart Dosing Engine ($mg/kg$ & BSA $m^2$) Simulation Card -->
                <div class="card ped-card mb-4 bg-light">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-indigo mb-0">
                            <i class="fa-solid fa-calculator me-2"></i>Akıllı Dozaj Güvenlik Motoru ($mg/kg$ & BSA $m^2$)
                        </h6>
                        <button class="btn btn-outline-indigo btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#triageModal">
                            <i class="fa-solid fa-pen me-1"></i>Triyaj / Ölçüm Düzenle
                        </button>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12 mb-3 mb-md-0">
                                <label class="form-label small fw-bold">Reçete İlaç Seçimi</label>
                                <select class="form-select" id="doseDrugSelect">
                                    <option value="Parasetamol">Parasetamol (Ağrı/Ateş - 10-15 mg/kg)</option>
                                    <option value="İbuprofen">İbuprofen (Antiinflamatuar - 5-10 mg/kg)</option>
                                    <option value="Amoksisilin">Amoksisilin (Antibiyotik - 40-90 mg/kg)</option>
                                    <option value="Prednol">Prednol (Kortikosteroid - 1-2 mg/kg)</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label small fw-bold">Planlanan Tek Doz (mg)</label>
                                <div class="input-group">
                                    <input type="number" id="doseInput" class="form-control" value="180" placeholder="mg">
                                    <button class="btn btn-indigo text-white fw-bold" type="button" id="checkDoseBtn">
                                        <i class="fa-solid fa-shield-check me-1"></i>Doz Kontrol Et
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 mt-3" id="doseAlertBox" style="display: none;"></div>
                        </div>
                    </div>
                </div>

                <!-- 4. WHO & Neyzi Growth Percentile & Z-Score Card -->
                @if($growthData)
                    <div class="card ped-card mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="fa-solid fa-chart-line me-2 text-indigo"></i>Büyüme & Persentil Değerlendirme Çizelgesi (DSÖ / Neyzi)
                            </h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-3 text-center">
                                <div class="col-md-3 col-6 p-2 border rounded-3 bg-light">
                                    <div class="text-muted small">Kilo Persentili</div>
                                    <div class="fw-bold text-dark fs-5">{{ $triage['weight'] }} kg</div>
                                    <span class="badge {{ $growthData['badge_class'] }} mt-1">{{ $growthData['percentile_label'] }}</span>
                                </div>
                                <div class="col-md-3 col-6 p-2 border rounded-3 bg-light">
                                    <div class="text-muted small">Boy Uzunluğu</div>
                                    <div class="fw-bold text-dark fs-5">{{ $triage['height'] }} cm</div>
                                    <span class="badge bg-secondary mt-1">Standart Eğri</span>
                                </div>
                                <div class="col-md-3 col-6 p-2 border rounded-3 bg-light">
                                    <div class="text-muted small">VKİ (BMI) / VYA ($m^2$)</div>
                                    <div class="fw-bold text-indigo fs-5">{{ $growthData['bmi'] }} kg/$m^2$</div>
                                    <span class="badge bg-indigo-subtle text-indigo mt-1">BSA: {{ $bsaM2 }} $m^2$</span>
                                </div>
                                <div class="col-md-3 col-6 p-2 border rounded-3 bg-light">
                                    <div class="text-muted small">Z-Skoru (SD)</div>
                                    <div class="fw-bold text-dark fs-5">{{ $growthData['z_score'] }}</div>
                                    <span class="badge bg-info mt-1">Neyzi Standartı</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- 5. Sağlık Bakanlığı Aşı Takip Matrisi -->
                <div class="card ped-card mb-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-syringe me-2 text-indigo"></i>T.C. Sağlık Bakanlığı + Özel Aşı Takvimi
                        </h6>
                        <span class="small text-muted">Yaş: {{ $selectedAdmission['age'] }} Yaş</span>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-2">
                            @foreach($vaccines as $v)
                                <div class="col-md-4 col-6">
                                    <div class="p-2 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold small text-dark">{{ $v['name'] }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ $v['period'] }} ({{ $v['category'] }})</div>
                                        </div>
                                        <span class="badge {{ $v['status_class'] }} small">{{ $v['status'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 6. 19 Sub-Specialty Interactive Workspace -->
                <div class="card ped-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-microscope me-2 text-indigo"></i>19 Yan Dal Dinamik Modül Ekranı
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Nav Sub-Specialty Pills -->
                        <div class="d-flex flex-wrap mb-3 border-bottom pb-2" role="tablist">
                            @foreach($subSpecialties as $key => $spec)
                                <button class="btn btn-outline-secondary subtab-btn {{ $loop->first ? 'active bg-indigo text-white' : '' }}" 
                                        data-bs-toggle="pill" data-bs-target="#tab-{{ $key }}" type="button">
                                    <i class="fa-solid {{ $spec['icon'] }} me-1"></i>{{ $spec['name'] }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Tab Content for 19 Sub-specialties -->
                        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
                            
                            <div class="tab-content" id="subSpecialtyTabsContent">
                                <!-- 1. Neonatoloji -->
                                <div class="tab-pane fade show active" id="tab-neonatology">
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <h6 class="fw-bold text-indigo mb-3"><i class="fa-solid fa-baby me-2"></i>Neonatoloji & Yenidoğan Yoğun Bakım Ekranı</h6>
                                        <div class="row g-3">
                                            <div class="col-md-3 col-6">
                                                <label class="form-label small fw-bold">Doğum Haftası</label>
                                                <input type="text" class="form-control" placeholder="ör: 31+4 Hafta">
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <label class="form-label small fw-bold">APGAR (1. dk / 5. dk)</label>
                                                <input type="text" class="form-control" placeholder="ör: 8 / 10">
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <label class="form-label small fw-bold">Bilirubin (mg/dL)</label>
                                                <input type="number" step="0.1" class="form-control" placeholder="ör: 14.2 (Fototerapi Nomogramı)">
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <label class="form-label small fw-bold">TPN Sıvı Hesabı (mL/kg/gün)</label>
                                                <input type="number" class="form-control" placeholder="ör: 120 mL/kg">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Hematoloji & Onkoloji -->
                                <div class="tab-pane fade" id="tab-pediatric_hematology_oncology">
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <h6 class="fw-bold text-danger mb-3"><i class="fa-solid fa-droplet me-2"></i>Çocuk Hematolojisi & Onkolojisi Ekranı</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">Mutlak Nötrofil (ANS) Hesabı</label>
                                                <input type="text" class="form-control fw-bold text-danger" value="ANS = Lökosit x (%Nötrofil + %Çomak) / 100" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">Kemoterapi Kür Takvimi</label>
                                                <input type="text" class="form-control" placeholder="ör: Siklus 2 / 4. Gün (ALL Protokolü)">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">Kan Ürünü İstem</label>
                                                <select class="form-select">
                                                    <option>Eritrosit Süspansiyonu (EKT)</option>
                                                    <option>Trombosit Süspansiyonu</option>
                                                    <option>Taze Donmuş Plazma (TDP)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Nefroloji -->
                                <div class="tab-pane fade" id="tab-pediatric_nephrology">
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <h6 class="fw-bold text-indigo mb-3"><i class="fa-solid fa-kidney me-2"></i>Çocuk Nefrolojisi & eGFR Schwartz Formülü</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">Schwartz Formülü eGFR</label>
                                                <input type="text" class="form-control fw-bold text-indigo" value="eGFR = k x Boy / Kreatinin" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">24 Saatlik İdrar Protein/Cr</label>
                                                <input type="number" step="0.01" class="form-control" placeholder="ör: 0.15 mg/mg">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">Tansiyon Persentili</label>
                                                <select class="form-select">
                                                    <option>Normotansif (<90. Persentil)</option>
                                                    <option>Prehipertansif (90-95. Persentil)</option>
                                                    <option>Evre 1 Hipertansiyon (>95. Persentil)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Romatoloji (Eklem Haritası) -->
                                <div class="tab-pane fade" id="tab-pediatric_rheumatology">
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-bone me-2"></i>İnteraktif Eklem Haritası (JIA Jüvenil Artrit)</h6>
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <button type="button" class="btn btn-outline-danger joint-btn">Sağ Diz</button>
                                            <button type="button" class="btn btn-outline-danger joint-btn">Sol Diz</button>
                                            <button type="button" class="btn btn-outline-danger joint-btn">Sağ El</button>
                                            <button type="button" class="btn btn-outline-danger joint-btn">Sol El</button>
                                            <button type="button" class="btn btn-outline-danger joint-btn">Bilek</button>
                                            <button type="button" class="btn btn-outline-danger joint-btn">Ayak</button>
                                        </div>
                                        <span class="small text-muted">Şişlik veya ağrı olan eklemlere tıklayınız</span>
                                    </div>
                                </div>

                                <!-- 5. Alerji & İmmünoloji (Deri Prick Testi) -->
                                <div class="tab-pane fade" id="tab-pediatric_allergy_immunology">
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <h6 class="fw-bold text-warning-emphasis mb-3"><i class="fa-solid fa-allergies me-2"></i>Deri Prick Testi Görsel Alerjen Haritası</h6>
                                        <div class="row g-2">
                                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" value="Ev Tozu Mite: 6 mm" readonly></div>
                                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" value="İnek Sütü: 4 mm" readonly></div>
                                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" value="Yumurta Akı: 8 mm" readonly></div>
                                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" value="Polen: 0 mm (Negatif)" readonly></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 6. Çocuk Psikiyatrisi (Gizli Protokol) -->
                                <div class="tab-pane fade" id="tab-pediatric_psychiatry">
                                    <div class="p-3 bg-warning-subtle rounded-3 border border-warning mb-3">
                                        <div class="d-flex align-items-center mb-2 text-warning-emphasis fw-bold">
                                            <i class="fa-solid fa-user-lock fa-2x me-2"></i>
                                            <div>
                                                <div>Çocuk ve Ergen Ruh Sağlığı (Gizli Protokol)</div>
                                                <div class="small fw-normal">Psikiyatri notları diğer poliklinik hekimlerinden gizlenir.</div>
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-1">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">WISC-IV / MOXO Skoru</label>
                                                <input type="text" class="form-control" placeholder="ör: WISC-IV Toplam İÇ: 112 (Normal Üstü)">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Okul Rehberlik Bildirim Formu</label>
                                                <button type="button" class="btn btn-dark btn-sm w-100 mt-1"><i class="fa-solid fa-file-pdf me-1"></i>Rehberlik Formu Oluştur</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Default Generic Form for rest of subspecialties -->
                                @foreach($subSpecialties as $key => $spec)
                                    @if(!in_array($key, ['neonatology', 'pediatric_hematology_oncology', 'pediatric_nephrology', 'pediatric_rheumatology', 'pediatric_allergy_immunology', 'pediatric_psychiatry']))
                                        <div class="tab-pane fade" id="tab-{{ $key }}">
                                            <div class="p-3 bg-light rounded-3 border mb-3">
                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid {{ $spec['icon'] }} me-2 text-indigo"></i>{{ $spec['name'] }} Spesifik Paneli</h6>
                                                <p class="small text-muted mb-0">Bu branş için özel dinamik klinik alanlar ve laboratuvar şablonları yüklenmiştir.</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Common Exam Notes & Submit -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Klinik Muayene, Reçete & Branş Notları *</label>
                                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Fizik muayene bulguları, reçete edilen ilaçlar ($mg/kg$), takip ve kontrol kararı..."></textarea>
                            </div>

                            <input type="hidden" name="sub_specialty" id="selectedSubSpecialtyInput" value="pediatrics_general">

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: {{ auth()->user()->name ?? 'Prof. Dr. Ahmet Can' }}</span>
                                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2 shadow-sm" {{ !$triage['completed'] ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Muayene & Reçete Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card ped-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-child-reaching fa-4x text-indigo mb-3 opacity-40"></i>
                        <h5>Pediatrik Hasta Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayene ve yan dal değerlendirmesi yapmak istediğiniz çocuk hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sub-specialty tab click tracking
        const tabBtns = document.querySelectorAll('.subtab-btn');
        const subInput = document.getElementById('selectedSubSpecialtyInput');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                tabBtns.forEach(b => b.classList.remove('active', 'bg-indigo', 'text-white'));
                this.classList.add('active', 'bg-indigo', 'text-white');
                const target = this.getAttribute('data-bs-target').replace('#tab-', '');
                if (subInput) {
                    subInput.value = target;
                }
            });
        });

        // Dose safety check button click
        const checkDoseBtn = document.getElementById('checkDoseBtn');
        const doseDrugSelect = document.getElementById('doseDrugSelect');
        const doseInput = document.getElementById('doseInput');
        const alertBox = document.getElementById('doseAlertBox');

        if (checkDoseBtn && alertBox) {
            checkDoseBtn.addEventListener('click', function() {
                const drug = doseDrugSelect.value;
                const dose = doseInput.value;
                const weight = {{ $triage['weight'] ?? 16.5 }};

                fetch('{{ route("pediatrics.calculate_dose") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        drug_name: drug,
                        weight: weight,
                        prescribed_dose: dose
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alertBox.style.display = 'block';
                    if (!data.safe) {
                        alertBox.className = 'col-12 mt-3 alert alert-danger fw-bold';
                        alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-2"></i>' + data.warning + ' (Önerilen: ' + data.recommended_dose + ')';
                    } else if (data.warning) {
                        alertBox.className = 'col-12 mt-3 alert alert-warning fw-bold';
                        alertBox.innerHTML = '<i class="fa-solid fa-circle-info me-2"></i>' + data.warning;
                    } else {
                        alertBox.className = 'col-12 mt-3 alert alert-success fw-bold';
                        alertBox.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i>Doz Güvenli! Önerilen Doz Aralığı: ' + data.recommended_dose;
                    }
                })
                .catch(err => {
                    console.error(err);
                });
            });
        }
    });
</script>
@endpush
@endsection
