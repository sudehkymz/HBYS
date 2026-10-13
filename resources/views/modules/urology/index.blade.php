@extends('layouts.app')

@push('styles')
<style>
    .uro-card {
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
        background-color: #eff6ff;
        border-left-color: #2563eb;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Main Department Header Banner -->
    <div class="card uro-card mb-4 bg-white border-top border-4 border-primary">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-droplet fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-microscope text-primary"></i>Üroloji Polikliniği & Endoüroloji
                        </h2>
                        <p class="text-muted small mb-0">RIRC lazer taş kırma (Holmiyum YAG), HoLEP prostat enükleasyonu, TUR-M & robotik radikal prostatektomi.</p>
                    </div>
                </div>

                <div class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-6 rounded-pill">
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
            <div class="card uro-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-primary"></i>Üroloji Hasta Listesi
                    </h5>
                    <span class="badge bg-primary-subtle text-primary rounded-pill">{{ count($uroAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($uroAdmissions as $adm)
                        <a href="{{ route('urology.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif üroloji hastası bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card uro-card mb-4 border-start border-primary border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary text-white mb-2">Aktif Üroloji Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-primary me-1"></i>
                                    <strong>Ürolog:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Urology Workspace Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card uro-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-gem me-2"></i>RIRC Lazer Taş Kırma (Holmiyum YAG)</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Böbrek Taş Lokasyonu & Boyutu:</span>
                                        <span class="badge bg-primary fs-6">Sol Üst Kaliks 18mm (1150 HU)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Lazer Parametresi (Dusting):</span>
                                        <span class="badge bg-success">0.6 Joule / 20 Hz (Tozlama)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Double-J (DJ) Stent Durumu:</span>
                                        <span class="fw-bold text-dark">6 Fr 26 cm DJ Stent Takıldı</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <i class="fa-solid fa-circle-check me-1"></i><strong>Endoüroloji Sonucu:</strong> Taş Tamamen Toz Haline Getirildi, Parça Kalmadı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card uro-card h-100 border-start border-4 border-info">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-circle-nodes me-2"></i>HoLEP / TUR-P Prostat Cerrahisi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Prostat Hacmi & Serum PSA:</span>
                                        <span class="badge bg-info text-dark fs-6">95 gram (PSA 2.8 ng/mL Normal)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Morselasyon Dokusu:</span>
                                        <span class="badge bg-success">72 gram Enükle Prostat Dokusu Çıkarıldı</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">İdrar Çıkışı (Qmax):</span>
                                        <span class="fw-bold text-dark">Qmax: 6.2 mL/sn'den >22 mL/sn'ye Yükseldi</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                                    <strong>Kateter Takibi:</strong> 24 Fr 3 Yollu Foley Kateter İle Berrak İdrar Yıkaması Sürüyor.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card uro-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-primary"></i>Üroloji Muayene & Ameliyat Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('urology.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Ürolojik Teşhis & Taş Boyutu</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="Sol Böbrek 18mm Taş - RIRC Holmiyum Lazer Taş Kırma + DJ Stent">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Endoürolojik / Robotik Prosedür</label>
                                    <select name="form_data[uro_procedure]" class="form-select">
                                        <option value="RIRC Fleksibil URS Holmiyum Lazer Taş Kırma">RIRC Holmiyum Lazer Taş Kırma</option>
                                        <option value="HoLEP Holmiyum Lazer Prostat Enükleasyonu">HoLEP Lazer Prostat Enükleasyonu</option>
                                        <option value="da Vinci Xi Robotik Radikal Prostatektomi">da Vinci Robotik Prostatektomi</option>
                                        <option value="TUR-M Transüretral Mesane Tümör Rezeksiyonu">TUR-M Mesane Tümörü Rezeksiyonu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Stent / Kateter & PSA</label>
                                    <input type="text" name="form_data[uro_metrics]" class="form-control" value="6 Fr 26 cm DJ Stent Takıldı, PSA: 2.8 ng/mL">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Ürolog Muayene & Operasyon Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Fleksibil üreterorenoskopi geçişi, lazer watt/frekans değerleri, taş tozu drenajı, DJ stent kılavuz tel kontrolü ve kateter çekilme takvimi..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Üroloji Uzmanı: Prof. Dr. Birol Yanık</span>
                                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Üroloji Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card uro-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-droplet fa-4x text-primary mb-3 opacity-40"></i>
                        <h5>Üroloji Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
