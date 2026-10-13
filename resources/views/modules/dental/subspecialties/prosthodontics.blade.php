@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-gem text-primary me-2"></i>Protetik Diş Tedavisi (Protez)
@endsection

@section('page_description')
    Zirkonyum kaplama, porselen kron/köprü, total/parsiyel hareketli protez ve implant üstü protez.
@endsection

@section('dental_workspace')
<div class="row g-4 mb-4">
    <!-- Fixed Prosthesis & Zirconia Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-gem me-2"></i>Sabit Protez & Zirkonyum Kron Tasarımı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Protez Materyali:</span>
                        <span class="badge bg-primary">Monolitik Zirkonyum (CAD/CAM)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Restorasyon Bölgesi:</span>
                        <span class="fw-bold text-dark">Diş #14-#16 Köprü Restorasyonu</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Renk Seçimi (VITA Scale):</span>
                        <span class="badge bg-warning text-dark">VITA Shade A2 (Doğal Ton)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small">
                    <i class="fa-solid fa-check-circle me-1"></i>Hassas dijital intraoral tarama (CAD/CAM Scan) Laboratuvara iletildi.
                </div>
            </div>
        </div>
    </div>

    <!-- Removable Denture & Implant Prosthesis Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-teeth me-2"></i>Hareketli Protez & İmplant Üstü Abutment</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Protez Tipi:</span>
                        <span class="badge bg-info text-dark">Hassas Tutuculu İskelet Protez</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">İmplant Üstü Abutment:</span>
                        <span class="fw-bold text-dark">Multi-Unit Zirkonyum Abutment</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Prova Aşaması:</span>
                        <span class="badge bg-success">Dişli Prova Tamamlandı (Bitim)</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small">
                    <i class="fa-solid fa-clock me-1"></i><strong>Laboratuvar Teslim:</strong> Cuma 14:00 (Daimi Simantasyon).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-gem me-2 text-primary"></i>Protetik Diş Tedavisi Laboratuvar İstem Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_prosthodontics">
            <input type="hidden" name="redirect_route" value="dental.prosthodontics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Protez Tipi & Materyal</label>
                    <select name="sub_specialty_data[prosthesis_type]" class="form-select">
                        <option value="Zirkonyum Kaplama / Köprü">Zirkonyum Kaplama / Köprü</option>
                        <option value="E.max Lityum Disilikat Kron">E.max Lityum Disilikat Kron</option>
                        <option value="Metal Destekli Porselen (PFM)">Metal Destekli Porselen (PFM)</option>
                        <option value="Total Hareketli Protez (Damak)">Total Hareketli Protez (Damak)</option>
                        <option value="İmplant Üstü Vidalı Protez">İmplant Üstü Vidalı Protez</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">VITA Renk Seçimi</label>
                    <input type="text" name="sub_specialty_data[shade_selection]" class="form-control" value="VITA Skalası A2 Tonu">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Laboratuvar Prova Aşaması</label>
                    <select name="sub_specialty_data[stage]" class="form-select">
                        <option value="Altyapı Provası">Altyapı Provası</option>
                        <option value="Dentin / Dişli Prova">Dentin / Dişli Prova</option>
                        <option value="Bitim & Simantasyon">Bitim & Daimi Simantasyon</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Siman Tipi (Yapıştırıcı)</label>
                    <input type="text" name="sub_specialty_data[cement_type]" class="form-control" value="Reçine Siman (RelyX U200)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Protetik Muayene & Laboratuvar Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Preparasyon basamak tipi (Chamfer/Shoulder), oklüzal yüksekliğin kontrolü, dikey boyut ve lab iş emri detayları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Protez Uzmanı: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Protez Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
