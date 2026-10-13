@extends('layouts.app')

@push('styles')
<style>
    .dental-card {
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
        background-color: #e0f2fe;
        border-left-color: #0284c7;
    }
    .tooth-box {
        width: 42px;
        height: 54px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        position: relative;
    }
    .tooth-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.15);
        border-color: #0284c7;
    }
    .tooth-box.curuk { background-color: #fee2e2; border-color: #ef4444; color: #991b1b; }
    .tooth-box.dolgu { background-color: #e0e7ff; border-color: #6366f1; color: #3730a3; }
    .tooth-box.cekim { background-color: #f1f5f9; border-color: #94a3b8; color: #64748b; text-decoration: line-through; }
    .tooth-box.kron { background-color: #fef3c7; border-color: #f59e0b; color: #92400e; }
    .tooth-box.gomulu { background-color: #f3e8ff; border-color: #a855f7; color: #6b21a8; }

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
    <!-- Top Header Banner & Dental Polyclinic Dropdown Switcher -->
    <div class="card dental-card mb-4 bg-white border-top border-4 border-primary">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary-subtle p-3 d-flex align-items-center justify-content-center text-primary" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-tooth fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            @yield('page_title')
                        </h2>
                        <p class="text-muted small mb-0">@yield('page_description')</p>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-primary text-white fw-bold dropdown-toggle px-4 py-2 shadow-sm rounded-pill" type="button" id="dentalSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-tooth me-2"></i>Diş Polikliniği Seçiniz (9 Branş)
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-primary" aria-labelledby="dentalSwitcher" style="max-height: 450px; overflow-y: auto; width: 280px;">
                        <li><h6 class="dropdown-header text-primary fw-bold"><i class="fa-solid fa-tooth me-1"></i>Diş Hekimliği Poliklinikleri</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.index') ? 'active fw-bold' : '' }}" href="{{ route('dental.index') }}"><i class="fa-solid fa-stethoscope me-2 text-primary"></i>Genel Diş Hekimliği</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.surgery') ? 'active fw-bold' : '' }}" href="{{ route('dental.surgery') }}"><i class="fa-solid fa-user-ninja me-2 text-primary"></i>Ağız, Diş ve Çene Cerrahisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.radiology') ? 'active fw-bold' : '' }}" href="{{ route('dental.radiology') }}"><i class="fa-solid fa-x-ray me-2 text-primary"></i>Ağız, Diş ve Çene Radyolojisi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.pedodontics') ? 'active fw-bold' : '' }}" href="{{ route('dental.pedodontics') }}"><i class="fa-solid fa-child me-2 text-primary"></i>Çocuk Diş Hekimliği (Pedodonti)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.endodontics') ? 'active fw-bold' : '' }}" href="{{ route('dental.endodontics') }}"><i class="fa-solid fa-syringe me-2 text-primary"></i>Endodonti (Kanal Tedavisi)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.orthodontics') ? 'active fw-bold' : '' }}" href="{{ route('dental.orthodontics') }}"><i class="fa-solid fa-equals me-2 text-primary"></i>Ortodonti (Tel Tedavisi)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.periodontics') ? 'active fw-bold' : '' }}" href="{{ route('dental.periodontics') }}"><i class="fa-solid fa-gear me-2 text-primary"></i>Periodontoloji (Diş Eti)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.prosthodontics') ? 'active fw-bold' : '' }}" href="{{ route('dental.prosthodontics') }}"><i class="fa-solid fa-gem me-2 text-primary"></i>Protetik Diş (Protez)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('dental.restorative') ? 'active fw-bold' : '' }}" href="{{ route('dental.restorative') }}"><i class="fa-solid fa-sparkles me-2 text-primary"></i>Restoratif Diş Tedavisi</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorized Dental Sub-Navbar Category Bar -->
    <div class="card dental-card mb-4 bg-light">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap align-items-center gap-1">
                <span class="fw-bold small text-primary me-2 ps-2"><i class="fa-solid fa-tooth me-1"></i>Diş Branşları:</span>
                
                <a href="{{ route('dental.index') }}" class="subnav-category-pill {{ request()->routeIs('dental.index') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-stethoscope me-1"></i>Genel Diş
                </a>
                <a href="{{ route('dental.surgery') }}" class="subnav-category-pill {{ request()->routeIs('dental.surgery') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-user-ninja me-1"></i>Çene Cerrahisi
                </a>
                <a href="{{ route('dental.radiology') }}" class="subnav-category-pill {{ request()->routeIs('dental.radiology') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-x-ray me-1"></i>Çene Radyolojisi
                </a>
                <a href="{{ route('dental.pedodontics') }}" class="subnav-category-pill {{ request()->routeIs('dental.pedodontics') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-child me-1"></i>Pedodonti (Çocuk)
                </a>
                <a href="{{ route('dental.endodontics') }}" class="subnav-category-pill {{ request()->routeIs('dental.endodontics') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-syringe me-1"></i>Endodonti (Kanal)
                </a>
                <a href="{{ route('dental.orthodontics') }}" class="subnav-category-pill {{ request()->routeIs('dental.orthodontics') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-equals me-1"></i>Ortodonti (Tel)
                </a>
                <a href="{{ route('dental.periodontics') }}" class="subnav-category-pill {{ request()->routeIs('dental.periodontics') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-gear me-1"></i>Periodontoloji (Diş Eti)
                </a>
                <a href="{{ route('dental.prosthodontics') }}" class="subnav-category-pill {{ request()->routeIs('dental.prosthodontics') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-gem me-1"></i>Protetik (Protez)
                </a>
                <a href="{{ route('dental.restorative') }}" class="subnav-category-pill {{ request()->routeIs('dental.restorative') ? 'bg-primary text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-sparkles me-1"></i>Restoratif Diş
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
        <!-- Dental Patient List Column -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card dental-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-chair me-2 text-primary"></i>Diş Ünitesi Hasta Listesi
                    </h5>
                    <span class="badge bg-primary-subtle text-primary rounded-pill">{{ count($dentalPatients) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($dentalPatients as $p)
                        <a href="{{ route(Route::currentRouteName(), ['patient_id' => $p['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedPatient && $selectedPatient['id'] == $p['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $p['patient_name'] }}</h6>
                                <span class="badge bg-primary-subtle text-primary border">{{ $p['chair'] }}</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-id-card me-1"></i>T.C.: {{ $p['national_id'] }} | Yaş: {{ $p['age'] }}</div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-hospital-user me-1"></i>{{ $p['service'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-tooth fa-3x mb-3 opacity-30"></i>
                            <p>Aktif hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Dental Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedPatient)
                <!-- 🦷 Interactive 32-Tooth FDI Odontogram Chart -->
                <div class="card dental-card mb-4 border-start border-primary border-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-teeth me-2 text-primary"></i>İnteraktif 32 Dişli FDI Odontogram Haritası
                        </h5>
                        <div class="d-flex gap-2">
                            <span class="badge bg-danger">Çürük</span>
                            <span class="badge bg-indigo text-white">Dolgu</span>
                            <span class="badge bg-secondary">Çekilmiş</span>
                            <span class="badge bg-warning text-dark">Kron</span>
                            <span class="badge bg-purple text-white" style="background:#a855f7;">Gömülü</span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @php
                            $teethStatus = $selectedPatient['teeth_status'] ?? [];
                            $upperTeeth = [18,17,16,15,14,13,12,11, 21,22,23,24,25,26,27,28];
                            $lowerTeeth = [48,47,46,45,44,43,42,41, 31,32,33,34,35,36,37,38];
                        @endphp

                        <!-- Üst Çene (Upper Arch) -->
                        <div class="mb-3">
                            <div class="text-center small fw-bold text-muted mb-1"><i class="fa-solid fa-arrow-up me-1"></i>ÜST ÇENE (Maxilla)</div>
                            <div class="d-flex flex-wrap justify-content-center gap-1">
                                @foreach($upperTeeth as $tNum)
                                    @php
                                        $status = $teethStatus[$tNum]['condition'] ?? 'saglam';
                                        $label = $teethStatus[$tNum]['label'] ?? 'Sağlam Diş';
                                    @endphp
                                    <div class="tooth-box {{ $status }}" title="Diş #{{ $tNum }}: {{ $label }}" data-bs-toggle="tooltip">
                                        <span style="font-size:0.65rem;" class="opacity-75">#{{ $tNum }}</span>
                                        <i class="fa-solid fa-tooth fs-6"></i>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <hr class="my-2">

                        <!-- Alt Çene (Lower Arch) -->
                        <div>
                            <div class="d-flex flex-wrap justify-content-center gap-1">
                                @foreach($lowerTeeth as $tNum)
                                    @php
                                        $status = $teethStatus[$tNum]['condition'] ?? 'saglam';
                                        $label = $teethStatus[$tNum]['label'] ?? 'Sağlam Diş';
                                    @endphp
                                    <div class="tooth-box {{ $status }}" title="Diş #{{ $tNum }}: {{ $label }}" data-bs-toggle="tooltip">
                                        <i class="fa-solid fa-tooth fs-6"></i>
                                        <span style="font-size:0.65rem;" class="opacity-75">#{{ $tNum }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center small fw-bold text-muted mt-1"><i class="fa-solid fa-arrow-down me-1"></i>ALT ÇENE (Mandible)</div>
                        </div>
                    </div>
                </div>

                <!-- Dental Workspace Yield -->
                @yield('dental_workspace')

            @else
                <div class="card dental-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-tooth fa-4x text-primary mb-3 opacity-40"></i>
                        <h5>Diş Hastası Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayene etmek istediğiniz diş hastasını seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
