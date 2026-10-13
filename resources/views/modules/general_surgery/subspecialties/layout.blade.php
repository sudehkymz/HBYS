@extends('layouts.app')

@push('styles')
<style>
    .surg-card {
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
        background-color: #fef2f2;
        border-left-color: #dc2626;
    }
    .subnav-category-pill {
        border-radius: 20px;
        padding: 6px 16px;
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
    <div class="card surg-card mb-4 bg-white border-top border-4 border-danger">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-scalpel fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            @yield('page_title')
                        </h2>
                        <p class="text-muted small mb-0">@yield('page_description')</p>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-danger text-white fw-bold dropdown-toggle px-4 py-2 shadow-sm rounded-pill" type="button" id="surgSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-scalpel me-2"></i>Genel Cerrahi Branşı Seçiniz
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-danger" aria-labelledby="surgSwitcher" style="width: 320px;">
                        <li><h6 class="dropdown-header text-danger fw-bold"><i class="fa-solid fa-hospital me-1"></i>Genel Cerrahi Ana Bilim Dalı</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('general_surgery.index') ? 'active fw-bold' : '' }}" href="{{ route('general_surgery.index') }}"><i class="fa-solid fa-scalpel me-2 text-danger"></i>Genel Cerrahi (Ana Branş)</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><h6 class="dropdown-header text-muted small py-1">Cerrahi Yan Dallar</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('general_surgery.surgical_oncology') ? 'active fw-bold' : '' }}" href="{{ route('general_surgery.surgical_oncology') }}"><i class="fa-solid fa-ribbon me-2 text-warning"></i>Cerrahi Onkolojisi (Yan Dal)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('general_surgery.gi_surgery') ? 'active fw-bold' : '' }}" href="{{ route('general_surgery.gi_surgery') }}"><i class="fa-solid fa-stomach me-2 text-primary"></i>Gastroenteroloji Cerrahisi (Yan Dal)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorized Sub-Navbar Category Bar -->
    <div class="card surg-card mb-4 bg-light">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="fw-bold small text-danger me-2 ps-2"><i class="fa-solid fa-bars-staggered me-1"></i>Genel Cerrahi Branşları:</span>
                
                <a href="{{ route('general_surgery.index') }}" class="subnav-category-pill {{ request()->routeIs('general_surgery.index') ? 'bg-danger text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-scalpel me-1"></i>Genel Cerrahi (Ana Branş)
                </a>
                <a href="{{ route('general_surgery.surgical_oncology') }}" class="subnav-category-pill {{ request()->routeIs('general_surgery.surgical_oncology') ? 'bg-danger text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-ribbon me-1 text-warning"></i>Cerrahi Onkolojisi (Yan Dal)
                </a>
                <a href="{{ route('general_surgery.gi_surgery') }}" class="subnav-category-pill {{ request()->routeIs('general_surgery.gi_surgery') ? 'bg-danger text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-stomach me-1 text-primary"></i>Gastroenteroloji Cerrahisi (Yan Dal)
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
            <div class="card surg-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-danger"></i>Cerrahi Hasta Başvuruları
                    </h5>
                    <span class="badge bg-danger-subtle text-danger rounded-pill">{{ count($surgAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($surgAdmissions as $adm)
                        <a href="{{ route(request()->route()->getName(), ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif cerrahi hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card surg-card mb-4 border-start border-danger border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger text-white mb-2">Aktif Genel Cerrahi Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Salon:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-danger me-1"></i>
                                    <strong>Sorumlu Cerrah:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Cerrahi Endikasyon:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @yield('general_surgery_workspace')

            @else
                <div class="card surg-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-scalpel fa-4x text-danger mb-3 opacity-40"></i>
                        <h5>Cerrahi Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
