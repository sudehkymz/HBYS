@extends('layouts.app')

@section('title', 'Beslenme ve Diyet Yönetimi')

@push('styles')
<style>
    .nutrition-card {
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
    .badge-allergen {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 600;
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-apple-whole text-primary me-2"></i>Beslenme & Diyet Planlama Modülü
            </h1>
            <p class="text-muted mb-0">Hastalara diyet reçeteleri hazırlayın, alerjen kontrollerini yapın ve öğün dağıtımlarını izleyin.</p>
        </div>
    </div>

    <div class="row">
        <!-- Patient List Sidebar -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card nutrition-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold text-secondary mb-0">
                        <i class="fa-solid fa-users me-2"></i>Aktif Yatan Hastalar
                    </h5>
                </div>
                <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                    @forelse($admissions as $adm)
                        <a href="{{ route('nutrition.index', ['admission_id' => $adm['id']]) }}" 
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
                <!-- Error messages / warnings -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-triangle-exclamation fs-4 me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Beslenme Güvenliği Uyarısı!</h6>
                                <p class="mb-0 small">{{ $errors->first() }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @foreach($admissions as $adm)
                    @php
                        $activeAssignment = isset($assignments[$adm['id']]) ? $assignments[$adm['id']] : null;
                        $isActivePane = ($selectedAdmission && $selectedAdmission['id'] == $adm['id']);
                    @endphp
                    <div class="patient-dashboard-pane" id="patient-pane-{{ $adm['id'] }}" style="display: {{ $isActivePane ? 'block' : 'none' }}">
                        <!-- Patient Info Card -->
                        <div class="card nutrition-card mb-4 border-start border-primary border-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8 col-12">
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
                            <!-- Assign Diet Form -->
                            <div class="col-md-6 col-12 mb-4">
                                <div class="card nutrition-card p-4">
                                    <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-utensils me-2"></i>Diyet Programı Ata</h5>
                                    <form action="{{ route('nutrition.assign') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="admission_id" value="{{ $adm['id'] }}">
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Diyet Tipi</label>
                                            <select class="form-select" name="diet_name" required>
                                                @foreach($diets as $name => $desc)
                                                    <option value="{{ $name }}" {{ ($activeAssignment && $activeAssignment['diet_name'] == $name) ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Bilinen Besin Alerjileri / Hassasiyetleri</label>
                                            <div class="p-2 border rounded bg-light" style="max-height: 150px; overflow-y: auto;">
                                                @foreach($allergens as $all)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="allergens[]" value="{{ $all }}" id="all_{{ $loop->index }}_{{ $adm['id'] }}"
                                                            {{ ($activeAssignment && in_array($all, $activeAssignment['allergens'])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="all_{{ $loop->index }}_{{ $adm['id'] }}">{{ $all }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">Sorumlu Diyetisyen</label>
                                            <input type="text" class="form-control" name="nutritionist" value="{{ $activeAssignment['nutritionist'] ?? 'Dyt. Merve Demir' }}" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-save me-1"></i>Beslenme Planını Kaydet
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Active Diet Details -->
                            <div class="col-md-6 col-12 mb-4">
                                <div class="card nutrition-card p-4">
                                    <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-circle-info me-2"></i>Aktif Diyet Detayı</h5>
                                    @if($activeAssignment)
                                        <div id="activeDietDetails-{{ $adm['id'] }}">
                                            <div class="bg-light p-3 rounded">
                                                <h6 class="fw-bold text-success mb-2"><i class="fa-solid fa-carrot me-2"></i>{{ $activeAssignment['diet_name'] }}</h6>
                                                <p class="text-muted small mb-3">{{ $diets[$activeAssignment['diet_name']] ?? '' }}</p>
                                                
                                                <p class="mb-2"><strong>Hasta Adı:</strong> {{ $adm['patient_name'] }}</p>
                                                <p class="mb-2"><strong>Diyetisyen:</strong> {{ $activeAssignment['nutritionist'] }}</p>
                                                <p class="mb-2"><strong>Atanma Zamanı:</strong> {{ $activeAssignment['assigned_at'] }}</p>
                                                
                                                <div class="mt-3">
                                                    <strong class="d-block mb-1 small text-secondary">Alerjen Filtresi:</strong>
                                                    @forelse($activeAssignment['allergens'] as $all)
                                                        <span class="badge-allergen me-1 d-inline-block">{{ $all }} Alerjisi</span>
                                                    @empty
                                                        <span class="badge bg-success-subtle text-success">Bilinen Alerji Yok</span>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm mt-3 w-100" onclick="printDiv('activeDietDetails-{{ $adm['id'] }}', 'Aktif Diyet Detay Belgesi')">
                                            <i class="fa-solid fa-print me-1"></i>Diyeti Yazdır
                                        </button>
                                    @else
                                        <p class="text-muted text-center py-5">Bu hasta için henüz diyet programı atanmamıştır.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card nutrition-card p-5 text-center text-muted">
                    <i class="fa-solid fa-hospital-user fa-4x mb-3 opacity-30"></i>
                    <h5 class="fw-bold text-secondary">Hasta Seçimi Yapın</h5>
                    <p class="mb-0">Beslenme ve diyet planlamalarına başlamak için sol menüden bir hasta seçin.</p>
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
