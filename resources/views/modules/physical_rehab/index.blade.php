@extends('layouts.app')

@push('styles')
<style>
    .ftr-card {
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
    <!-- FTR Main Department Header Banner -->
    <div class="card ftr-card mb-4 bg-white border-top border-4 border-success">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success-subtle p-3 d-flex align-items-center justify-content-center text-success" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-person-walking-with-cane fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-wheelchair text-success"></i>Fiziksel Tıp ve Rehabilitasyon Polikliniği (FTR)
                        </h2>
                        <p class="text-muted small mb-0">Robotik rehabilitasyon (Lokomat), FIM/Barthel skoru, elektroterapi seansları, eklem içi enjeksiyon & ortez.</p>
                    </div>
                </div>

                <div class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-dumbbell me-1"></i>Fizyo-Robotik Rehabilitasyon Merkezi
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
            <div class="card ftr-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-success"></i>FTR Hasta Başvuruları
                    </h5>
                    <span class="badge bg-success-subtle text-success rounded-pill">{{ count($ftrAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($ftrAdmissions as $adm)
                        <a href="{{ route('physical_rehab.index', ['admission_id' => $adm['id']]) }}" 
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
                <div class="card ftr-card mb-4 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success text-white mb-2">Aktif FTR Hasta Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-success me-1"></i>
                                    <strong>FTR Hekimi:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FTR Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- FTR Session Progress & Agent Modalities Card -->
                    <div class="col-md-6">
                        <div class="card ftr-card h-100 border-start border-4 border-success">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-bolt me-2"></i>Elektroterapi & Robotik Seans Protokolü</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Planlanan FTR Seansı:</span>
                                        <span class="badge bg-success fs-6">12. Seans / 30 Seans (%40)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Uygulanan Ajanlar:</span>
                                        <span class="fw-bold text-dark">TENS + Hot Pack + USG (1.5 W/cm²)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Robotik Yürüme (Lokomat):</span>
                                        <span class="badge bg-primary">45 Dk Robotik Parkur (2.2 km/s)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">SGK Medula Onayı:</span>
                                        <span class="badge bg-success">30 Seans FTR Raporu Onaylı</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                                    <i class="fa-solid fa-person-walking-with-cane me-1"></i><strong>Mobilizasyon Hedefi:</strong> Desteksiz Bağımsız Yürüme Seviyesine Ulaşmak.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FIM Score & Functional Assessment Card -->
                    <div class="col-md-6">
                        <div class="card ftr-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-calculator me-2"></i>FIM & Barthel Fonksiyonel Bağımsızlık Skoru</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">FIM (Fonksiyonel Bağımsızlık):</span>
                                        <span class="badge bg-primary fs-6">FIM: 78 / 126 (Orta Bağımsız)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Barthel İndeksi:</span>
                                        <span class="badge bg-warning text-dark">85 / 100 (Hafif Bağımlı)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">VAS Ağrı Skoru:</span>
                                        <span class="badge bg-danger">VAS: 8 / 10 (Şiddetli Bel Ağrısı)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Brunnstrom Motor Evreleme:</span>
                                        <span class="fw-bold text-dark">Evre 4 (Sinerji Dışı Hareket)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Rehabilitasyon Yanıtı:</strong> FIM Skoru Tedavi Öncesi 52'den 78'e Yükseldi (+26 Puan İyileşme).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: Infiltration / Botox & Orthosis Cards -->
                <div class="row g-4 mb-4">
                    <!-- Interventional Infiltration & Botox Card -->
                    <div class="col-md-6">
                        <div class="card ftr-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-syringe me-2"></i>Eklem İçi Enjeksiyon & Botox Protokolü</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Tetik Nokta Enjeksiyonu:</span>
                                        <span class="badge bg-success">4 Nokta Lidokain İğneleme Yapıldı</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Eklem İçi PRP / Hyalüronik Asit:</span>
                                        <span class="badge bg-warning text-dark">Diz İçi 2. Doz PRP Enjeksiyonu</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Botulinum Toksin (Botox):</span>
                                        <span class="fw-bold text-dark">200 Ünite Gastrocnemius Enjeksiyonu</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Ashworth Spastisite Evresi:</span>
                                        <span class="badge bg-danger">Modifiye Ashworth Evre 3</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Enjeksiyon Sonrası Takip:</strong> Lokal Ağrı Geriledi, Eklem Hareket Açıklığı (ROM) Artışı Saptandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orthosis & Prosthesis Prescriptions Card -->
                    <div class="col-md-6">
                        <div class="card ftr-card h-100 border-start border-4 border-info">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-person-cane me-2"></i>Ortez, Protez & Medikal Reçete</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Reçete Edilen Ortez:</span>
                                        <span class="badge bg-info text-dark">Rigid AFO (Ankle Foot Orthosis)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Korse / Boyunluk:</span>
                                        <span class="fw-bold text-dark">Lumbosakral Çelik Balenli Korse</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Yürüme Yardımcısı:</span>
                                        <span class="badge bg-secondary">Kanedyen Baston / Walker Yürüteç</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">SGK Medula Malzeme Raporu:</span>
                                        <span class="badge bg-success">E-Malzeme Raporu Düzenlendi</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                                    <strong>Ev Egzersiz Programı:</strong> Germe, Güçlendirme & Denge Egzersiz Broşürü Hastaya Verildi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card ftr-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-success"></i>FTR Muayene & Seans Planlama Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('physical_rehab.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">FTR Teşhis & FIM Skoru</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-success text-success" value="FIM: 78/126 - Hemipleji Lokomat 30 Seans FTR">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Planlanan FTR Protokolü</label>
                                    <select name="form_data[rehab_protocol]" class="form-select">
                                        <option value="30 Seans Robotik Lokomat + Fizyoterapi">30 Seans Robotik Lokomat + Fizyoterapi</option>
                                        <option value="15 Seans Elektroterapi + Traksiyon">15 Seans Elektroterapi + Traksiyon</option>
                                        <option value="Tetik Nokta Enjeksiyonu + Kinesiotaping">Tetik Nokta Enjeksiyonu + Kinesiotaping</option>
                                        <option value="Eklem İçi PRP / Hyalüronik Asit">Eklem İçi PRP / Hyalüronik Asit</option>
                                        <option value="Botox Enjeksiyonu + AFO Ortezi">Botox Enjeksiyonu + AFO Ortezi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Reçete Edilen Ortez / Baston</label>
                                    <input type="text" name="form_data[orthosis_prescription]" class="form-control" value="Rigid AFO + Lumbosakral Korse">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">FTR Uzmanı Muayene & Fizyoterapi Rapor Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Eklem hareket açıklığı (ROM) dereceleri, kas gücü (0-5), spastisite düzeyi, elektroterapi parametreleri ve robotik yürüme gelişim notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>FTR Uzmanı: Prof. Dr. Filiz Öztürk</span>
                                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>FTR Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card ftr-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-person-walking-with-cane fa-4x text-success mb-3 opacity-40"></i>
                        <h5>FTR Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
