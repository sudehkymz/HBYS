@extends('layouts.app')

@push('styles')
<style>
    .internal-card {
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
        background-color: #eff6ff;
        border-left-color: #2563eb;
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
    <div class="card internal-card mb-4 bg-white border-top border-4 border-primary">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary-subtle p-3 d-flex align-items-center justify-content-center text-primary" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-stethoscope fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            @yield('page_title')
                        </h2>
                        <p class="text-muted small mb-0">@yield('page_description')</p>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-primary text-white fw-bold dropdown-toggle px-4 py-2 shadow-sm rounded-pill" type="button" id="internalSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-doctor me-2"></i>Dahiliye Polikliniği Seçiniz (10 Branş)
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-primary" aria-labelledby="internalSwitcher" style="max-height: 480px; overflow-y: auto; width: 290px;">
                        <li><h6 class="dropdown-header text-primary fw-bold"><i class="fa-solid fa-hospital me-1"></i>Dahili (İç) Tıp Bilimleri</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.index') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.index') }}"><i class="fa-solid fa-stethoscope me-2 text-primary"></i>İç Hastalıkları (Dahiliye Ana)</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><h6 class="dropdown-header text-muted small py-1">Dahili Yan Dallar</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.endocrinology') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.endocrinology') }}"><i class="fa-solid fa-dna me-2 text-primary"></i>Endokrinoloji & Metabolizma</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.gastroenterology') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.gastroenterology') }}"><i class="fa-solid fa-stomach me-2 text-primary"></i>Gastroenteroloji</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.geriatrics') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.geriatrics') }}"><i class="fa-solid fa-person-cane me-2 text-primary"></i>Geriatri (Yaşlı Sağlığı)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.hematology') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.hematology') }}"><i class="fa-solid fa-droplet me-2 text-danger"></i>Hematoloji (Kan Hastalıkları)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.allergy_immunology') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.allergy_immunology') }}"><i class="fa-solid fa-allergies me-2 text-primary"></i>İmmünoloji & Alerji</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.occupational') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.occupational') }}"><i class="fa-solid fa-briefcase-medical me-2 text-primary"></i>İş ve Meslek Hastalıkları</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.nephrology') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.nephrology') }}"><i class="fa-solid fa-kidney me-2 text-primary"></i>Nefroloji (Böbrek)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.rheumatology') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.rheumatology') }}"><i class="fa-solid fa-bone me-2 text-primary"></i>Romatoloji (Romatizma)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('internal_medicine.oncology') ? 'active fw-bold' : '' }}" href="{{ route('internal_medicine.oncology') }}"><i class="fa-solid fa-ribbon me-2 text-primary"></i>Tıbbi Onkoloji (Kanser)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorized Sub-Navbar Category Bar -->
    <div class="card internal-card mb-4 bg-light">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap align-items-center gap-1">
                <span class="fw-bold small text-primary me-2 ps-2"><i class="fa-solid fa-bars-staggered me-1"></i>Dahili Branşlar:</span>
                
                <a href="{{ route('internal_medicine.index') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.index') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-stethoscope me-1"></i>Dahiliye
                </a>
                <a href="{{ route('internal_medicine.endocrinology') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.endocrinology') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-dna me-1"></i>Endokrin
                </a>
                <a href="{{ route('internal_medicine.gastroenterology') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.gastroenterology') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-stomach me-1"></i>Gastroenteroloji
                </a>
                <a href="{{ route('internal_medicine.geriatrics') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.geriatrics') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-person-cane me-1"></i>Geriatri
                </a>
                <a href="{{ route('internal_medicine.hematology') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.hematology') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-droplet me-1 text-danger"></i>Hematoloji
                </a>
                <a href="{{ route('internal_medicine.allergy_immunology') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.allergy_immunology') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-allergies me-1"></i>İmmünoloji & Alerji
                </a>
                <a href="{{ route('internal_medicine.occupational') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.occupational') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-briefcase-medical me-1"></i>İş/Meslek Hast.
                </a>
                <a href="{{ route('internal_medicine.nephrology') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.nephrology') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-kidney me-1"></i>Nefroloji
                </a>
                <a href="{{ route('internal_medicine.rheumatology') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.rheumatology') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-bone me-1"></i>Romatoloji
                </a>
                <a href="{{ route('internal_medicine.oncology') }}" class="subnav-category-pill {{ request()->routeIs('internal_medicine.oncology') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-ribbon me-1"></i>Tıbbi Onkoloji
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

    <div class="row">
        <!-- Patient List Column -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card internal-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-primary"></i>Dahiliye Hasta Listesi
                    </h5>
                    <span class="badge bg-primary-subtle text-primary rounded-pill">{{ count($internalAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($internalAdmissions as $adm)
                        <a href="{{ route(Route::currentRouteName(), ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card internal-card mb-4 border-start border-primary border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary text-white mb-2">Aktif Dahiliye Hasta Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Yatak:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-primary me-1"></i>
                                    <strong>Sorumlu Hekim:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Ön Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Internal Medicine Workspace Yield -->
                @yield('internal_workspace')

            @else
                <div class="card internal-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-stethoscope fa-4x text-primary mb-3 opacity-40"></i>
                        <h5>Dahiliye Hasta Muayenesi Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
