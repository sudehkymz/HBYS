@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-users text-info me-2"></i>Klinik Bakım & Yardımcı Personeller</h3>
            <p class="text-muted small mb-0">Hemşire, Ebe, Paramedik, Sağlık Teknikeri ve Destek Personel Kadrosu</p>
        </div>
        <a href="{{ route('personnel.personnels.create') }}" class="btn btn-info text-white rounded-3 shadow-sm px-3">
            <i class="fa-solid fa-plus me-1"></i> Yeni Personel Ekle
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
            <form action="{{ route('personnel.personnels.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted px-3"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 py-2 fs-6" 
                               placeholder="Personel adı, e-posta, unvan veya görev ara..." value="{{ $search }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="care_rank" class="form-select bg-light border-0 py-2" onchange="this.form.submit()">
                        <option value="">-- Tüm Bakım Unvanları --</option>
                        @foreach($careRanks as $cr)
                            <option value="{{ $cr }}" {{ $careRank === $cr ? 'selected' : '' }}>{{ $cr }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-info text-white w-100 py-2"><i class="fa-solid fa-filter"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Personnel Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive dynamic-table-scroll">
                <table class="table table-hover align-middle mb-0">
                    <thead class="sticky-table-header">
                        <tr>
                            <th class="ps-3">Personel</th>
                            <th>Klinik Bakım Unvanı</th>
                            <th>Görev / Rol</th>
                            <th>E-posta</th>
                            <th>Telefon</th>
                            <th>Atanan Klinik</th>
                            <th class="text-end pe-3">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personnels as $personnel)
                            <tr>
                                <td class="ps-3 fw-semibold">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                            <i class="fa-solid fa-user-nurse"></i>
                                        </div>
                                        <span>{{ $personnel->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 rounded-pill">
                                        {{ $personnel->care_rank ?? 'Genel Personel' }}
                                    </span>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $personnel->role ?? 'Klinik Destek' }}</span></td>
                                <td class="small text-muted">{{ $personnel->email }}</td>
                                <td class="small text-muted">{{ $personnel->phone ?? '-' }}</td>
                                <td><span class="small fw-semibold text-dark"><i class="fa-solid fa-hospital text-muted me-1"></i>{{ $personnel->clinic->name ?? 'Merkez Klinik' }}</span></td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('personnel.personnels.edit', $personnel) }}" class="btn btn-sm btn-outline-warning rounded-2 me-1">
                                        <i class="fa-solid fa-pen"></i> Düzenle
                                    </a>
                                    <form action="{{ route('personnel.personnels.destroy', $personnel) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu personeli silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                                            <i class="fa-solid fa-trash"></i> Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-users fs-1 text-light mb-2 d-block"></i>
                                    Kriterlere uygun personel bulunamadı.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

