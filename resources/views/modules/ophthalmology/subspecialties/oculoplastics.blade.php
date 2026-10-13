@extends('modules.ophthalmology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-wand-magic-sparkles me-2 text-success"></i>Oküloplasti & Göz Çevresi Cerrahisi Birimi
@endsection

@section('page_description')
    Göz kapağı pitozis MRD-1 ölçümü, levator fonksiyonu, blefaroplasti, dakriyosistorinostomi (DSR göz yaşı kanalı) & ektropiyon.
@endsection

@section('ophthalmology_workspace')
<div class="row g-4 mb-4">
    <!-- Ptosis MRD-1 & Levator Function Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-eye me-2"></i>Pitozis MRD-1 Derecesi & Levator Fonksiyonu</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Marginal Reflex Distance (MRD-1):</span>
                        <span class="badge bg-danger fs-6">OS MRD-1: 1.0 mm (Şiddetli Pitozis)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Levator Kas Fonksiyonu:</span>
                        <span class="badge bg-success">12 mm (İyi Kas Aksiyonu >10mm)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kapak Katlantı Yüksekliği:</span>
                        <span class="fw-bold text-dark">7.0 mm Symmetrical Crease</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Bell Fenomeni (Kornea Güvenliği):</span>
                        <span class="badge bg-success">Pozitif (Göz Yukarı Kayma Normal)</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Cerrahi Yaklaşım:</strong> Sol Levator Aponöroz Rezeksiyonu + Üst Kapak Blefaroplasti Onaylandı.
                </div>
            </div>
        </div>
    </div>

    <!-- Dacryocystorhinostomy (DSR) & Eyelid Aesthetics Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-droplet me-2"></i>DSR (Göz Yaşı Kanalı) & Kapak Estetiği</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Nasolakrimal Kanal Tıkanıklığı:</span>
                        <span class="badge bg-primary">Eksternal DSR + Silikon Tüp Entübasyonu</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Göz Yaşı Lavajı (Siringalama):</span>
                        <span class="badge bg-warning text-dark">Punktum Açık, Kanal Reflü Veriyor</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Ektropiyon / Entropiyon:</span>
                        <span class="fw-bold text-dark">Alt Kapak Laksitesi & Lateral Tarsal Strip</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>Post-Op DSR Bakımı:</strong> İntranazal Steroid Sprey + Tobramisin Göz Damlası Başlatıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card oph-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-wand-magic-sparkles me-2 text-success"></i>Oküloplasti Birimi Muayene & Kapak Cerrahi Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('ophthalmology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="oculoplastics">
            <input type="hidden" name="redirect_route" value="ophthalmology.oculoplastics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Oküloplasti Teşhisi & MRD-1</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-success text-success" value="Senil Pitozis - Sol MRD-1: 1.0mm (Levator Rezeksiyonu + Blefaroplasti)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Oküloplastik Cerrahi Yöntemi</label>
                    <select name="sub_specialty_data[oculoplastic_surg]" class="form-select">
                        <option value="Levator Aponöroz Rezeksiyonu (Pitozis)">Levator Aponöroz Rezeksiyonu</option>
                        <option value="Üst / Alt Kapak Blefaroplasti">Üst / Alt Kapak Blefaroplasti</option>
                        <option value="Eksternal Dakriyosistorinostomi (DSR + Tüp)">Eksternal DSR + Silikon Tüp</option>
                        <option value="Entropiyon / Ektropiyon Laksite Onarımı">Ektropiyon / Entropiyon Onarımı</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Levator Fonksiyonu & Bell Fenomeni</label>
                    <input type="text" name="sub_specialty_data[levator_detail]" class="form-control" value="Levator Fonksiyonu: 12 mm, Bell Fenomeni Pozitif">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Oküloplasti Cerrahı Muayene Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Göz kapağı kenar simetrisi, lagoftalmus (kapak açık kalması) varlığı, kornea lekelenmesi, lakrimal kese bası akıntısı ve dikiş alma takvim notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Oküloplasti Cerrahı: Uzm. Dr. Aylin Can</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Oküloplasti Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
