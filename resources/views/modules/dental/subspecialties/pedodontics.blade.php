@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-child text-primary me-2"></i>Çocuk Diş Hekimliği (Pedodonti)
@endsection

@section('page_description')
    Süt dişi ampütasyonu/pulpotomi, yer tutucu planlaması, flor uygulaması ve fissür örtücü.
@endsection

@section('dental_workspace')
<div class="row g-4 mb-4">
    <!-- Primary Teeth & Pulpotomy Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-baby me-2"></i>Süt Dişi Pulpotomi & Dolgu Tedavisi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Tedavi Edilen Süt Dişi:</span>
                        <span class="badge bg-primary">Süt Dişi #54 (Sağ Üst 1. Süt Azı)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Pulpa Tedavisi Tipi:</span>
                        <span class="badge bg-warning text-dark">Formokrezol Pulpotomi</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Üst Restorasyon:</span>
                        <span class="small text-muted">Paslanmaz Çelik Kron (PÇK)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small">
                    <i class="fa-solid fa-check-circle me-1"></i>Kanal ağızları MTA ile örtülerek PÇK simante edildi.
                </div>
            </div>
        </div>
    </div>

    <!-- Space Maintainer & Fluoride Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-shield-halved me-2"></i>Yer Tutucu & Koruyucu Pedodonti</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Yer Tutucu İhtiyacı:</span>
                        <span class="badge bg-danger">Sabit Sabit Kroşe Yer Tutucu</span>
                    </div>
                    <div class="small text-muted mb-2">Erken süt azı kaybı nedeniyle #75 bölgesine Bantlı-Lup yer tutucu planlandı.</div>
                </div>

                <div class="p-3 bg-success-subtle rounded border border-success">
                    <div class="fw-bold text-success small mb-1"><i class="fa-solid fa-sparkles me-1"></i>Koruyucu Uygulamalar:</div>
                    <div class="small text-dark">Tüm Daimi 6 Yaş Dişlerine (%5 NaF) <strong>Topikal Flor Jel + Fissür Örtücü</strong> Yapıldı.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-child me-2 text-primary"></i>Pedodonti (Çocuk Diş) Klinik Muayene Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_pedodontics">
            <input type="hidden" name="redirect_route" value="dental.pedodontics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pulpa Tedavisi (Pulpotomi/Amputasyon)</label>
                    <select name="sub_specialty_data[pulpotomy_status]" class="form-select">
                        <option value="Uygulanmadı">Uygulanmadı</option>
                        <option value="Pulpotomi + Paslanmaz Çelik Kron (PÇK)">Pulpotomi + Paslanmaz Çelik Kron (PÇK)</option>
                        <option value="Kanal Tedavisi (Pulpoktomi)">Kanal Tedavisi (Pulpoktomi)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Yer Tutucu Uygulaması (Space Maintainer)</label>
                    <select name="sub_specialty_data[space_maintainer]" class="form-select">
                        <option value="Gerek Yok">Gerek Yok</option>
                        <option value="Sabit Bant-Lup Yer Tutucu Yapıldı">Sabit Bant-Lup Yer Tutucu Yapıldı</option>
                        <option value="Hareketli Yer Tutucu Ölçüsü Alındı">Hareketli Yer Tutucu Ölçüsü Alındı</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Topikal Flor & Fissür Örtücü</label>
                    <input type="text" name="sub_specialty_data[fluoride_sealant]" class="form-control" value="Topikal Flor jeli sürüldü, 16, 26, 36, 46 fissür örtüldü">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Pedodontik Muayene & Çocuk Davranış Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Çocuk hasta kooperasyonu (Frankl Davranış Skalası), süt dişi çürük haritası, beslenme önerileri ve veli bilgilendirmesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Pedodontist: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Pedodonti Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
