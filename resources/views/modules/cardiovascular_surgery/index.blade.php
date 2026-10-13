@extends('layouts.app')

@push('styles')
<style>
    .kdc-card {
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
        background-color: #fef2f2;
        border-left-color: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Main Department Header Banner -->
    <div class="card kdc-card mb-4 bg-white border-top border-4 border-danger">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-heart-pulse fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-heart-circle-bolt text-danger"></i>Kalp ve Damar Cerrahisi Polikliniği & Ameliyathanesi
                        </h2>
                        <p class="text-muted small mb-0">Açık kalp baypas (CABG), Aort kapak replasmanı (AVR / TAVI), EVAR stent ve damar cerrahisi takibi.</p>
                    </div>
                </div>

                <div class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-scalpel me-1"></i>2. Cerrahi Tıp Bilimleri
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
            <div class="card kdc-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-danger"></i>KDC Hasta Listesi
                    </h5>
                    <span class="badge bg-danger-subtle text-danger rounded-pill">{{ count($kdcAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($kdcAdmissions as $adm)
                        <a href="{{ route('cardiovascular_surgery.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif KDC hastası bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card kdc-card mb-4 border-start border-danger border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger text-white mb-2">Aktif Kalp Damar Cerrahisi Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-danger me-1"></i>
                                    <strong>KDC Cerrahı:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KDC Workspace Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card kdc-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-heart-pulse me-2"></i>Biyokimyasal Perfüzyon & KPA Süresi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Aortik Çapraz Klemens Süresi:</span>
                                        <span class="badge bg-danger fs-6">68 Dakika</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kardiye Akciğer Pompası (KPA):</span>
                                        <span class="badge bg-primary">Perfüzyon Süresi: 95 Dk</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Kardiyopleji Çözeltisi:</span>
                                        <span class="fw-bold text-dark">Kansız Soğuk Kan Kardiyoplejisi (1000ml)</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                                    <i class="fa-solid fa-circle-check me-1"></i><strong>Greft Akım Ölçümü:</strong> LIMA-LAD Akımı 45 mL/dk (Pulsatilite İndeksi 1.8 Uyumlu).
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card kdc-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-bed-pulse me-2"></i>Post-Op Yoğun Bakım & İnotrop Destek</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">İnotropik Destek İnfizyonu:</span>
                                        <span class="badge bg-warning text-dark">Dobutamin 5 mcg/kg/dk + Noradrenalin</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Göğüs Tüpleri Drenaj Miktarı:</span>
                                        <span class="badge bg-success">Mediastinal Drenaj: 120 mL/12saat (Berrak)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">IABP İntra-Aortik Balon Pompası:</span>
                                        <span class="fw-bold text-dark">Standby Pozisyonunda (Gereksiz)</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Yoğun Bakım Takibi:</strong> Post-Op 18. Saatte Ekstübe Edildi, SpO2 %98.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card kdc-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-danger"></i>Kalp ve Damar Cerrahisi Ameliyat Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('cardiovascular_surgery.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">KDC Cerrahi Teşhisi</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="Üç Damar CABG Açık Kalp Ameliyatı - Klemens 68dk (LIMA-LAD / Saphenous)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Ameliyat Yöntemi</label>
                                    <select name="form_data[kdc_procedure]" class="form-select">
                                        <option value="CABG Koroner Arter Baypas Cerrahisi">CABG Açık Kalp Baypas Cerrahisi</option>
                                        <option value="AVR Aort Kapak Replasmanı / TAVI">AVR Aort Kapak Replasmanı / TAVI</option>
                                        <option value="EVAR Endovasküler Aort Anizrizma Onarımı">EVAR Endovasküler Aort Onarımı</option>
                                        <option value="Derin Ven Trombozu & Varis Lazer Ablasyon">Varis Lazer Ablasyon & Flebektomi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Greft Akımı & KPA Dolaşım</label>
                                    <input type="text" name="form_data[kpa_metrics]" class="form-control" value="KPA: 95dk, LIMA Akımı: 45 mL/dk, Drenaj: 120ml">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">KDC Cerrahı Ameliyat Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Medyan sternotomi, LIMA greft diseksiyonu, distal ve proksimal anastomozlar, defibrilasyon yanıtı, protamin nötralizasyonu ve göğüs tüpleri kapatılma notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>KDC Cerrahı: Prof. Dr. Tayfun Gürbüz</span>
                                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>KDC Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card kdc-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-heart-pulse fa-4x text-danger mb-3 opacity-40"></i>
                        <h5>KDC Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
