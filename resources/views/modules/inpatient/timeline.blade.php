@extends('layouts.app')

@section('title', 'Klinik Akış ve Zaman Çizelgesi')

@push('styles')
<style>
    /* Premium Timeline Styling */
    .timeline-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    .timeline {
        position: relative;
        padding-left: 30px;
        margin-left: 10px;
        border-left: 2px solid #e9ecef;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    .timeline-item::after {
        content: '';
        display: table;
        clear: both;
    }
    .timeline-marker {
        position: absolute;
        top: 0;
        left: -40px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        border: 4px solid #0d6efd;
        z-index: 100;
        transition: all 0.2s ease;
    }
    .timeline-item:hover .timeline-marker {
        transform: scale(1.2);
    }
    .marker-success { border-color: #198754 !important; }
    .marker-danger { border-color: #dc3545 !important; }
    .marker-info { border-color: #0dcaf0 !important; }
    .marker-warning { border-color: #ffc107 !important; }
    .marker-primary { border-color: #0d6efd !important; }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-clock-rotate-left text-secondary me-2"></i>Servis Klinik Akış Zaman Çizelgesi
            </h1>
            <p class="text-muted mb-0">Servislerimizde gerçekleşen son hasta hareketlerini, yatış, transfer ve taburculuk işlemlerini takip edin.</p>
        </div>
        <a href="{{ route('inpatient.admission.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Yatak Paneline Dön
        </a>
    </div>

    <!-- Timeline Wrapper -->
    <div class="card timeline-card p-4 p-md-5">
        <h5 class="fw-bold text-secondary mb-4 pb-2 border-bottom">
            <i class="fa-solid fa-stream me-2"></i>Son Günlük Hareket Akışı
        </h5>
        
        <div class="timeline mt-3">
            @forelse($timelineEvents as $event)
                <div class="timeline-item">
                    <!-- Marker -->
                    @php
                        $markerClass = 'marker-primary';
                        if ($event['badge_color'] === 'success') $markerClass = 'marker-success';
                        elseif ($event['badge_color'] === 'danger') $markerClass = 'marker-danger';
                        elseif ($event['badge_color'] === 'info') $markerClass = 'marker-info';
                        elseif ($event['badge_color'] === 'warning') $markerClass = 'marker-warning';
                    @endphp
                    <div class="timeline-marker {{ $markerClass }}"></div>
                    
                    <!-- Content -->
                    <div class="row g-2">
                        <div class="col-md-2 col-12">
                            <span class="text-muted small fw-semibold d-block">
                                <i class="fa-regular fa-clock me-1"></i>{{ $event['time'] }}
                            </span>
                            <span class="badge bg-{{ $event['badge_color'] }} mt-1">
                                {{ $event['type'] }}
                            </span>
                        </div>
                        <div class="col-md-10 col-12 bg-light p-3 rounded shadow-sm">
                            <p class="mb-0 text-dark" style="font-size: 0.95rem;">
                                {{ $event['details'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-hourglass-empty fa-3x mb-3 opacity-30"></i>
                    <p class="mb-0">Klinik akış kaydı bulunmamaktadır.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection