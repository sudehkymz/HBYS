@extends('layouts.app')

@section('title', 'Laboratuvar, Radyoloji ve Patoloji')

@push('styles')
<style>
    .diagnostics-card {
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
    .status-badge {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-microscope text-primary me-2"></i>Laboratuvar, Radyoloji & Patoloji Tetkikleri
            </h1>
            <p class="text-muted mb-0">Hastalardan tahlil/görüntüleme istemleri yapın, numune/çekim onaylayıp sonuçları girin.</p>
        </div>
    </div>

    <div class="row">
        <!-- Patient List Sidebar -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card diagnostics-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold text-secondary mb-0">
                        <i class="fa-solid fa-users me-2"></i>Aktif Yatan Hastalar
                    </h5>
                </div>
                <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                    @forelse($admissions as $adm)
                        <a href="{{ route('diagnostics.index', ['admission_id' => $adm['id']]) }}" 
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
                        <div class="card diagnostics-card mb-4 border-start border-primary border-4">
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
                            <!-- Request Diagnostics Form -->
                            <div class="col-md-6 col-12 mb-4">
                                <div class="card diagnostics-card p-4">
                                    <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-plus-circle me-2"></i>Yeni Tetkik / Görüntüleme İstemi</h5>
                                    <form action="{{ route('diagnostics.request') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tetkik Tipi</label>
                                            <select class="form-select" id="testType-{{ $adm['id'] }}" data-admission-id="{{ $adm['id'] }}" name="test_type" required>
                                                <option value="Laboratuvar">Laboratuvar (Kan, İdrar, vb.)</option>
                                                <option value="Radyoloji">Radyoloji (Röntgen, MR, USG)</option>
                                                <option value="Patoloji">Patoloji (Biyopsi, Sitoloji, vb.)</option>
                                                <option value="Kardiyoloji">Kardiyoloji (EKG, EKO, vb.)</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">Tetkik / İstem Adı</label>
                                            <select class="form-select" id="testName-{{ $adm['id'] }}" name="test_name" required>
                                                @foreach($labTests as $lt)
                                                    <option class="opt-lab" value="{{ $lt }}">{{ $lt }}</option>
                                                @endforeach
                                                @foreach($radTests as $rt)
                                                    <option class="opt-rad d-none" value="{{ $rt }}">{{ $rt }}</option>
                                                @endforeach
                                                @foreach($pathologyTests as $pt)
                                                    <option class="opt-path d-none" value="{{ $pt }}">{{ $pt }}</option>
                                                @endforeach
                                                @foreach($cardiologyTests as $ct)
                                                    <option class="opt-card d-none" value="{{ $ct }}">{{ $ct }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-paper-plane me-1"></i>İstem Gönder
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Active Orders & Results -->
                            <div class="col-md-6 col-12 mb-4">
                                <div class="card diagnostics-card p-4">
                                    <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-clipboard-list me-2"></i>Tetkik Listesi & Giriş</h5>
                                    <div class="list-group">
                                        @forelse($activeOrders as $order)
                                            <div class="list-group-item border-0 border-bottom py-3 px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span class="badge bg-secondary mb-1">{{ $order['type'] }}</span>
                                                        <h6 class="fw-bold mb-1">{{ $order['name'] }}</h6>
                                                        <small class="text-muted d-block">Tarih: {{ $order['ordered_at'] }}</small>
                                                    </div>
                                                    <div>
                                                        @if($order['status'] === 'Sonuçlandı')
                                                            <span class="badge bg-success">Sonuçlandı</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Sonuç Bekliyor</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($order['status'] === 'Sonuçlandı')
                                                    @php
                                                        $res = $activeResults[$order['id']] ?? null;
                                                    @endphp
                                                    @if($res)
                                                        <div class="bg-light p-2 rounded mt-2 small">
                                                            <p class="mb-1"><strong>Sonuç:</strong> {{ $res['result_summary'] }}</p>
                                                            <p class="mb-0 text-muted small"><strong>Onaylayan:</strong> {{ $res['technician'] }} | {{ $res['completed_at'] }}</p>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="mt-2">
                                                        <button class="btn btn-sm btn-outline-success w-100" data-bs-toggle="collapse" data-bs-target="#collapseRes{{ $order['id'] }}_{{ $adm['id'] }}">
                                                            <i class="fa-solid fa-pen me-1"></i>Sonuç Raporu Gir
                                                        </button>
                                                        <div class="collapse mt-2" id="collapseRes{{ $order['id'] }}_{{ $adm['id'] }}">
                                                            <form action="{{ route('diagnostics.result') }}" method="POST" class="bg-light p-3 rounded border">
                                                                @csrf
                                                                <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                                                <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                                                
                                                                <div class="mb-2">
                                                                    <label class="form-label small fw-semibold">Sonuç Bulguları / Özet</label>
                                                                    <textarea class="form-control form-control-sm" name="result_summary" rows="3" placeholder="Laboratuvar değerleri veya radyolojik bulgular..." required></textarea>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label class="form-label small fw-semibold">Onaylayan Personel</label>
                                                                    <input type="text" class="form-control form-control-sm" name="technician" value="Uzm. Dr. Kürşat Kıran" required>
                                                                </div>
                                                                <button type="submit" class="btn btn-sm btn-success w-100">
                                                                    <i class="fa-solid fa-check me-1"></i>Sonucu Kaydet
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @empty
                                            <p class="text-muted text-center py-5">Bu hasta için henüz tahlil veya görüntüleme istemi bulunmamaktadır.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card diagnostics-card p-5 text-center text-muted">
                    <i class="fa-solid fa-hospital-user fa-4x mb-3 opacity-30"></i>
                    <h5 class="fw-bold text-secondary">Hasta Seçimi Yapın</h5>
                    <p class="mb-0">Laboratuvar ve görüntüleme tahlillerine başlamak için sol menüden bir hasta seçin.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle options based on test type selection
        document.querySelectorAll('[id^="testType-"]').forEach(element => {
            element.addEventListener('change', function() {
                const admissionId = this.getAttribute('data-admission-id');
                const type = this.value;
                const select = document.getElementById('testName-' + admissionId);
                
                // Hide all options
                for(let option of select.options) {
                    option.classList.add('d-none');
                }

                // Show matching options
                let firstMatch = null;
                if(type === 'Laboratuvar') {
                    select.querySelectorAll('.opt-lab').forEach(el => {
                        el.classList.remove('d-none');
                        if(!firstMatch) firstMatch = el;
                    });
                } else if(type === 'Radyoloji') {
                    select.querySelectorAll('.opt-rad').forEach(el => {
                        el.classList.remove('d-none');
                        if(!firstMatch) firstMatch = el;
                    });
                } else if(type === 'Patoloji') {
                    select.querySelectorAll('.opt-path').forEach(el => {
                        el.classList.remove('d-none');
                        if(!firstMatch) firstMatch = el;
                    });
                } else if(type === 'Kardiyoloji') {
                    select.querySelectorAll('.opt-card').forEach(el => {
                        el.classList.remove('d-none');
                        if(!firstMatch) firstMatch = el;
                    });
                }

                if(firstMatch) {
                    select.value = firstMatch.value;
                }
            });
        });

        // Patient selection SPA-like transition
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
