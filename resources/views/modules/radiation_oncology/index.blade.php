@extends('layouts.app')

@push('styles')
<style>
    .rad-card {
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
        background-color: #fff7ed;
        border-left-color: #ea580c;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Radiation Oncology Main Department Header Banner -->
    <div class="card rad-card mb-4 bg-white border-top border-4 border-warning" style="border-top-color: #ea580c !important;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px; background-color: #ea580c;">
                        <i class="fa-solid fa-radiation fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-radiation" style="color: #ea580c;"></i>Radyasyon Onkolojisi Polikliniği
                        </h2>
                        <p class="text-muted small mb-0">Lineer Hızlandırıcı (LINAC / VMAT / IMRT), CyberKnife SRS, SBRT, 3D-Brakiterapi & BT Simülasyonu.</p>
                    </div>
                </div>

                <div class="badge border px-3 py-2 fs-6 rounded-pill" style="background-color: #fff7ed; color: #ea580c; border-color: #ffedd5 !important;">
                    <i class="fa-solid fa-atom me-1"></i>Lineer Hızlandırıcı & Brakiterapi Merkezi
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
            <div class="card rad-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2" style="color: #ea580c;"></i>Radyoterapi Başvuruları
                    </h5>
                    <span class="badge rounded-pill" style="background-color: #fff7ed; color: #ea580c;">{{ count($radAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($radAdmissions as $adm)
                        <a href="{{ route('radiation_oncology.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge border" style="background-color: #fff7ed; color: #ea580c; border-color: #ffedd5 !important;">{{ $adm['age'] }} Yaş</span>
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
                <div class="card rad-card mb-4 border-start border-4" style="border-left-color: #ea580c !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge text-white mb-2" style="background-color: #ea580c;">Aktif Radyoterapi Hasta Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Cihaz:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor me-1" style="color: #ea580c;"></i>
                                    <strong>Radyasyon Onkoloğu:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Radiation Oncology Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- LINAC Fractional Dose Counter & Technique Card -->
                    <div class="col-md-6">
                        <div class="card rad-card h-100 border-start border-4" style="border-left-color: #ea580c !important;">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0" style="color: #ea580c;"><i class="fa-solid fa-atom me-2"></i>LINAC Doz Hesabı & Fraksiyon İlerlemesi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Fraksiyon Sayacı:</span>
                                        <span class="badge bg-warning text-dark fs-6">22. Fraksiyon / 35 (%63)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Toplam Planlanan Doz:</span>
                                        <span class="fw-bold text-dark">70 Gray (Gy) (2 Gy / Fraksiyon)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Radyoterapi Tekniği:</span>
                                        <span class="badge bg-primary">VMAT (Volumetric Arc Therapy)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Fiksasyon Maskesi:</span>
                                        <span class="badge bg-secondary">Termoplastik Baş-Boyun Maskesi</span>
                                    </div>
                                </div>

                                <div class="p-2 rounded border small text-dark" style="background-color: #fff7ed; border-color: #ffedd5 !important;">
                                    <i class="fa-solid fa-circle-check me-1" style="color: #ea580c;"></i><strong>CBCT Görüntü Kılavuzluğu (IGRT):</strong> Günlük Konik Işınlı BT Verisiyle Pozisyon Doğrulandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CT Simulation & Target Volume (PTV/GTV) Card -->
                    <div class="col-md-6">
                        <div class="card rad-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-bullseye me-2"></i>BT Simülasyon & Hedef Hacim (PTV/GTV)</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">GTV (Gross Tumor Volume):</span>
                                        <span class="badge bg-danger">18.4 cm³ (Makroskobik Tümör)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">PTV (Planning Target Volume):</span>
                                        <span class="badge bg-primary">42.8 cm³ (Güvenlik Marjlı Hedef)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Riskli Organ Sınırı (OAR Dmax):</span>
                                        <span class="badge bg-success">Spinal Kord Dmax: 38 Gy (<45 Gy)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Parotis Koruma Skoru:</span>
                                        <span class="fw-bold text-dark">Sol Parotis V20 < %18</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Medikal Fizik Onayı:</strong> 3D Doz Histogramı (DVH) Fizikçi Tarafından Onaylandı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: CyberKnife / SBRT & Brachytherapy / Toxicity Cards -->
                <div class="row g-4 mb-4">
                    <!-- CyberKnife SRS / SBRT & Brachytherapy Card -->
                    <div class="col-md-6">
                        <div class="card rad-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-crosshairs me-2"></i>CyberKnife SRS / SBRT & HDR Brakiterapi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">CyberKnife SRS Dozu:</span>
                                        <span class="badge bg-danger">24 Gy Tek Doz Stereotaktik</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">HDR Brakiterapi (Ir-192):</span>
                                        <span class="badge bg-warning text-dark">3. Seans Tandem-Ring Aplikatör</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">4D-BT Solunum Kapısı (SBRT):</span>
                                        <span class="badge bg-success">Solunum Fazlı Işınlama Uygun</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                                    <strong>Yüksek Doz Hızlı Işınlama:</strong> İradyum-192 Kaynaklı 3D Brakiterapi Planı Uygulandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Toxicity & Side Effects (CTCAE) Card -->
                    <div class="col-md-6">
                        <div class="card rad-card h-100 border-start border-4 border-secondary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-shield-virus me-2"></i>Radyoterapi Yan Etki & Toksisite Takibi (CTCAE)</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Radyodermatit Derecesi:</span>
                                        <span class="badge bg-warning text-dark">Derece 1 (Hafif Eritem & Kuru Soyulma)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Oral Mukozit Skoru:</span>
                                        <span class="badge bg-danger">Grade 2 Mukozit (Yutma Güçlüğü)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Kemoradyoterapi Uyumu:</span>
                                        <span class="badge bg-success">Haftalık Sisplatin 40mg/m² Alıyor</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-secondary-subtle rounded border border-secondary-subtle small text-dark">
                                    <strong>Destek Tedavisi:</strong> Bikarbonatlı Gargara & Hyalüronik Asit Bazlı Epitelizan Krem Başlandı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card rad-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2" style="color: #ea580c;"></i>Radyasyon Onkolojisi Muayene & Doz Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('radiation_oncology.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Fraksiyon Dozu & Teşhis</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-warning" style="border-color: #ea580c !important; color: #ea580c;" value="22/35. Fraksiyon (70 Gy VMAT) - Grade 2 Mukozit">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Uygulanan Radyoterapi Tekniği</label>
                                    <select name="form_data[rt_technique]" class="form-select">
                                        <option value="VMAT (Volumetric Modulated Arc Therapy)">VMAT (Volumetric Arc Therapy)</option>
                                        <option value="CyberKnife Stereotaktik Radyocerrahi (SRS)">CyberKnife Stereotaktik SRS</option>
                                        <option value="SBRT Hipofraksiyone Radyoterapi (50 Gy/5fx)">SBRT Hipofraksiyone Radyoterapi</option>
                                        <option value="HDR Ir-192 Yüksek Doz Brakiterapi">HDR Ir-192 Yüksek Doz Brakiterapi</option>
                                        <option value="3D Conformal Radiotherapy (3D-CRT)">3D Conformal Radiotherapy (3D-CRT)</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Eş Zamanlı Kemoterapi / Krem</label>
                                    <input type="text" name="form_data[concomitant_med]" class="form-control" value="Haftalık Sisplatin 40mg/m² + Topikal Epitelizan Krem">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Radyasyon Onkoloğu Muayene & Dozimetre Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Cilt ve mukoza reaksiyon derecesi (CTCAE), günlük CBCT set-up kayma miktarı (mm), LINAC ışınlama süresi ve tümör konseyi kararı notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Radyasyon Onkoloğu: Prof. Dr. Tayfun Özcan</span>
                                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #ea580c;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Radyoterapi Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card rad-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-radiation fa-4x mb-3 opacity-40" style="color: #ea580c;"></i>
                        <h5>Radyoterapi Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
