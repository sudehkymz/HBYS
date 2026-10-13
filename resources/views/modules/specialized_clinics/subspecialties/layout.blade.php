@extends('layouts.app')

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
    <div class="card spec-card mb-4 bg-white border-top border-4 border-success">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success-subtle p-3 d-flex align-items-center justify-content-center text-success" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-notes-medical fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            @yield('page_title')
                        </h2>
                        <p class="text-muted small mb-0">@yield('page_description')</p>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-success text-white fw-bold dropdown-toggle px-4 py-2 shadow-sm rounded-pill" type="button" id="specializedSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-notes-medical me-2"></i>Özel Poliklinik Seçiniz (9 Birim)
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-success" aria-labelledby="specializedSwitcher" style="max-height: 450px; overflow-y: auto; width: 290px;">
                        <li><h6 class="dropdown-header text-success fw-bold"><i class="fa-solid fa-notes-medical me-1"></i>Tanısal & Özel Poliklinikler</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.index') ? 'active fw-bold' : '' }}" href="{{ route('specialized.index') }}"><i class="fa-solid fa-file-signature me-2 text-success"></i>Sağlık Kurulu Erişkin</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.cozger') ? 'active fw-bold' : '' }}" href="{{ route('specialized.cozger') }}"><i class="fa-solid fa-child-check me-2 text-success"></i>Sağlık Kurulu ÇÖZGER (Çocuk)</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><h6 class="dropdown-header text-muted small py-1">Tanısal & Tedavi Üniteleri</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.genetics') ? 'active fw-bold' : '' }}" href="{{ route('specialized.genetics') }}"><i class="fa-solid fa-dna me-2 text-success"></i>Tıbbi Genetik (Tanısal)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.nuclear_medicine') ? 'active fw-bold' : '' }}" href="{{ route('specialized.nuclear_medicine') }}"><i class="fa-solid fa-radiation me-2 text-success"></i>Nükleer Tıp (PET-CT & Atom)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.radiology') ? 'active fw-bold' : '' }}" href="{{ route('specialized.radiology') }}"><i class="fa-solid fa-x-ray me-2 text-success"></i>Tanısal Radyoloji (MR/BT)</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><h6 class="dropdown-header text-muted small py-1">Destek & Özel Amaçlı Klinikler</h6></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.smoking_cessation') ? 'active fw-bold' : '' }}" href="{{ route('specialized.smoking_cessation') }}"><i class="fa-solid fa-ban-smoking me-2 text-success"></i>Sigarayı Bıraktırma Kliniği</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.sleep') ? 'active fw-bold' : '' }}" href="{{ route('specialized.sleep') }}"><i class="fa-solid fa-bed-pulse me-2 text-success"></i>Uyku Polikliniği (PSG)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.getat') ? 'active fw-bold' : '' }}" href="{{ route('specialized.getat') }}"><i class="fa-solid fa-leaf me-2 text-success"></i>GETAT (Tamamlayıcı Tıp)</a></li>
                        <li><a class="dropdown-item small {{ request()->routeIs('specialized.hyperbaric') ? 'active fw-bold' : '' }}" href="{{ route('specialized.hyperbaric') }}"><i class="fa-solid fa-mask-ventilator me-2 text-success"></i>Hiperbarik Tıp (HBOT)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorized Sub-Navbar Category Bar -->
    <div class="card spec-card mb-4 bg-light">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap align-items-center gap-1">
                <span class="fw-bold small text-success me-2 ps-2"><i class="fa-solid fa-bars-staggered me-1"></i>Özel Birimler:</span>
                
                <a href="{{ route('specialized.index') }}" class="subnav-category-pill {{ request()->routeIs('specialized.index') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-file-signature me-1"></i>Sağlık Kurulu Erişkin
                </a>
                <a href="{{ route('specialized.cozger') }}" class="subnav-category-pill {{ request()->routeIs('specialized.cozger') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-child-check me-1"></i>Sağlık Kurulu ÇÖZGER
                </a>
                <a href="{{ route('specialized.genetics') }}" class="subnav-category-pill {{ request()->routeIs('specialized.genetics') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-dna me-1"></i>Tıbbi Genetik
                </a>
                <a href="{{ route('specialized.nuclear_medicine') }}" class="subnav-category-pill {{ request()->routeIs('specialized.nuclear_medicine') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-radiation me-1"></i>Nükleer Tıp
                </a>
                <a href="{{ route('specialized.radiology') }}" class="subnav-category-pill {{ request()->routeIs('specialized.radiology') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-x-ray me-1"></i>Tanısal Radyoloji
                </a>
                <a href="{{ route('specialized.smoking_cessation') }}" class="subnav-category-pill {{ request()->routeIs('specialized.smoking_cessation') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-ban-smoking me-1"></i>Sigarayı Bıraktırma
                </a>
                <a href="{{ route('specialized.sleep') }}" class="subnav-category-pill {{ request()->routeIs('specialized.sleep') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-bed-pulse me-1"></i>Uyku Polikliniği
                </a>
                <a href="{{ route('specialized.getat') }}" class="subnav-category-pill {{ request()->routeIs('specialized.getat') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-leaf me-1"></i>GETAT (Tamamlayıcı)
                </a>
                <a href="{{ route('specialized.hyperbaric') }}" class="subnav-category-pill {{ request()->routeIs('specialized.hyperbaric') ? 'bg-success text-white shadow-sm' : 'bg-white text-dark border' }}">
                    <i class="fa-solid fa-mask-ventilator me-1"></i>Hiperbarik Tıp
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
            <div class="card spec-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-clipboard-user me-2 text-success"></i>Özel Birim Hasta Başvuruları
                    </h5>
                    <span class="badge bg-success-subtle text-success rounded-pill">{{ count($specializedAdmissions) }} Başvuru</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($specializedAdmissions as $adm)
                        <a href="{{ route(Route::currentRouteName(), ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">{{ $adm['age'] }} Yaş</span>
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
                <!-- Active Patient & Committee File Card -->
                <div class="card spec-card mb-4 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success text-white mb-2">Aktif Özel Poliklinik & Heyet Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-success me-1"></i>
                                    <strong>Birim Sorumlusu:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Ön Değerlendirme:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specialized Workspace Yield -->
                @yield('specialized_workspace')

            @else
                <div class="card spec-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-notes-medical fa-4x text-success mb-3 opacity-40"></i>
                        <h5>Özel Poliklinik Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden değerlendirme yapmak istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
