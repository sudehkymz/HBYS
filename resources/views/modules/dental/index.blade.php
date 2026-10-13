@extends('layouts.app')

@section('title', 'Diş Hekimliği (Odontoloji) & Ağız Sağlığı Poliklinikleri')

@push('styles')
<style>
    .dental-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
    }
    .tooth-btn {
        width: 42px;
        height: 48px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 2px;
        transition: all 0.2s ease;
        border: 2px solid #e2e8f0;
        background-color: #f8fafc;
        cursor: pointer;
    }
    .tooth-btn:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }
    .tooth-btn.selected {
        background-color: #0ea5e9;
        color: white;
        border-color: #0284c7;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
    }
    .patient-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    .patient-item:hover {
        background-color: #f8f9fa;
    }
    .patient-item.active {
        background-color: #f0f9ff;
        border-left-color: #0ea5e9;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">
                <i class="fa-solid fa-tooth text-info me-2"></i>Diş Hekimliği (Odontoloji) & Ağız Sağlığı Poliklinikleri
            </h1>
            <p class="text-muted mb-0">ADSM ve Hastane Diş Klinikleri Odontogram (Diş Şeması) ve 9 Branş Tedavi Yönetimi.</p>
        </div>
        <div>
            <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill">
                <i class="fa-solid fa-tooth me-1"></i>9 Ağız & Diş Sağlığı Branşı Aktif
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column: Dental Patient List -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card dental-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-info"></i>Diş Klinik Hasta Listesi
                    </h5>
                    <span class="badge bg-secondary rounded-pill">{{ count($dentalAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 650px; overflow-y: auto;">
                    @forelse($dentalAdmissions as $adm)
                        <a href="{{ route('dental.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-info-subtle text-info border border-info-subtle">
                                    {{ $adm['age'] }} Yaş
                                </span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-clinic-medical me-1"></i>{{ $adm['service'] }}</div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-tooth fa-3x mb-3 opacity-30"></i>
                            <p>Aktif diş hastası bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive Odontogram & Treatment Form -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                @php
                    $treatment = isset($dentalTreatments[$selectedAdmission['id']]) ? $dentalTreatments[$selectedAdmission['id']] : null;
                @endphp

                <!-- Active Dental Patient Header -->
                <div class="card dental-card mb-4 border-start border-info border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-info text-white mb-2">Aktif Diş Hastası Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Klinik:</strong> {{ $selectedAdmission['service'] }}
                                </p>
                                <p class="text-dark small mb-0 mt-1">
                                    <strong>Şikayet / Şüpheli Çürük:</strong> <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">{{ $selectedAdmission['diagnosis'] }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interactive Odontogram (Tooth Chart) Card -->
                <div class="card dental-card mb-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-tooth me-2 text-info"></i>İnteraktif Odontogram (Diş Şeması - FDI Sistemi)
                        </h5>
                        <span class="small text-muted">Diş seçimi yapmak için üzerine tıklayınız</span>
                    </div>
                    <div class="card-body bg-light rounded-bottom p-4">
                        <!-- Upper Jaw (Üst Çene) -->
                        <div class="text-center mb-3">
                            <span class="badge bg-dark mb-2 px-3">ÜST ÇENE (MAXILLA)</span>
                            <div class="d-flex justify-content-center align-items-center flex-wrap">
                                <div class="me-3 border-end pe-3">
                                    <span class="d-block small text-muted mb-1">Üst Sağ (18-11)</span>
                                    @foreach($teethUpperRight as $t)
                                        <button type="button" class="tooth-btn" data-tooth="{{ $t }}"><i class="fa-solid fa-tooth opacity-50" style="font-size: 10px;"></i>{{ $t }}</button>
                                    @endforeach
                                </div>
                                <div class="ps-1">
                                    <span class="d-block small text-muted mb-1">Üst Sol (21-28)</span>
                                    @foreach($teethUpperLeft as $t)
                                        <button type="button" class="tooth-btn" data-tooth="{{ $t }}"><i class="fa-solid fa-tooth opacity-50" style="font-size: 10px;"></i>{{ $t }}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <hr class="my-3 text-secondary opacity-25">

                        <!-- Lower Jaw (Alt Çene) -->
                        <div class="text-center">
                            <div class="d-flex justify-content-center align-items-center flex-wrap">
                                <div class="me-3 border-end pe-3">
                                    @foreach($teethLowerRight as $t)
                                        <button type="button" class="tooth-btn" data-tooth="{{ $t }}"><i class="fa-solid fa-tooth opacity-50" style="font-size: 10px;"></i>{{ $t }}</button>
                                    @endforeach
                                    <span class="d-block small text-muted mt-1">Alt Sağ (48-41)</span>
                                </div>
                                <div class="ps-1">
                                    @foreach($teethLowerLeft as $t)
                                        <button type="button" class="tooth-btn" data-tooth="{{ $t }}"><i class="fa-solid fa-tooth opacity-50" style="font-size: 10px;"></i>{{ $t }}</button>
                                    @endforeach
                                    <span class="d-block small text-muted mt-1">Alt Sol (31-38)</span>
                                </div>
                            </div>
                            <span class="badge bg-dark mt-2 px-3">ALT ÇENE (MANDIBULA)</span>
                        </div>
                    </div>
                </div>

                <!-- Treatment & Branch Entry Form Card -->
                <div class="card dental-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-info"></i>Diş Tedavi Planlama & Branş İstem Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('dental.store_treatment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Diş Hekimliği Branşı</label>
                                    <select name="branch" class="form-select border-info" id="branchSelect">
                                        @foreach($dentalBranches as $key => $b)
                                            <option value="{{ $key }}" {{ ($treatment && $treatment['branch'] == $key) ? 'selected' : '' }}>
                                                {{ $b['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Seçili Diş Numarası (FDI)</label>
                                    <input type="text" name="tooth_no" id="toothNoInput" class="form-control fw-bold text-info" value="{{ $treatment['tooth_no'] ?? '46' }}" readonly required placeholder="Diş şemasından tıklayınız">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Uygulanan Tedavi / İşlem Adı</label>
                                <select name="procedure" class="form-select">
                                    <option value="Estetik Kompozit Dolgu (Restoratif)">Estetik Kompozit Dolgu (Restoratif)</option>
                                    <option value="Kök Kanal Tedavisi (Endodonti)" selected>Kök Kanal Tedavisi (Endodonti)</option>
                                    <option value="Gömülü Diş Çekimi / Operasyon (Çene Cerrahisi)">Gömülü Diş Çekimi / Operasyon (Çene Cerrahisi)</option>
                                    <option value="Dental İmplant Uygulaması (Çene Cerrahisi)">Dental İmplant Uygulaması (Çene Cerrahisi)</option>
                                    <option value="Zirkonyum Kron / Köprü Protez (Protetik)">Zirkonyum Kron / Köprü Protez (Protetik)</option>
                                    <option value="Ortodontik Braket & Tel Takılması (Ortodonti)">Ortodontik Braket & Tel Takılması (Ortodonti)</option>
                                    <option value="Periodontal Küretaj & Detertraj (Periodontoloji)">Periodontal Küretaj & Detertraj (Periodontoloji)</option>
                                    <option value="Süt Dişi Amputasyonu & Florlama (Pedodonti)">Süt Dişi Amputasyonu & Florlama (Pedodonti)</option>
                                    <option value="Panoramik & CBCT Çene Radyolojisi (Radyoloji)">Panoramik & CBCT Çene Radyolojisi (Radyoloji)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Hekim Klinik Notları & Açıklama</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Kök kanal sayısı, dolgu yüzeyi (MOD/DO), protez rengi, röntgen bulguları vb.">{{ $treatment['notes'] ?? '' }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: {{ auth()->user()->name ?? 'Dt. Diş Hekimi' }}</span>
                                <button type="submit" class="btn btn-info text-white fw-bold px-4 py-2 shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Tedavi Kaydını Odontograma İşle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 9 Dental Branches Catalog Card -->
                <div class="card dental-card">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-teeth me-2 text-info"></i>Diş Hekimliği (Odontoloji) Branş Rehberi
                        </h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-2">
                            @foreach($dentalBranches as $b)
                                <div class="col-md-4 col-6">
                                    <div class="p-2 border rounded-3 bg-light d-flex align-items-center">
                                        <i class="fa-solid {{ $b['icon'] }} text-info me-2 fs-5"></i>
                                        <div>
                                            <div class="fw-bold small text-dark">{{ $b['name'] }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ Str::limit($b['description'], 35) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            @else
                <div class="card dental-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-tooth fa-4x text-info mb-3 opacity-40"></i>
                        <h5>Diş Hastası Seçimi Yapınız</h5>
                        <p class="text-muted">Sol listeden Odontogram ve diş tedavisi uygulamak istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toothBtns = document.querySelectorAll('.tooth-btn');
        const toothInput = document.getElementById('toothNoInput');

        toothBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                toothBtns.forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
                const toothNo = this.getAttribute('data-tooth');
                if(toothInput) {
                    toothInput.value = toothNo;
                }
            });
        });
    });
</script>
@endpush
@endsection
