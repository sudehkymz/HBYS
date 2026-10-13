@extends('modules.anesthesiology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-bolt me-2 text-warning"></i>Algoloji Polikliniği (Ağrı Yan Dalı)
@endsection

@section('page_description')
    Kronik ağrı tedavisi, C-kollu skopi altında epidural enjeksiyon, radyofrekans termokoagülasyon (RF) & sempatik blok.
@endsection

@section('anesthesiology_workspace')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card ans-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-bolt me-2"></i>Skopi Rehberliğinde Girişimsel Ağrı Bloğu</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Görsel Ağrı Skoru (VAS 0-10):</span>
                        <span class="badge bg-danger fs-6">VAS 8/10 (Şiddetli Nöropatik Ağrı)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Girişimsel Blok Yöntemi:</span>
                        <span class="badge bg-warning text-dark">Sol L5-S1 Transforaminal Epidural Enjeksiyon</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Radyofrekans Rizoctomy (RF):</span>
                        <span class="fw-bold text-dark">L4-L5 Facet Eklem Pulsed RF (80°C / 90sn)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Opioid / Nöropatik İlaç:</span>
                        <span class="badge bg-primary">Pregabalin 150mg 2x1 + Tramadol HCL</span>
                    </div>
                </div>
                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Girişim Sonrası Yanıt:</strong> Enjeksiyon Sonrası VAS Ağrı Skoru 8/10'dan 2/10'a Geriledi.
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card ans-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-person-dots-from-line me-2"></i>Tetik Nokta & Sempatik Blokaj</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Miyofasiyal Tetik Nokta:</span>
                        <span class="badge bg-success fs-6">Kuru İğneleme + Lokal Anestezik Enjeksiyonu</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Sempatik Ganglion Bloğu:</span>
                        <span class="badge bg-info text-dark">Stellat Ganglion Bloğu / Splanchnic Blok</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Kanser Ağrısı Pompası:</span>
                        <span class="fw-bold text-dark">İntratekal Baklofen / Morfin Pompası İmplantı</span>
                    </div>
                </div>
                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <strong>Algoloji Takip Protokolü:</strong> 1 Ay Sonra Kontrol VAS Ağrı Değerlendirmesi Planlandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ans-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-bolt me-2 text-warning"></i>Algoloji Muayene & Ağrı Girişim Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('anesthesiology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="algology">
            <input type="hidden" name="redirect_route" value="anesthesiology.algology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Algoloji Teşhisi & VAS Skoru</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-warning text-dark" value="L5-S1 Radikülopati Kronik Ağrı - VAS 8/10 (Transforaminal Enjeksiyon)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Girişimsel Ağrı Prosedürü</label>
                    <select name="sub_specialty_data[algology_procedure]" class="form-select">
                        <option value="Skopi Altında Transforaminal Epidural Steroid">Transforaminal Epidural Enjeksiyon</option>
                        <option value="Facet Eklem Radyofrekans (RF) Rizoctomy">Facet Eklem Radyofrekans (RF)</option>
                        <option value="Miyofasiyal Tetik Nokta Lokal Anestezik">Tetik Nokta Lokal Anestezik</option>
                        <option value="İntratekal Morfin / Baklofen Pompası">İntratekal Ağrı Pompası</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Post-Girişim VAS Skoru</label>
                    <input type="text" name="sub_specialty_data[post_vas]" class="form-control" value="Pre-Op VAS 8/10 -> Post-Op VAS 2/10">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Algolog Muayene & Skopi Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="C-kollu skopi anjiografik opak yayılımı, kütanöz sıcaklık artışı, nöropatik ağrı ilacı dozajı ve fizyoterapi koordinasyon notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Algoloji Uzmanı: Doç. Dr. Nesrin Başar</span>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Algoloji Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
