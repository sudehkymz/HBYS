@extends('layouts.app')

@section('title', 'Eczane İlaç Stok & Depo Yönetim Masası')

@push('styles')
<style>
    body { background-color: #f8fafc; color: #1e293b; }
    
    .card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.02);
        transition: all 0.2s ease;
    }

    .metric-card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .metric-card-clean:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }

    /* Soft Renk Rozetleri */
    .bg-indigo-soft { background-color: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .bg-emerald-soft { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .bg-amber-soft { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .bg-rose-soft { background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .bg-slate-soft { background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }

    .nav-pills-custom .nav-link {
        color: #64748b;
        font-weight: 600;
        font-size: 0.86rem;
        padding: 0.55rem 1.1rem;
        border-radius: 8px;
    }
    .nav-pills-custom .nav-link.active {
        background-color: #059669;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(5, 150, 105, 0.25);
    }
</style>
@endpush

@section('content')

    <!-- 1. ÜST SAYFA BAŞLIĞI (YATAN HASTA STİLİ - KARTSIZ) -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <h4 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-boxes text-success"></i> Eczane İlaç Stok & Depo Yönetim Masası
            </h4>
            <p class="text-muted mb-0 small">Kritik Stok Uyarıları, Son Kullanma Tarihleri, İTS Karekod ve Depo İkmal Portalı</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('pharmacy.index') }}" class="btn btn-sm btn-outline-success fw-semibold rounded-pill px-3">
                <i class="bi bi-prescription-bottle me-1"></i> İlaç Karşılama
            </a>
            <a href="{{ route('pharmacy.inpatient') }}" class="btn btn-sm btn-outline-success fw-semibold rounded-pill px-3">
                <i class="bi bi-hospital me-1"></i> Yatan Hasta İlaç Paneli
            </a>
            <a href="{{ route('pharmacy.inventory') }}" class="btn btn-sm btn-success fw-bold rounded-pill px-3 shadow-sm">
                <i class="bi bi-boxes me-1"></i> Stok & Depo Yönetimi
            </a>
        </div>
    </div>

    <!-- 3. KPI STOK ÖZET KARTLARI -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="metric-card-clean d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Toplam İlaç Çeşidi</div>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $totalItems }}</h3>
                </div>
                <div class="rounded-circle bg-indigo-soft p-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;">
                    <i class="bi bi-capsule fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card-clean d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Kritik Stok Uyarısı (< 15)</div>
                    <h3 class="fw-bold text-danger mb-0 mt-1">{{ $criticalCount }}</h3>
                </div>
                <div class="rounded-circle bg-rose-soft p-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;">
                    <i class="bi bi-exclamation-octagon-fill fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card-clean d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">SKT Yaklaşanlar (30 Gün)</div>
                    <h3 class="fw-bold text-warning mb-0 mt-1">{{ $expiringCount }}</h3>
                </div>
                <div class="rounded-circle bg-amber-soft p-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;">
                    <i class="bi bi-calendar-event-fill fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card-clean d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Bugün Teslim Edilen</div>
                    <h3 class="fw-bold text-success mb-0 mt-1">42 Kutu</h3>
                </div>
                <div class="rounded-circle bg-emerald-soft p-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. İLAÇ STOK VERİ TABLOSU & DEPO İKMALİ -->
    <div class="card-clean p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-table text-success me-2"></i> Eczane İlaç Stok & Depo Listesi
            </h5>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-success btn-sm fw-bold shadow-sm" onclick="Swal.fire({icon: 'success', title: 'Ana Depo İkmal Talebi', text: 'Kritik stok seviyesindeki ilaçlar için Ana Depo Merkez Transfer Talebi oluşturuldu.', confirmButtonColor: '#059669'})">
                    <i class="bi bi-plus-circle me-1"></i> Ana Depodan Stok İkmal Et
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle small mb-0">
                <thead class="table-light">
                    <tr>
                        <th>İlaç Adı / Kategorisi</th>
                        <th>İTS Barkod No</th>
                        <th>Mevcut Stok</th>
                        <th>Kritik Limit</th>
                        <th>Raf Yeri</th>
                        <th>Perakende Fiyat</th>
                        <th>Son Kullanma Tarihi (SKT)</th>
                        <th>Stok Durumu</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $item['name'] }}</div>
                            <small class="text-muted">{{ $item['category'] }}</small>
                        </td>
                        <td class="font-monospace text-muted">{{ $item['barcode'] }}</td>
                        <td>
                            @if($item['status'] === 'critical')
                                <span class="badge bg-danger fs-6">{{ $item['stock'] }} Kutu</span>
                            @elseif($item['status'] === 'expiring')
                                <span class="badge bg-warning text-dark fs-6">{{ $item['stock'] }} Kutu</span>
                            @else
                                <span class="badge bg-success fs-6">{{ $item['stock'] }} Kutu</span>
                            @endif
                        </td>
                        <td class="text-muted fw-semibold">{{ $item['min_limit'] }} Kutu</td>
                        <td><span class="badge bg-slate-soft">{{ $item['shelf'] }}</span></td>
                        <td class="fw-bold text-dark">{{ $item['price'] }}</td>
                        <td class="font-monospace fw-semibold {{ $item['status'] === 'expiring' ? 'text-danger' : 'text-dark' }}">
                            {{ $item['expiry_date'] }}
                        </td>
                        <td>
                            @if($item['status'] === 'critical')
                                <span class="badge bg-rose-soft"><i class="bi bi-exclamation-circle me-1"></i> {{ $item['status_label'] }}</span>
                            @elseif($item['status'] === 'expiring')
                                <span class="badge bg-amber-soft"><i class="bi bi-clock-history me-1"></i> {{ $item['status_label'] }}</span>
                            @else
                                <span class="badge bg-emerald-soft"><i class="bi bi-check-circle me-1"></i> {{ $item['status_label'] }}</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm py-1 px-2" style="font-size:0.75rem;" onclick="Swal.fire({icon: 'info', title: '{{ $item['name'] }}', text: 'Raf Konumu: {{ $item['shelf'] }} | İTS Barkod: {{ $item['barcode'] }} | Mevcut Stok: {{ $item['stock'] }} Kutu', confirmButtonColor: '#2563eb'})">
                                <i class="bi bi-info-circle me-1"></i> Detay / İkmal
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
