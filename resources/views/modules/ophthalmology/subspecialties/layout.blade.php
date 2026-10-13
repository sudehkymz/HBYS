@extends('layouts.app')

@push('styles')
<style>
    .oph-card {
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
        background-color: #ecfeff;
        border-left-color: #0891b2;
    }
    .subnav-category-pill {
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 0.82rem;
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
    <div class="card oph-card mb-4 bg-white border-top border-4 border-info" style="border-top-color: #0891b2 !important;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px; background-color: #0891b2;">
                        <i class="fa-solid fa-eye fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            @yield('page_title')
                        </h2>
                        <p class="text-muted small mb-0">@yield('page_description')</p>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn text-white fw-bold dropdown-toggle px-4 py-2 shadow-sm rounded-pill" style="background-color: #0891b2;" type="button" id="ophSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-eye me-2"></i>Göz Hastalıkları Birimi Seçiniz
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-info" aria-labelledby="ophSwitcher" style="width: 340px;">
                        <li><h6 class="dropdown-header fw-bold" style="color: #0891b2;"><i class="fa-solid fa-hospital me-1"></i>Göz Hastalıkları Ana Bilim Dalı</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('ophthalmology.index') ? 'active fw-bold' : '' }}" href="{{ route('ophthalmology.index') }}"><i class="fa-solid fa-eye me-2" style="color: #0891b2;"></i>Göz Hastalıkları (Ana Branş)</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><h6 class="dropdown-header text-muted small py-1">Özel Alt Birimler</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('ophthalmology.glaucoma') ? 'active fw-bold' : '' }}" href="{{ route('ophthalmology.glaucoma') }}"><i class="fa-solid fa-gauge-high me-2 text-warning"></i>Glokom Birimi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('ophthalmology.retina') ? 'active fw-bold' : '' }}" href="{{ route('ophthalmology.retina') }}"><i class="fa-solid fa-circle-dot me-2 text-danger"></i>Retina Birimi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('ophthalmology.strabismus') ? 'active fw-bold' : '' }}" href="{{ route('ophthalmology.strabismus') }}"><i class="fa-solid fa-arrows-split-up-and-left me-2 text-primary"></i>Şaşılık Birimi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('ophthalmology.uvea') ? 'active fw-bold' : '' }}" href="{{ route('ophthalmology.uvea') }}"><i class="fa-solid fa-shield-virus me-2 text-danger"></i>Uvea Birimi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('ophthalmology.cornea') ? 'active fw-bold' : '' }}" href="{{ route('ophthalmology.cornea') }}"><i class="fa-solid fa-sun me-2 text-info"></i>Kornea & Refraktif Birimi</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('ophthalmology.oculoplastics') ? 'active fw-bold' : '' }}" href="{{ route('ophthalmology.oculoplastics') }}"><i class="fa-solid fa-wand-magic-sparkles me-2 text-success"></i>Oküloplasti Birimi</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorized Sub-Navbar Category Bar -->
    <div class="card oph-card mb-4 bg-light">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="fw-bold small me-2 ps-2" style="color: #0891b2;"><i class="fa-solid fa-bars-staggered me-1"></i>Göz Alt Birimleri:</span>
                
                <a href="{{ route('ophthalmology.index') }}" class="subnav-category-pill {{ request()->routeIs('ophthalmology.index') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('ophthalmology.index') ? 'background-color: #0891b2;' : '' }}">
                    <i class="fa-solid fa-eye me-1"></i>Göz (Ana Branş)
                </a>
                <a href="{{ route('ophthalmology.glaucoma') }}" class="subnav-category-pill {{ request()->routeIs('ophthalmology.glaucoma') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('ophthalmology.glaucoma') ? 'background-color: #0891b2;' : '' }}">
                    <i class="fa-solid fa-gauge-high me-1 text-warning"></i>Glokom
                </a>
                <a href="{{ route('ophthalmology.retina') }}" class="subnav-category-pill {{ request()->routeIs('ophthalmology.retina') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('ophthalmology.retina') ? 'background-color: #0891b2;' : '' }}">
                    <i class="fa-solid fa-circle-dot me-1 text-danger"></i>Retina
                </a>
                <a href="{{ route('ophthalmology.strabismus') }}" class="subnav-category-pill {{ request()->routeIs('ophthalmology.strabismus') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('ophthalmology.strabismus') ? 'background-color: #0891b2;' : '' }}">
                    <i class="fa-solid fa-arrows-split-up-and-left me-1 text-primary"></i>Şaşılık
                </a>
                <a href="{{ route('ophthalmology.uvea') }}" class="subnav-category-pill {{ request()->routeIs('ophthalmology.uvea') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('ophthalmology.uvea') ? 'background-color: #0891b2;' : '' }}">
                    <i class="fa-solid fa-shield-virus me-1 text-danger"></i>Uvea
                </a>
                <a href="{{ route('ophthalmology.cornea') }}" class="subnav-category-pill {{ request()->routeIs('ophthalmology.cornea') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('ophthalmology.cornea') ? 'background-color: #0891b2;' : '' }}">
                    <i class="fa-solid fa-sun me-1 text-info"></i>Kornea
                </a>
                <a href="{{ route('ophthalmology.oculoplastics') }}" class="subnav-category-pill {{ request()->routeIs('ophthalmology.oculoplastics') ? 'text-white shadow-sm' : 'bg-white text-dark border' }}" style="{{ request()->routeIs('ophthalmology.oculoplastics') ? 'background-color: #0891b2;' : '' }}">
                    <i class="fa-solid fa-wand-magic-sparkles me-1 text-success"></i>Oküloplasti
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
            <div class="card oph-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2" style="color: #0891b2;"></i>Göz Hastalıkları Listesi
                    </h5>
                    <span class="badge rounded-pill" style="background-color: #ecfeff; color: #0891b2;">{{ count($ophAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($ophAdmissions as $adm)
                        <a href="{{ route(request()->route()->getName(), ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge border" style="background-color: #ecfeff; color: #0891b2; border-color: #a5f3fc !important;">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif göz hastası bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card oph-card mb-4 border-start border-4" style="border-left-color: #0891b2 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge text-white mb-2" style="background-color: #0891b2;">Aktif Göz Hastalıkları Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor me-1" style="color: #0891b2;"></i>
                                    <strong>Göz Hekimi:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @yield('ophthalmology_workspace')

            @else
                <div class="card oph-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-eye fa-4x mb-3 opacity-40" style="color: #0891b2;"></i>
                        <h5>Göz Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
