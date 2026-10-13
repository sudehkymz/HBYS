@extends('layouts.app')

@section('title', 'Patoloji Raporlama ve Takip')

@push('styles')
<style>
    .pathology-card {
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
        background-color: #e8f0fe;
        border-left-color: #0d6efd;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-microscope text-primary me-2"></i>Patoloji Raporlama ve Takip Modülü
            </h1>
            <p class="text-muted mb-0">Hastalardan alınan doku ve sıvı örneklerinin patolojik tahlil süreçlerini ve raporlarını yönetin.</p>
        </div>
    </div>

    <div class="row">
        <!-- Patient List Sidebar -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card pathology-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold text-secondary mb-0">
                        <i class="fa-solid fa-users me-2"></i>Aktif Yatan Hastalar
                    </h5>
                </div>
                <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                    @forelse($admissions as $adm)
                        <a href="{{ route('pathology.index', ['admission_id' => $adm['id']]) }}" 
                           data-admission-id="{{ $adm['id'] }}"
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-secondary">Oda: {{ $adm['room'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mt-1">
                                <span>{{ $adm['service'] }}</span>
                                <span>Tanı: {{ Str::limit($adm['diagnosis'], 20) }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-bed-pulse fa-3x mb-3 opacity-30"></i>
                            <p class="mb-0">Aktif yatan hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Work Area -->
        <div class="col-lg-8 col-12">
            @if(count($admissions) > 0)
                @foreach($admissions as $adm)
                    @php
                        $activeOrders = isset($orders[$adm['id']]) ? $orders[$adm['id']] : [];
                        $activeResults = isset($results[$adm['id']]) ? $results[$adm['id']] : [];
                        $isActivePane = ($selectedAdmission && $selectedAdmission['id'] == $adm['id']);
                    @endphp
                    <div class="patient-dashboard-pane" id="patient-pane-{{ $adm['id'] }}" style="display: {{ $isActivePane ? 'block' : 'none' }}">
                        <!-- Patient Info Card -->
                        <div class="card pathology-card mb-4 border-start border-primary border-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-10 col-12">
                                        <h4 class="fw-bold text-primary mb-1">{{ $adm['patient_name'] }}</h4>
                                        <p class="text-muted mb-0 small">
                                            <strong>T.C. Kimlik:</strong> {{ $adm['national_id'] }} | 
                                            <strong>Yaş/Cinsiyet:</strong> {{ $adm['age'] }} Yaş / {{ $adm['gender'] }} | 
                                            <strong>Doktor:</strong> {{ $adm['attending_physician'] }}
                                        </p>
                                        <p class="text-muted mb-0 small mt-1">
                                            <strong>Tanı:</strong> {{ $adm['diagnosis'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Request Pathology Form -->
                            <div class="col-md-6 col-12 mb-4">
                                <div class="card pathology-card p-4">
                                    <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-plus-circle me-2"></i>Yeni Patoloji İstemi</h5>
                                    <form action="{{ route('pathology.request') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                        
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">Patoloji Tetkik Adı</label>
                                            <select class="form-select" name="test_name" required>
                                                @foreach($pathTests as $pt)
                                                    <option value="{{ $pt }}">{{ $pt }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-paper-plane me-1"></i>Patoloji İstemi Gönder
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Active Orders & Results -->
                            <div class="col-md-6 col-12 mb-4">
                                <div class="card pathology-card p-4">
                                    <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-clipboard-list me-2"></i>Patoloji Rapor Listesi</h5>
                                    <div class="list-group">
                                        @forelse($activeOrders as $order)
                                            <div class="list-group-item border-0 border-bottom py-3 px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span class="badge bg-danger-subtle text-danger mb-1">{{ $order['type'] }}</span>
                                                        <h6 class="fw-bold mb-1">{{ $order['name'] }}</h6>
                                                        <small class="text-muted d-block">İstem Tarihi: {{ $order['ordered_at'] }}</small>
                                                    </div>
                                                    <div>
                                                        @if($order['status'] === 'Sonuçlandı')
                                                            <span class="badge bg-success">Raporlandı</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Rapor Bekliyor</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($order['status'] === 'Sonuçlandı')
                                                    @php
                                                        $res = $activeResults[$order['id']] ?? null;
                                                    @endphp
                                                    @if($res)
                                                        <div class="bg-light p-3 rounded mt-2 small border-start border-success border-3" id="pathologyReport_{{ $order['id'] }}_{{ $adm['id'] }}">
                                                            <p class="mb-1"><strong>Hasta Adı:</strong> {{ $adm['patient_name'] }}</p>
                                                            <p class="mb-1"><strong>Rapor Özeti / Bulgular:</strong></p>
                                                            <p class="mb-2 text-dark">{{ $res['result_summary'] }}</p>
                                                            <p class="mb-0 text-muted small"><strong>Patolog:</strong> {{ $res['pathologist'] }} | {{ $res['completed_at'] }}</p>
                                                        </div>
                                                        <button class="btn btn-outline-primary btn-sm mt-2 w-100" onclick="printDiv('pathologyReport_{{ $order['id'] }}_{{ $adm['id'] }}', 'Patoloji Rapor Belgesi')">
                                                            <i class="fa-solid fa-print me-1"></i>Raporu Yazdır
                                                        </button>
                                                    @endif
                                                @else
                                                    <div class="mt-2">
                                                        <button class="btn btn-sm btn-outline-danger w-100" data-bs-toggle="collapse" data-bs-target="#collapseRes{{ $order['id'] }}_{{ $adm['id'] }}">
                                                            <i class="fa-solid fa-file-signature me-1"></i>Patoloji Sonuç Raporu Yaz
                                                        </button>
                                                        <div class="collapse mt-2" id="collapseRes{{ $order['id'] }}_{{ $adm['id'] }}">
                                                            <form action="{{ route('pathology.result') }}" method="POST" class="bg-light p-3 rounded border">
                                                                @csrf
                                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                                <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                                                
                                                                <div class="mb-2">
                                                                    <label class="form-label small fw-semibold">Rapor Bulguları (Makroskopi & Mikroskopi)</label>
                                                                    <textarea class="form-control form-control-sm" name="result_summary" rows="4" placeholder="Mikroskobik bulgular, histopatolojik tanı ve malignite durumu..." required></textarea>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label class="form-label small fw-semibold">Sorumlu Patolog</label>
                                                                    <input type="text" class="form-control form-control-sm" name="pathologist" value="Uzm. Dr. Melis Kaya" required>
                                                                </div>
                                                                <button type="submit" class="btn btn-sm btn-danger w-100">
                                                                    <i class="fa-solid fa-file-check me-1"></i>Raporu İmzala & Yayınla
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @empty
                                            <p class="text-muted text-center py-5">Bu hasta için henüz patoloji istemi bulunmamaktadır.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card pathology-card p-5 text-center text-muted">
                    <i class="fa-solid fa-hospital-user fa-4x mb-3 opacity-30"></i>
                    <h5 class="fw-bold text-secondary">Hasta Seçimi Yapın</h5>
                    <p class="mb-0">Patoloji istem ve sonuç işlemlerine başlamak için sol menüden bir hasta seçin.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function printDiv(divId, title) {
        const divToPrint = document.getElementById(divId);
        const newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write(`
            <html>
            <head>
                <title>${title}</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { padding: 30px; font-family: sans-serif; }
                    .print-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                <div class="print-header">
                    <h3>YEBSOFT SAĞLIK GRUBU</h3>
                    <h5>${title}</h5>
                </div>
        ` + divToPrint.innerHTML + `
            </body>
            </html>
        `);
        newWin.document.close();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const patientItems = document.querySelectorAll('.patient-item');
        patientItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const admissionId = this.getAttribute('data-admission-id');

                // Update URL parameter without reload
                const newUrl = this.getAttribute('href');
                window.history.pushState({path: newUrl}, '', newUrl);

                // Update active state in sidebar
                patientItems.forEach(pi => pi.classList.remove('active'));
                this.classList.add('active');

                // Toggle dashboard content panes
                document.querySelectorAll('.patient-dashboard-pane').forEach(pane => {
                    pane.style.display = 'none';
                });
                const targetPane = document.getElementById('patient-pane-' + admissionId);
                if (targetPane) {
                    targetPane.style.display = 'block';
                }
            });
        });
    });
</script>
@endpush
