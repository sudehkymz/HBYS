@extends('layouts.app')

@push('styles')
<style>
    .fm-card {
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
        background-color: #f0fdf4;
        border-left-color: #16a34a;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Standalone Family Medicine Header Banner -->
    <div class="card fm-card mb-4 bg-white border-top border-4 border-success">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success-subtle p-3 d-flex align-items-center justify-content-center text-success" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-user-doctor fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-house-chimney-medical text-success"></i>Aile Hekimliği Polikliniği
                        </h2>
                        <p class="text-muted small mb-0">Birinci basamak periyodik sağlık taraması, HYP kronik hastalık takibi, aşı & bağışıklama, gebe/bebek izlem.</p>
                    </div>
                </div>

                <div class="badge bg-success-subtle text-success border border-success px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-shield-halved me-1"></i>Birinci Basamak Sağlık Hizmetleri
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
            <div class="card fm-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-success"></i>Aile Hekimliği Başvuruları
                    </h5>
                    <span class="badge bg-success-subtle text-success rounded-pill">{{ count($familyAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($familyAdmissions as $adm)
                        <a href="{{ route('family_medicine.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">{{ $adm['age'] }} Yaş</span>
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
                <div class="card fm-card mb-4 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success text-white mb-2">Aktif Aile Hekimliği Hasta Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-success me-1"></i>
                                    <strong>Aile Hekimi:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Başvuru Nedeni:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Family Medicine Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- HYP Chronic Disease Risk Matrix Card -->
                    <div class="col-md-6">
                        <div class="card fm-card h-100 border-start border-4 border-success">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-heart-circle-check me-2"></i>HYP (Hastalık Yönetim Platformu) Risk İzlemi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Diyabetes Mellitus Risk Taraması:</span>
                                        <span class="badge bg-success">Düşük Risk (AKŞ: 92 mg/dL)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kardiyovasküler Risk Skoru (SCORE):</span>
                                        <span class="badge bg-warning text-dark">%2.4 (10 Yıllık Risk - Düşük/Orta)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Tansiyon & Obezite İzlemi:</span>
                                        <span class="fw-bold text-dark">TA: 120/80 mmHg, VKİ: 24.2 kg/m²</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                                    <i class="fa-solid fa-circle-check me-1"></i><strong>Sağlık Bakanlığı HYP Bildirimi:</strong> Yıllık HYP Kronik Hastalık Taraması Başarıyla Onaylandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vaccination & Screening Schedule Card -->
                    <div class="col-md-6">
                        <div class="card fm-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-syringes me-2"></i>Aşı, Bağışıklama & Kanser Taramaları</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Erişkin Tetanoz (Td) Aşısı:</span>
                                        <span class="badge bg-success">Yapıldı (10 Yıllık Rapel Tamam)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kanser Taraması (HPV / Smear):</span>
                                        <span class="badge bg-primary">Pap-Smear Yapıldı (Negatif)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Gaita Gizli Kan (GGK - Kolorektal):</span>
                                        <span class="small text-muted">GGK Test Kit Teslim Edildi</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Mevsimsel Aşı Önerisi:</strong> Sonbahar dönemi için İnfluenza (Grip) Aşısı reçete edildi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card fm-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-user-doctor me-2 text-success"></i>Aile Hekimliği Muayene & HYP Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('family_medicine.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">HYP Tarama Statüsü</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-success text-success" value="HYP İzlemi Yapıldı - Kardiyovasküler Risk %2.4 (Normal)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Uygulanan Aşı / İstem</label>
                                    <select name="form_data[vaccine_given]" class="form-select">
                                        <option value="Td (Tetanoz-Difteri) Rapel Dozu">Td (Tetanoz-Difteri) Rapel Dozu</option>
                                        <option value="İnfluenza (Grip) Aşısı Reçetesi">İnfluenza (Grip) Aşısı Reçetesi</option>
                                        <option value="Hepatit B Aşı Serisi">Hepatit B Aşı Serisi</option>
                                        <option value="Pnomokok (Zatürre) Aşısı">Pnomokok (Zatürre) Aşısı</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Kanser Tarama Tipi</label>
                                    <input type="text" name="form_data[screening_type]" class="form-control" value="GGK (Gaita Gizli Kan) + Pap-Smear">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Aile Hekimi Muayene & Periyodik İzlem Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Fizik muayene bulguları, beslenme ve yaşam tarzı danışmanlığı, HYP protokolü ve bir sonraki izlem tarihi..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Aile Hekimi: Uzm. Dr. Aylin Güneş</span>
                                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Aile Hekimliği Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card fm-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-user-doctor fa-4x text-success mb-3 opacity-40"></i>
                        <h5>Aile Hekimliği Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
