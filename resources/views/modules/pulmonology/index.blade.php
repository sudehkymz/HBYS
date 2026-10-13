@extends('layouts.app')

@push('styles')
<style>
    .pulm-card {
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
        background-color: #f0f9ff;
        border-left-color: #0284c7;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Pulmonology Main Department Header Banner -->
    <div class="card pulm-card mb-4 bg-white border-top border-4 border-info" style="border-top-color: #0284c7 !important;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px; background-color: #0284c7;">
                        <i class="fa-solid fa-lungs fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-lungs-virus" style="color: #0284c7;"></i>Göğüs Hastalıkları Polikliniği
                        </h2>
                        <p class="text-muted small mb-0">Spirometri (SFT) solunum fonksiyon testi, kan gazı (AKG), uyku apnesi (PSG/AHİ), bronkoskopi & torasentez.</p>
                    </div>
                </div>

                <div class="badge border px-3 py-2 fs-6 rounded-pill" style="background-color: #f0f9ff; color: #0284c7; border-color: #bae6fd !important;">
                    <i class="fa-solid fa-wind me-1"></i>Solunum Laboratuvarı & Uyku Merkezi
                </div>
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
            <div class="card pulm-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2" style="color: #0284c7;"></i>Göğüs Hastalıkları Başvuruları
                    </h5>
                    <span class="badge rounded-pill" style="background-color: #f0f9ff; color: #0284c7;">{{ count($pulmAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($pulmAdmissions as $adm)
                        <a href="{{ route('pulmonology.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge border" style="background-color: #f0f9ff; color: #0284c7; border-color: #bae6fd !important;">{{ $adm['age'] }} Yaş</span>
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
                <!-- Active Patient Dossier Card -->
                <div class="card pulm-card mb-4 border-start border-4" style="border-left-color: #0284c7 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge text-white mb-2" style="background-color: #0284c7;">Aktif Göğüs Hastalıkları Hasta Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor me-1" style="color: #0284c7;"></i>
                                    <strong>Göğüs Hastalıkları Uzmanı:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pulmonology Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- Spirometry / Pulmonary Function Test (SFT) Card -->
                    <div class="col-md-6">
                        <div class="card pulm-card h-100 border-start border-4" style="border-left-color: #0284c7 !important;">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0" style="color: #0284c7;"><i class="fa-solid fa-lungs me-2"></i>Spirometri (SFT) & Reverzibilite Testi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">FEV1:</span>
                                        <span class="badge bg-danger">FEV1: %42 Beklenen (Ağır Düzey)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">FVC:</span>
                                        <span class="badge bg-primary">FVC: %78 Beklenen</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">FEV1 / FVC Oranı:</span>
                                        <span class="badge bg-danger">%54 (<%70 Obstrüktif Kalıp)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Bronkodilatör Reverzibilite:</span>
                                        <span class="badge bg-success">+340 mL (+%18 Reverzibilite)</span>
                                    </div>
                                </div>

                                <div class="p-2 rounded border small text-dark" style="background-color: #f0f9ff; border-color: #bae6fd !important;">
                                    <i class="fa-solid fa-circle-check me-1" style="color: #0284c7;"></i><strong>DLCO Diffüzyon Testi:</strong> DLCO: %48 Beklenen (İnterstisyel Akciğer Hastalığı / İPF).
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Arterial Blood Gas (AKG) & NIV Ventilation Monitor Card -->
                    <div class="col-md-6">
                        <div class="card pulm-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-notes-medical me-2"></i>Arteriyel Kan Gazı (AKG) & BiPAP Ventilasyon</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">pH:</span>
                                        <span class="badge bg-danger">pH: 7.31 (Solunumsal Asidoz)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">PaCO2 (Karbondioksit):</span>
                                        <span class="badge bg-danger">58 mmHg (Hiperkapni)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">PaO2 / SaO2:</span>
                                        <span class="badge bg-warning text-dark">PaO2: 56 mmHg, SaO2: %88</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">BiPAP Ayarları:</span>
                                        <span class="fw-bold text-dark">IPAP: 14, EPAP: 5 cmH2O, FiO2: %35</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Solunum Yetmezliği Tipi:</strong> Tip 2 Hiperkapnik Solunum Yetmezliği (Akut KOAH Atak).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: Sleep Apnea PSG & Thoracentesis Cards -->
                <div class="row g-4 mb-4">
                    <!-- Polysomnography & Sleep Apnea Center Card -->
                    <div class="col-md-6">
                        <div class="card pulm-card h-100 border-start border-4 border-dark">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-bed-pulse me-2"></i>Polisomnografi (PSG) Uyku Apnesi Laboratuvarı</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Apne-Hipopne İndeksi (AHİ):</span>
                                        <span class="badge bg-danger fs-6">AHİ: 38.4 / Saat (Şiddetli OSAS)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Nocturnal Minimum SpO2:</span>
                                        <span class="badge bg-warning text-dark">SpO2: %74 Desatürasyon</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Titrasyonlu CPAP Basıncı:</span>
                                        <span class="badge bg-success">9.5 cmH2O (Auto-CPAP Önerildi)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-dark-subtle rounded border border-dark-subtle small text-dark">
                                    <strong>CPAP Cihaz Raporu:</strong> Sağlık Kurulu E-Reçete & CPAP Maske Raporu Düzenlendi.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thoracentesis Pleural Effusion & Bronchoscopy Card -->
                    <div class="col-md-6">
                        <div class="card pulm-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-syringe me-2"></i>Torasentez & Bronkoskopi (BAL / EBUS)</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Plevra Sıvısı Protein Oranı:</span>
                                        <span class="badge bg-danger">Protein: 0.68 (Light Kriteri Eksuda)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Plevral Sıvı ADA Düzeyi:</span>
                                        <span class="badge bg-success">ADA: 18 U/L (Tüberküloz Ekarte)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Bronkoskopi (EBUS TBNA):</span>
                                        <span class="small text-muted">Subkarinal Lenf Nodundan İnce İğne Aspirasyonu</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                                    <strong>Plevral Sıvı Sitolojisi:</strong> Malignite Sitolojik İncelemesi İçi Patolojiye Gönderildi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card pulm-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2" style="color: #0284c7;"></i>Göğüs Hastalıkları Muayene & SFT Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('pulmonology.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">SFT & Kan Gazı Teşhisi</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-info" style="border-color: #0284c7 !important; color: #0284c7;" value="FEV1: %42 Obstrüksiyon - BiPAP İhtiyacı Var (pH: 7.31)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Reçete Edilen İnhaler / Cihaz</label>
                                    <select name="form_data[inhaler_prescription]" class="form-select">
                                        <option value="ICS/LABA + LAMA Üçlü İnhaler (Budesonid/Formoterol/Tiotropiyum)">ICS/LABA + LAMA Üçlü İnhaler</option>
                                        <option value="Auto-CPAP Cihazı (9.5 cmH2O Basınç)">Auto-CPAP Cihazı (9.5 cmH2O)</option>
                                        <option value="BiPAP ST Cihazı + Evde Oksijen Konsantratörü">BiPAP ST + Oksijen Konsantratörü</option>
                                        <option value="Antifibrotik (Pirfenidon 267mg 3x3)">Antifibrotik (Pirfenidon 267mg)</option>
                                        <option value="Sigara Bırakma NRT + Vareniklin">Sigara Bırakma NRT + Vareniklin</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">İntervansiyonel İstem</label>
                                    <input type="text" name="form_data[intervention]" class="form-control" value="Diagnostik Torasentez / EBUS Bronkoskopi İncelemesi">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Göğüs Hastalıkları Uzmanı Muayene Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Akciğer oskültasyon bulguları (ronküs, rali, ekspiryum uzunluğu), SFT parametreleri, kan gazı takibi ve inhaler cihaz kullanım eğitimi notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Göğüs Uzmanı: Prof. Dr. Ahmet Bilgin</span>
                                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #0284c7;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Göğüs Hastalıkları Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card pulm-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-lungs fa-4x mb-3 opacity-40" style="color: #0284c7;"></i>
                        <h5>Göğüs Hastalıkları Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
