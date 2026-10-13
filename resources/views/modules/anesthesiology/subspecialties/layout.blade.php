@extends('layouts.app')

@push('styles')
<style>
    .ans-card {
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
        background-color: #f3e8ff;
        border-left-color: #7c3aed;
    }
    .subnav-category-pill {
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
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
    <div class="card ans-card mb-4 bg-white border-top border-4" style="border-top-color: #7c3aed !important;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px; background-color: #7c3aed;">
                        <i class="fa-solid fa-syringe fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            @yield('page_title')
                        </h2>
                        <p class="text-muted small mb-0">@yield('page_description')</p>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn text-white fw-bold dropdown-toggle px-4 py-2 shadow-sm rounded-pill" style="background-color: #7c3aed;" type="button" id="ansSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-syringe me-2"></i>Anestezi / Algoloji Seçiniz
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="ansSwitcher" style="width: 380px; border-color: #ddd6fe;">
                        <li><h6 class="dropdown-header fw-bold" style="color: #7c3aed;"><i class="fa-solid fa-hospital me-1"></i>Anesteziyoloji ve Reanimasyon</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('anesthesiology.index') ? 'active fw-bold' : '' }}" href="{{ route('anesthesiology.index') }}"><i class="fa-solid fa-syringe me-2" style="color: #7c3aed;"></i>Anesteziyoloji ve Reanimasyon (Ana Branş)</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><h6 class="dropdown-header text-muted small py-1">Yan Dal (Ağrı Polikliniği)</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('anesthesiology.algology') ? 'active fw-bold' : '' }}" href="{{ route('anesthesiology.algology') }}"><i class="fa-solid fa-bolt me-2 text-warning"></i>Algoloji (Ağrı Polikliniği - Yan Dal)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorized Sub-Navbar Category Bar -->
    <div class="card ans-card mb-4 bg-light">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="fw-bold small me-2 ps-2" style="color: #7c3aed;"><i class="fa-solid fa-bars-staggered me-1"></i>Anestezi & Algoloji Birimleri:</span>
                
                <a href="{{ route('anesthesiology.index') }}" class="subnav-category-pill {{ request()->routeIs('anesthesiology.index') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('anesthesiology.index') ? 'background-color: #7c3aed;' : '' }}">
                    <i class="fa-solid fa-syringe me-1"></i>Anesteziyoloji (Ana Branş)
                </a>
                <a href="{{ route('anesthesiology.algology') }}" class="subnav-category-pill {{ request()->routeIs('anesthesiology.algology') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('anesthesiology.algology') ? 'background-color: #7c3aed;' : '' }}">
                    <i class="fa-solid fa-bolt me-1 text-warning"></i>Algoloji / Ağrı (Yan Dal)
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
            <div class="card ans-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2" style="color: #7c3aed;"></i>Anestezi / Algoloji Listesi
                    </h5>
                    <span class="badge rounded-pill" style="background-color: #f3e8ff; color: #7c3aed;">{{ count($ansAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($ansAdmissions as $adm)
                        <a href="{{ route(request()->route()->getName(), ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge border" style="background-color: #f3e8ff; color: #7c3aed; border-color: #ddd6fe !important;">{{ $adm['age'] }} Yaş</span>
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
                <div class="card ans-card mb-4 border-start border-4" style="border-left-color: #7c3aed !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge text-white mb-2" style="background-color: #7c3aed;">Aktif Anestezi / Algoloji Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor me-1" style="color: #7c3aed;"></i>
                                    <strong>Anesteziyolog / Algolog:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @yield('anesthesiology_workspace')

            @else
                <div class="card ans-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-syringe fa-4x mb-3 opacity-40" style="color: #7c3aed;"></i>
                        <h5>Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
