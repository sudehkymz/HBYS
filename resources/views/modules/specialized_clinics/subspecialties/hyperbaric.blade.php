@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-mask-ventilator text-success me-2"></i>Sualtı Hekimliği ve Hiperbarik Tıp
@endsection

@section('page_description')
    Hiperbarik Oksijen Tedavisi (HBOT), Dekompresyon (Vurgun), diyabetik yara ve kronik osteomiyelit seansları.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- HBOT Pressure Chamber Log Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-gauge-high me-2"></i>Hiperbarik Oksijen (HBOT) Basınç Odası Parametreleri</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Basınç Odası Değeri:</span>
                        <span class="badge bg-success">2.5 ATA (Atmosphere Absolute)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Oksijen Konsantrasyonu:</span>
                        <span class="fw-bold text-dark">%100 Medikal Oksijen (Maske ile)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Seans Süresi:</span>
                        <span class="badge bg-primary">90 Dakika (3 x 25 Dk Oksijen)</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-check-circle me-1"></i>Kulak eşitleme (Valsalva) kontrolü yapıldı, barotravma riski yok.
                </div>
            </div>
        </div>
    </div>

    <!-- Diabetic Foot Wagner & Osteomyelitis Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-foot-prints me-2"></i>Diyabetik Ayak Wagner Sınıflaması</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Wagner Yara Evresi:</span>
                        <span class="badge bg-danger">Evre 3 (Derin Yara + Osteomiyelit)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Transkütan Oksijen (TcPO2):</span>
                        <span class="fw-bold text-danger">18 mmHg (Dokularda Şiddetli Hipoksi)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Planlanan HBOT Seansı:</span>
                        <span class="badge bg-dark">30 Seans Hiperbarik Oksijen</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger small text-dark">
                    <strong>HBOT Hedefi:</strong> Dokularda TcPO2 değerini >40 mmHg üzerine çıkararak neovaskülarizasyonu uyarmak.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-mask-ventilator me-2 text-success"></i>Hiperbarik Tıp Seans & Hasta Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="hyperbaric_medicine">
            <input type="hidden" name="redirect_route" value="specialized.hyperbaric">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">HBOT Basınç Değeri (ATA)</label>
                    <input type="text" name="status_score" class="form-control fw-bold border-success text-success" value="2.5 ATA Basınç Odası (90 Dk)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Endikasyon / Teşhis Tipi</label>
                    <select name="sub_specialty_data[indication]" class="form-select">
                        <option value="Diyabetik Ayak & İyileşmeyen Yara">Diyabetik Ayak & İyileşmeyen Yara</option>
                        <option value="Kronik Refrakter Osteomiyelit">Kronik Refrakter Osteomiyelit</option>
                        <option value="Dekompresyon Hastalığı (Vurgun)">Dekompresyon Hastalığı (Vurgun)</option>
                        <option value="Karbonmonoksit Zehirlenmesi">Karbonmonoksit Zehirlenmesi</option>
                        <option value="Ani İşitme Kaybı">Ani İşitme Kaybı</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tamamlanan / Toplam Seans</label>
                    <input type="text" name="sub_specialty_data[session_progress]" class="form-control" value="12. Seans / 30 Seanslık Tedavi">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Sualtı Hekimi Klinik Seans & Yara Takip Notları</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="Yara dokusu granülasyonu, TcPO2 transkütan oksijen ölçümü, kulak zarı muayenesi ve basınç odası dalış notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Sualtı Hekimi: Uzm. Dr. Barış Güven</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>HBOT Seansını Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
