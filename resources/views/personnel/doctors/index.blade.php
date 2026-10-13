@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-user-doctor text-primary me-2"></i>Doktor Kadrosu & Akademik Unvanlar</h3>
            <p class="text-muted small mb-0">Hastanedeki tüm akademik ve uzman hekim kadrosu, yetkileri ve bağlı ekipleri</p>
        </div>
        <a href="{{ route('personnel.doctors.create') }}" class="btn btn-primary rounded-3 shadow-sm px-3">
            <i class="fa-solid fa-plus me-1"></i> Yeni Hekim Ekle
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('personnel.doctors.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted px-3"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 py-2 fs-6" 
                               placeholder="Hekim adı, e-posta, uzmanlık veya alt uzmanlık ara..." value="{{ $search }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="academic_title" class="form-select bg-light border-0 py-2" onchange="this.form.submit()">
                        <option value="">-- Tüm Unvanlar --</option>
                        @foreach($academicTitles as $at)
                            <option value="{{ $at }}" {{ $title === $at ? 'selected' : '' }}>{{ $at }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="specialty" class="form-select bg-light border-0 py-2" onchange="this.form.submit()">
                        <option value="">-- Tüm Uzmanlıklar --</option>
                        @foreach($specialties as $sp)
                            <option value="{{ $sp }}" {{ $specialty === $sp ? 'selected' : '' }}>{{ $sp }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100 py-2"><i class="fa-solid fa-filter"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Doctor Cards Grid with Inner Scrollbar -->
    <div class="dynamic-table-scroll px-1 py-1" style="max-height: 650px; overflow-y: auto;">
        <div class="row g-3">
        @forelse($doctors as $doctor)
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden position-relative">
                    <div class="card-header bg-white border-0 pt-3 pb-2 px-3 d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 me-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 1.25rem;">
                                <i class="fa-solid fa-user-md"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $doctor->name }}</h6>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill small mt-1">
                                    {{ $doctor->academic_title ?? 'Uzman Hekim' }}
                                </span>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                <li><a class="dropdown-item" href="{{ route('personnel.doctors.edit', $doctor) }}"><i class="fa-solid fa-pen text-warning me-2"></i>Düzenle</a></li>
                                <li>
                                    <form action="{{ route('personnel.doctors.destroy', $doctor) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i>Sil</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body px-3 py-2">
                        <!-- Specialty Info -->
                        <div class="bg-light p-2 rounded-3 mb-2 small">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted"><i class="fa-solid fa-stethoscope me-1 text-primary"></i>Ana Uzmanlık:</span>
                                <span class="fw-semibold text-dark">{{ $doctor->specialty }}</span>
                            </div>
                            @if($doctor->sub_specialty)
                            <div class="d-flex justify-content-between">
                                <span class="text-muted"><i class="fa-solid fa-microscope me-1 text-info"></i>Alt Uzmanlık:</span>
                                <span class="fw-semibold text-dark">{{ $doctor->sub_specialty }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Contact & Room Info -->
                        <div class="small text-secondary mb-2">
                            <div class="mb-1"><i class="fa-solid fa-envelope me-2 text-muted"></i>{{ $doctor->email }}</div>
                            <div class="mb-1"><i class="fa-solid fa-phone me-2 text-muted"></i>{{ $doctor->phone ?? 'Belirtilmedi' }}</div>
                            <div><i class="fa-solid fa-hospital me-2 text-muted"></i>{{ $doctor->clinic->name ?? 'Ana Klinik Atanmadı' }}</div>
                        </div>

                        <!-- Authorities Badges -->
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @if($doctor->can_operate)
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill" style="font-size: 0.68rem;"><i class="fa-solid fa-scalpel me-1"></i>Ameliyat</span>
                            @endif
                            @if($doctor->can_consult)
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="font-size: 0.68rem;"><i class="fa-solid fa-comments me-1"></i>Konsültasyon</span>
                            @endif
                            @if($doctor->has_e_signature)
                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill" style="font-size: 0.68rem;"><i class="fa-solid fa-signature me-1"></i>E-İmza</span>
                            @endif
                        </div>

                        <!-- Assignments (Assistants & Interns) -->
                        @if($doctor->academicAssignments->count() > 0)
                        <div class="border-top pt-2 mt-2">
                            <div class="text-muted fw-bold mb-1" style="font-size: 0.68rem; letter-spacing: 0.5px; text-transform: uppercase;">Bağlı Asistan & İntern Kadrosu:</div>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($doctor->academicAssignments as $assignment)
                                    <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.7rem;">
                                        <i class="fa-solid fa-user-graduate me-1 text-warning"></i>{{ $assignment->juniorDoctor->name ?? 'Doktor' }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="card-footer bg-light border-0 px-3 py-2 text-muted small d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-clock me-1"></i>Kapasite: {{ $doctor->appointment_capacity }} Randevu/Gün</span>
                        <a href="{{ route('personnel.doctors.edit', $doctor) }}" class="btn btn-sm btn-link text-primary p-0 fw-semibold">Detaylar <i class="fa-solid fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fa-solid fa-user-doctor fs-1 text-light mb-3"></i>
                <h5>Arama kriterlerine uygun doktor bulunamadı.</h5>
            </div>
        @endforelse
        </div>
    </div>
</div>
@endsection

