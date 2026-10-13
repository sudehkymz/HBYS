@extends('layouts.app')

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
    .subnav-category-pill {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        white-space: nowrap;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .subnav-category-pill:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Top Header Banner & Polyclinic Dropdown Switcher -->
    <div class="card ped-card mb-4 bg-white border-top border-4 border-indigo">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-indigo-subtle p-3 d-flex align-items-center justify-content-center text-indigo" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-child-reaching fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            @yield('page_title')
                        </h2>
                        <p class="text-muted small mb-0">@yield('page_description')</p>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-indigo text-white fw-bold dropdown-toggle px-4 py-2 shadow-sm rounded-pill" type="button" id="polyclinicSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-hospital-user me-2"></i>Çocuk Polikliniği Seçiniz (19 Branş)
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-indigo" aria-labelledby="polyclinicSwitcher" style="max-height: 480px; overflow-y: auto; width: 300px;">
                        <li><h6 class="dropdown-header text-indigo fw-bold"><i class="fa-solid fa-star me-1"></i>Ana Branş</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.index') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.index') }}"><i class="fa-solid fa-child me-2 text-indigo"></i>Çocuk Sağlığı (Ana Branş)</a></li>
                        
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><h6 class="dropdown-header text-muted small py-1">Dahili Poliklinikler</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.neonatology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.neonatology') }}"><i class="fa-solid fa-baby me-2 text-indigo"></i>Neonatoloji (Yenidoğan)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.neurology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.neurology') }}"><i class="fa-solid fa-brain me-2 text-indigo"></i>Çocuk Nörolojisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.developmental') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.developmental') }}"><i class="fa-solid fa-hands-holding-child me-2 text-indigo"></i>Gelişimsel Pediatri</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.hematology_oncology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.hematology_oncology') }}"><i class="fa-solid fa-droplet me-2 text-danger"></i>Hematoloji & Onkoloji</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.endocrinology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.endocrinology') }}"><i class="fa-solid fa-dna me-2 text-indigo"></i>Çocuk Endokrinolojisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.metabolism') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.metabolism') }}"><i class="fa-solid fa-flask me-2 text-indigo"></i>Metabolizma Hastalıkları</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.pulmonology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.pulmonology') }}"><i class="fa-solid fa-lungs me-2 text-indigo"></i>Çocuk Göğüs Hastalıkları</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.allergy_immunology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.allergy_immunology') }}"><i class="fa-solid fa-allergies me-2 text-indigo"></i>İmmünoloji & Alerji</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.cardiology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.cardiology') }}"><i class="fa-solid fa-heart-pulse me-2 text-danger"></i>Çocuk Kardiyolojisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.gastroenterology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.gastroenterology') }}"><i class="fa-solid fa-stomach me-2 text-indigo"></i>Çocuk Gastroenteroloji</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.nephrology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.nephrology') }}"><i class="fa-solid fa-kidney me-2 text-indigo"></i>Çocuk Nefrolojisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.rheumatology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.rheumatology') }}"><i class="fa-solid fa-bone me-2 text-indigo"></i>Çocuk Romatolojisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.infectious') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.infectious') }}"><i class="fa-solid fa-shield-virus me-2 text-indigo"></i>Çocuk Enfeksiyon Hast.</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.genetics') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.genetics') }}"><i class="fa-solid fa-microscope me-2 text-indigo"></i>Çocuk Genetik Hastalıkları</a></li>
                        
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><h6 class="dropdown-header text-muted small py-1">Cerrahi & Özel Poliklinikler</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.surgery') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.surgery') }}"><i class="fa-solid fa-scalpel me-2 text-indigo"></i>Çocuk Cerrahisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.cardiovascular_surgery') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.cardiovascular_surgery') }}"><i class="fa-solid fa-heart-circle-check me-2 text-danger"></i>Çocuk KDC (Kalp Damar)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.urology') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.urology') }}"><i class="fa-solid fa-notes-medical me-2 text-indigo"></i>Çocuk Ürolojisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('pediatrics.psychiatry') ? 'active fw-bold' : '' }}" href="{{ route('pediatrics.psychiatry') }}"><i class="fa-solid fa-head-side-virus me-2 text-warning"></i>Çocuk Psikiyatrisi (Gizli)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorized Sub-Navbar Category Bar -->
    <div class="card ped-card mb-4 bg-light">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap align-items-center gap-1">
                <span class="fw-bold small text-indigo me-2 ps-2"><i class="fa-solid fa-bars-staggered me-1"></i>Branş Kategorileri:</span>
                
                <a href="{{ route('pediatrics.index') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.index') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-child me-1 text-indigo"></i>Genel Pediatri
                </a>
                <a href="{{ route('pediatrics.neonatology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.neonatology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-baby me-1"></i>Neonatoloji
                </a>
                <a href="{{ route('pediatrics.neurology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.neurology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-brain me-1"></i>Nöroloji
                </a>
                <a href="{{ route('pediatrics.developmental') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.developmental') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-hands-holding-child me-1"></i>Gelişimsel
                </a>
                <a href="{{ route('pediatrics.hematology_oncology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.hematology_oncology') ? 'bg-danger text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-droplet me-1 text-danger"></i>Hematoloji/Onkoloji
                </a>
                <a href="{{ route('pediatrics.endocrinology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.endocrinology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-dna me-1"></i>Endokrinoloji
                </a>
                <a href="{{ route('pediatrics.metabolism') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.metabolism') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-flask me-1"></i>Metabolizma
                </a>
                <a href="{{ route('pediatrics.pulmonology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.pulmonology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-lungs me-1"></i>Göğüs Hast.
                </a>
                <a href="{{ route('pediatrics.allergy_immunology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.allergy_immunology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-allergies me-1"></i>Alerji/İmmünoloji
                </a>
                <a href="{{ route('pediatrics.cardiology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.cardiology') ? 'bg-danger text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-heart-pulse me-1 text-danger"></i>Kardiyoloji
                </a>
                <a href="{{ route('pediatrics.gastroenterology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.gastroenterology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-stomach me-1"></i>Gastroenteroloji
                </a>
                <a href="{{ route('pediatrics.nephrology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.nephrology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-kidney me-1"></i>Nefroloji
                </a>
                <a href="{{ route('pediatrics.rheumatology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.rheumatology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-bone me-1"></i>Romatoloji
                </a>
                <a href="{{ route('pediatrics.infectious') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.infectious') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-shield-virus me-1"></i>Enfeksiyon
                </a>
                <a href="{{ route('pediatrics.genetics') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.genetics') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-microscope me-1"></i>Genetik
                </a>
                <a href="{{ route('pediatrics.surgery') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.surgery') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-scalpel me-1"></i>Cerrahi
                </a>
                <a href="{{ route('pediatrics.cardiovascular_surgery') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.cardiovascular_surgery') ? 'bg-danger text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-heart-circle-check me-1 text-danger"></i>KDC
                </a>
                <a href="{{ route('pediatrics.urology') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.urology') ? 'bg-indigo text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-notes-medical me-1"></i>Üroloji
                </a>
                <a href="{{ route('pediatrics.psychiatry') }}" class="subnav-category-pill {{ request()->routeIs('pediatrics.psychiatry') ? 'bg-warning text-dark shadow-sm fw-bold' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-head-side-virus me-1 text-warning"></i>Psikiyatri (Gizli)
                </a>
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
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $triage = $selectedAdmission ? ($selectedAdmission['triage'] ?? []) : [];
        $guardian = $selectedAdmission ? ($selectedAdmission['guardian'] ?? []) : [];
    @endphp

    <div class="row">
        <!-- Patient List Column -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card ped-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-children me-2 text-indigo"></i>Pediatrik Hasta Listesi
                    </h5>
                    <span class="badge bg-indigo-subtle text-indigo rounded-pill">{{ count($pediatricAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($pediatricAdmissions as $adm)
                        <a href="{{ route(Route::currentRouteName(), ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge {{ $adm['triage']['completed'] ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border">
                                    {{ $adm['triage']['completed'] ? $adm['triage']['weight'].' kg' : 'Kilo Eksik!' }}
                                </span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-user-shield me-1"></i>Vasi: {{ $adm['guardian']['name'] ?? '-' }} ({{ $adm['guardian']['relation'] ?? '-' }})</div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-hospital me-1"></i>{{ $adm['service'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-child-reaching fa-3x mb-3 opacity-30"></i>
                            <p>Aktif hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Patient & Guardian Header Card -->
                <div class="card ped-card mb-4 border-start border-indigo border-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7 col-12 mb-3 mb-md-0">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-indigo text-white">Aktif Hasta & Vasi Dosyası</span>
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
                                    <strong>Yasal Vasi:</strong> {{ $guardian['name'] ?? '-' }} ({{ $guardian['relation'] ?? '-' }}) | 
                                    <strong>Vasi T.C.:</strong> {{ $guardian['tc'] ?? '-' }} | 
                                    <strong>Onam:</strong> 
                                    <span class="badge {{ ($guardian['consent_signed'] ?? false) ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ ($guardian['consent_signed'] ?? false) ? 'İmzalandı' : 'Bekleniyor' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5 col-12 text-md-end">
                                @if(!empty($triage['completed']))
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

                <!-- Triage Modal -->
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
                                <input type="hidden" name="redirect_route" value="{{ Route::currentRouteName() }}">
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
                                            <label class="form-label small fw-bold">Ateş (°C) *</label>
                                            <input type="number" step="0.1" name="temp" class="form-control" value="{{ $triage['temp'] ?? 36.8 }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Nabız *</label>
                                            <input type="number" name="pulse" class="form-control" value="{{ $triage['pulse'] ?? 100 }}" required placeholder="atım/dk">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Tansiyon</label>
                                            <input type="text" name="bp" class="form-control" value="{{ $triage['bp'] ?? '95/60' }}" placeholder="ör: 95/60">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-indigo text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i>Triyaj Kaydını Onayla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Specialty Specific Body Yield -->
                @yield('subspecialty_workspace')

            @else
                <div class="card ped-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-child-reaching fa-4x text-indigo mb-3 opacity-40"></i>
                        <h5>Hasta Seçimi Yapınız</h5>
                        <p class="text-muted">Sol listeden değerlendirme yapmak istediğiniz pediatrik hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
