@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-x-ray text-primary me-2"></i>Ağız, Diş ve Çene Radyolojisi
@endsection

@section('page_description')
    Panoramik röntgen (OPG), periapikal film inceleme, 3D CBCT diş ve çene tomografisi raporlama.
@endsection

@section('dental_workspace')
<div class="row g-4 mb-4">
    <!-- Panoramic & CBCT Imaging Card -->
    <div class="col-md-7">
        <div class="card dental-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-photo-film me-2"></i>Panoramik Röntgen (OPG) & CBCT Radyoloji Görüntüleyici</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-dark text-white rounded text-center mb-3">
                    <i class="fa-solid fa-x-ray fa-3x mb-2 text-info opacity-75"></i>
                    <div class="fw-bold">Dijital OPG Panoramik Röntgen Radyogramı</div>
                    <div class="small text-white-50">Çekim Tarihi: Bugün 09:15 | Doz: 12 µSv | Sensör: Dijital CMOS Sensor</div>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded border">
                            <span class="small fw-bold d-block text-dark">Üst Çene Sinüs Tabanı:</span>
                            <span class="small text-muted">Sağ Maksiller Sinüs Tabanı İntakt.</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded border">
                            <span class="small fw-bold d-block text-dark">Inferior Alveoler Kanal:</span>
                            <span class="small text-muted">Kanal Seyri Normal (İmplant Emniyeti: 4mm).</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Periapical & CBCT Scan Findings -->
    <div class="col-md-5">
        <div class="card dental-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-cube me-2"></i>3D CBCT Tomografi Bulguları</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kemik Yüksekliği (Vertical Height):</span>
                        <span class="fw-bold text-dark">13.2 mm</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kemik Genişliği (Bucco-Lingual):</span>
                        <span class="fw-bold text-dark">6.8 mm</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Periapikal Radyolüsensi:</span>
                        <span class="badge bg-danger">Diş #21 Kök Ucu Lezyonu</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small">
                    <i class="fa-solid fa-info-circle text-info me-1"></i><strong>Periapikal İndeks (PAI):</strong> PAI 3 (Belirgin Kemiğin Yoğunluk Kaybı).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-x-ray me-2 text-primary"></i>Ağız ve Çene Radyolojisi Rapor Giriş Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_radiology">
            <input type="hidden" name="redirect_route" value="dental.radiology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Radyolojik Görüntüleme Tipi</label>
                    <select name="sub_specialty_data[imaging_type]" class="form-select">
                        <option value="Panoramik Röntgen (OPG)">Panoramik Röntgen (OPG)</option>
                        <option value="Periapikal Röntgen Film">Periapikal Röntgen Film</option>
                        <option value="3D CBCT Konik Işınlı Tomografi">3D CBCT Konik Işınlı Tomografi</option>
                        <option value="Sefalometrik Röntgen Film">Sefalometrik Röntgen Film</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Periapikal Kök Ucu Lezyon Varlığı</label>
                    <input type="text" name="sub_specialty_data[periapical_lesion]" class="form-control" value="Diş #21 Kök Ucunda 3mm Radyolüsent Lezyon">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">TMJ (Çene Eklemi) Kondil Durumu</label>
                    <input type="text" name="sub_specialty_data[tmj_status]" class="form-control" value="Kondil Başları Bilateral Simetrik, Erozyon Yok">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Radyoloji Uzmanı Rapor Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Diş kök yapısı, kemik rezorpsiyon derecesi, gömülü dişlerin mandibular sinir ile komşuluğu ve kist/tümör bulguları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Radyolog: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Radyoloji Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
