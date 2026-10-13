@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-ban-smoking text-success me-2"></i>Sigarayı Bıraktırma Kliniği
@endsection

@section('page_description')
    Fagerström Nikotin Bağımlılık Testi, ekspirasyon Karbonmonoksit (CO) ölçümü, medikal tedavi planlaması.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- Fagerström Nicotine Dependence Scale Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-calculator me-2"></i>Fagerström Nikotin Bağımlılık Skalası</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Fagerström Skoru:</span>
                        <span class="badge bg-danger">8 / 10 Puan (Şiddetli Bağımlılık)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Günde İÇilen Sigara:</span>
                        <span class="fw-bold text-dark">30 Dal / Gün (1.5 Paket/Gün)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Uyandıktan Sonra İlk Sigara:</span>
                        <span class="small text-muted">İlk 5 Dakika İçinde</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-circle-check me-1"></i>Yüksek bağımlılık düzeyi nedeniyle Kombine Medikal Tedavi (Vareniklin + NRT) önerilir.
                </div>
            </div>
        </div>
    </div>

    <!-- Exhaled CO Monitor & Pharmacotherapy Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-gauge me-2"></i>Ekspirasyon CO Ölçümü & Medikal Reçete</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Nefes Karbonmonoksit (CO):</span>
                        <span class="badge bg-danger">18 ppm (Ağır İntoksikasyon)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kandaki Karboksihemoglobin:</span>
                        <span class="fw-bold text-dark">%3.2 COHb Düzeyi</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Reçete Edilen İlaç:</span>
                        <span class="badge bg-primary">Vareniklin 0.5mg / 1mg Başlangıç Paketi</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Bırakma Günü (Quit Date):</strong> 2 Hafta Sonra Cuma Günü Olarak Belirlendi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-ban-smoking me-2 text-success"></i>Sigarayı Bıraktırma Poliklinik Değerlendirme Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="smoking_cessation">
            <input type="hidden" name="redirect_route" value="specialized.smoking_cessation">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Fagerström Skoru & Bağımlılık Seviyesi</label>
                    <input type="text" name="status_score" class="form-control fw-bold border-success text-success" value="8/10 Puan (Şiddetli Bağımlılık)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Ekspirasyon Karbonmonoksit (CO ppm)</label>
                    <input type="number" name="sub_specialty_data[co_ppm]" class="form-control" value="18">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Reçete Edilen Farmakoterapi</label>
                    <select name="sub_specialty_data[medication]" class="form-select">
                        <option value="Vareniklin 0.5mg/1mg (Champix)">Vareniklin 0.5mg/1mg (Champix)</option>
                        <option value="Bupropion 150mg (Zyban)">Bupropion 150mg (Zyban)</option>
                        <option value="Nikotin Bandı (NRT Patch 21mg)">Nikotin Bandı (NRT Patch 21mg)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Sigarayı Bıraktırma Muayene & Motivasyonel Görüşme Notları</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="Sigara içme süresi (paket-yıl), tetikleyici faktörler, nüks önleme stratejileri ve kontrol randevu tarihi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Uzm. Dr. Serkan Bulut</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Bıraktırma Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
