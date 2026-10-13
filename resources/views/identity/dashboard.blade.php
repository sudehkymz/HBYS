@extends('layouts.app')

@section('title', 'Kontrol Paneli')

@section('content')
<div class="row g-4 mb-4">

    {{-- Hoş Geldin Kartı --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg,#1a56db,#2563eb); color:white; border-radius:16px;">
            <div class="card-body d-flex align-items-center gap-4 p-4">
                <div style="width:64px;height:64px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.8rem;">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">Hoş Geldiniz, {{ auth()->user()->name }}!</h4>
                    <p class="mb-0" style="opacity:0.8;">
                        {{ auth()->user()->role_label }} &mdash; {{ now()->format('d F Y, H:i') }}
                    </p>
                </div>
                <div class="ms-auto text-end">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm fw-semibold" style="border-radius:8px;">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>Çıkış
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Gerçek Veritabanı İstatistikleri --}}
    @php
        $statCards = [
            ['icon' => 'fa-user-injured',  'color' => '#0ea5e9', 'label' => 'Kayıtlı Hasta',    'value' => $stats['patients'],  'route' => 'patients.index'],
            ['icon' => 'fa-user-md',       'color' => '#8b5cf6', 'label' => 'Aktif Doktor',      'value' => $stats['doctors'],   'route' => 'personnel.doctors.index'],
            ['icon' => 'fa-users',         'color' => '#f59e0b', 'label' => 'Personel Sayısı',   'value' => $stats['personnel'], 'route' => 'personnel.personnels.index'],
            ['icon' => 'fa-clinic-medical','color' => '#10b981', 'label' => 'Aktif Klinik',      'value' => $stats['clinics'],   'route' => 'organization.clinics.index'],
        ];
    @endphp

    @foreach($statCards as $stat)
    <div class="col-md-6 col-xl-3">
        <a href="{{ route($stat['route']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-radius:14px; transition: transform .15s, box-shadow .15s;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:52px;height:52px;background:{{ $stat['color'] }}1a;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:{{ $stat['color'] }};">
                        <i class="fa-solid {{ $stat['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="text-muted small">{{ $stat['label'] }}</div>
                        <div class="fw-bold fs-4 text-dark">{{ $stat['value'] }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach

</div>

{{-- Rol Bazlı Hızlı Erişim Modülleri --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3"><i class="fa-solid fa-bolt text-warning me-2"></i>Hızlı Erişim — {{ auth()->user()->role_label }} Paneli</h5>
        <div class="row g-3">
            @foreach($quickLinks as $link)
            <div class="col-md-6 col-lg-3">
                <a href="{{ route($link['route']) }}" class="text-decoration-none">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 border quick-link-card"
                         style="border-color: {{ $link['color'] }}44 !important; background: {{ $link['color'] }}0d; transition: background .15s;">
                        <div style="width:40px;height:40px;background:{{ $link['color'] }}22;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:{{ $link['color'] }};">
                            <i class="fa-solid {{ $link['icon'] }}"></i>
                        </div>
                        <span class="fw-semibold text-dark small">{{ $link['label'] }}</span>
                        <i class="fa-solid fa-arrow-right ms-auto text-muted" style="font-size:.75rem;"></i>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Sistem Durumu --}}
<div class="card border-0 shadow-sm" style="border-radius:14px;">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-2"><i class="fa-solid fa-circle-check me-2 text-success"></i>Sistem Durumu</h5>
        <div class="row g-2 mt-1">
            <div class="col-auto"><span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2"><i class="fa-solid fa-database me-1"></i>MySQL Bağlantısı: Aktif</span></div>
            <div class="col-auto"><span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2"><i class="fa-solid fa-memory me-1"></i>Redis: Aktif</span></div>
            <div class="col-auto"><span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2"><i class="fa-solid fa-cubes me-1"></i>30 Modül Yüklü</span></div>
            <div class="col-auto"><span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2"><i class="fa-solid fa-flask me-1"></i>Geliştirme Modu</span></div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,.12) !important; }
    .quick-link-card:hover { background: rgba(0,0,0,.04) !important; }
</style>
@endpush
@endsection
