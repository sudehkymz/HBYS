@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-bed-pulse text-success me-2"></i>Uyku Polikliniği (Polisomnografi - PSG)
@endsection

@section('page_description')
    Tüm gece Polisomnografi (PSG) testi, Apne-Hipopne İndeksi (AHI), CPAP/BPAP titrasyonu.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- PSG Apnea-Hypopnea Index (AHI) Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-square-poll-vertical me-2"></i>Polisomnografi (PSG) AHI Skoru</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Apne-Hipopne İndeksi (AHI):</span>
                        <span class="badge bg-danger">AHI: 34.2 / Saat (Ağır OSAS)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Gece Minimum SpO2:</span>
                        <span class="fw-bold text-danger">%78 SpO2 (Şiddetli Desatürasyon)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">En Uzun Apne Süresi:</span>
                        <span class="small text-muted">48 Saniye (Obstrüktif Apne)</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-circle-check me-1"></i>Sınıflama: <strong>Ağır Derece Obstrüktif Uyku Apne Sendromu (OSAS)</strong>.
                </div>
            </div>
        </div>
    </div>

    <!-- CPAP / BPAP Titration & Epworth Scale Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-mask-ventilator me-2"></i>CPAP/BPAP Basınç Titrasyonu</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Optimum CPAP Basıncı:</span>
                        <span class="badge bg-primary">9.5 cmH2O Basınç</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Epworth Uykululuk Skalası (ESS):</span>
                        <span class="badge bg-warning text-dark">16 / 24 Puan (Şiddetli Gündüz Uykululuğu)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Cihaz Reçete Önerisi:</span>
                        <span class="small text-muted">Otomatik CPAP (Auto-CPAP) Cihazı</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small">
                    <i class="fa-solid fa-file-medical me-1"></i>SGK Medula Cihaz Heyet Raporu Düzenlendi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-bed-pulse me-2 text-success"></i>Uyku Polikliniği PSG & CPAP Rapor Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="sleep_clinic">
            <input type="hidden" name="redirect_route" value="specialized.sleep">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">AHI Skoru & OSAS Derecesi</label>
                    <input type="text" name="status_score" class="form-control fw-bold border-success text-success" value="AHI: 34.2 / Saat (Ağır OSAS)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">CPAP / BPAP Titrasyon Basıncı</label>
                    <input type="text" name="sub_specialty_data[cpap_pressure]" class="form-control" value="9.5 cmH2O Otomatik CPAP">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Epworth Uykululuk Skalası (ESS)</label>
                    <input type="number" name="sub_specialty_data[ess_score]" class="form-control" value="16">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">PSG Raporu & Uyku Hekimi Notları</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="Tüm gece uyku mimarisi, REM/NREM süreleri, horlama indeksi, periyodik bacak hareketi ve CPAP reçetesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Uyku Hekimi: Prof. Dr. Zafer Yılmaz</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Uyku Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
