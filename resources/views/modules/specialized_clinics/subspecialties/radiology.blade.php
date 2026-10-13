@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-x-ray text-success me-2"></i>Tanısal Radyoloji (MR, BT, USG, Mamografi)
@endsection

@section('page_description')
    Direkt Röntgen, Ultrasonografi (USG), Bilgisayarlı Tomografi (BT), MR ve Mamografi BIRADS raporlama.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- MRI & CT Imaging PACS Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-photo-film me-2"></i>Kranial & Toraks MR / BT PACS Bulguları</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Görüntüleme Modaliteleri:</span>
                        <span class="badge bg-success">Kontrastlı Beyin MR + Difüzyon</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kontrast Madde (İV Gadolinyum):</span>
                        <span class="fw-bold text-dark">15 mL IV Kontrast Verildi (Sıkıntı Yok)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Akut İskemi / Difüzyon Kısıtlılığı:</span>
                        <span class="small text-muted">Sol MCA Sulama Alanında Difüzyon Kısıtlanması</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-server me-1"></i>PACS Dijital Görüntüleme Numarası: <strong>PACS-2026-99182</strong>.
                </div>
            </div>
        </div>
    </div>

    <!-- Mammography BIRADS Classification Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-ribbon me-2"></i>Mamografi BIRADS Sınıflaması</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">BIRADS Kategorisi:</span>
                        <span class="badge bg-danger">BIRADS 4A (Düşük Şüpheli Kitle)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kitle Lokalizasyonu:</span>
                        <span class="fw-bold text-dark">Sağ Meme Üst Dış Kadran (12mm)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Mikrokalsifikasyon:</span>
                        <span class="small text-muted">Pleomorfik Kümeleşmiş Mikrokalsifikasyon</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger small text-dark">
                    <strong>Öneri:</strong> USG eşliğinde İnce İğne / Tru-Cut Biyopsi Önerilir.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-x-ray me-2 text-success"></i>Tanısal Radyoloji Uzman Rapor Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="radiology_diagnostic">
            <input type="hidden" name="redirect_route" value="specialized.radiology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">BIRADS / Rapor Özeti</label>
                    <input type="text" name="status_score" class="form-control fw-bold border-success text-success" value="BIRADS 4A (Şüpheli Kitle - Tru-Cut Biyopsi)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Radyolojik Görüntüleme Modalitesi</label>
                    <select name="sub_specialty_data[modality]" class="form-select">
                        <option value="Kontrastlı Beyin / Toraks MR">Kontrastlı Beyin / Toraks MR</option>
                        <option value="Tüm Batın BT (Bilgisayarlı Tomografi)">Tüm Batın BT (Bilgisayarlı Tomografi)</option>
                        <option value="Yüksek Çözünürlüklü USG">Yüksek Çözünürlüklü USG</option>
                        <option value="Dijital Mamografi">Dijital Mamografi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kontrast Madde / İv İlaç Dozu</label>
                    <input type="text" name="sub_specialty_data[contrast_agent]" class="form-control" value="15 mL IV Gadolinyum (Sıkıntı Yok, Kreatinin Normal)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Radyoloji Uzmanı Detaylı Rapor Metni</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="İncelenen kesitler, parankim sinyal değişiklikleri, boyut ölçümleri, kırık/tümör bulguları ve sonuç önerisi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Radyolog: Prof. Dr. Kemal Demirel</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Radyoloji Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
