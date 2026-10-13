@extends('layouts.app')

@section('title', 'Tanısal, Destekleyici ve Özel Amaçlı Poliklinikler')

@push('styles')
<style>
    .spec-card {
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
        background-color: #f0fdf4;
        border-left-color: #16a34a;
    }
    .unit-pill {
        border-radius: 8px;
        padding: 10px 14px;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    .unit-pill:hover {
        background-color: #f1f5f9;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">
                <i class="fa-solid fa-notes-medical text-success me-2"></i>Tanısal, Destekleyici ve Özel Amaçlı Poliklinikler
            </h1>
            <p class="text-muted mb-0">Sağlık Kurulu (Erişkin & ÇÖZGER), GETAT, Sigara Bırakma, Uyku, Hiperbarik Tıp, Genetik & Nükleer Tıp Yönetimi.</p>
        </div>
        <div>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                <i class="fa-solid fa-list-check me-1"></i>9 Özel Poliklinik & Ünite Aktif
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
        <!-- Left Column: Patient Admissions -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card spec-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-clipboard-user me-2 text-success"></i>Özel Birim Hasta Başvuruları
                    </h5>
                    <span class="badge bg-secondary rounded-pill">{{ count($specializedAdmissions) }} Başvuru</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 650px; overflow-y: auto;">
                    @forelse($specializedAdmissions as $adm)
                        <a href="{{ route('specialized.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    {{ $adm['age'] }} Yaş
                                </span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif özel birim hasta kaydı bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Clinic Unit Form & History -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                @php
                    $report = isset($specializedReports[$selectedAdmission['id']]) ? $specializedReports[$selectedAdmission['id']] : null;
                @endphp

                <!-- Active Patient Card -->
                <div class="card spec-card mb-4 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success text-white mb-2">Aktif Özel Poliklinik Başvurusu</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Başvurulan Birim:</strong> <span class="fw-bold text-success">{{ $selectedAdmission['service'] }}</span>
                                </p>
                                <p class="text-dark small mb-0 mt-1">
                                    <strong>Talep / Ön Değerlendirme:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specialized Form Card -->
                <div class="card spec-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-signature me-2 text-success"></i>Birim Değerlendirme, Rapor & Kurul Karar Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('specialized.store_report') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Özel Birim / Poliklinik</label>
                                    <select name="unit" class="form-select border-success" id="unitSelect">
                                        @foreach($specializedUnits as $key => $u)
                                            <option value="{{ $key }}" {{ ($report && $report['unit'] == $key) ? 'selected' : '' }}>
                                                [{{ $u['category'] }}] {{ $u['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Skor / Oran / Karar Özeti</label>
                                    <input type="text" name="status_score" class="form-control" value="{{ $report['status_score'] ?? '' }}" placeholder="ör: %45 Engelli Oranı / Fagerström: 8/10 / PSG AHI: 24">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Detaylı Klinik Bulgular, Kurul Kararı veya Tedavi Seans Notu</label>
                                <textarea name="findings" class="form-control" rows="4" placeholder="Sağlık Kurulu kararı, ÇÖZGER evde bakım onayı, GETAT seans planı, Sigara bırakma medikal reçetesi veya Hiperbarik Oksijen (HBOT) seans sayısı...">{{ $report['findings'] ?? '' }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Sorumlu Hekim: {{ $selectedAdmission['attending_physician'] }}</span>
                                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2 shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Rapor & Kararı Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 9 Specialized Units Guide -->
                <div class="card spec-card">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-sitemap me-2 text-success"></i>Tanısal, Destekleyici & Özel Amaçlı Poliklinikler Kataloğu
                        </h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-2">
                            @foreach($specializedUnits as $u)
                                <div class="col-md-4 col-6">
                                    <div class="unit-pill">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fa-solid {{ $u['icon'] }} text-success me-2 fs-5"></i>
                                            <span class="fw-bold small text-dark">{{ $u['name'] }}</span>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.72rem;">{{ $u['description'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            @else
                <div class="card spec-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-hospital-user fa-4x text-success mb-3 opacity-40"></i>
                        <h5>Özel Poliklinik Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden rapor, kurul kararı veya özel ünite tedavisi uygulamak istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
