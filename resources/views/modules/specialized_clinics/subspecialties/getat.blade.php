@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-leaf text-success me-2"></i>Geleneksel ve Tamamlayıcı Tıp (GETAT)
@endsection

@section('page_description')
    Bakanlık onaylı Akupunktur, Kupa/Hacamat, Sülük (Hirudoterapi), Ozon Tedavisi ve Mezoterapi seansları.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- Acupuncture Points & Meridian Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-hand-holding-medical me-2"></i>Akupunktur Meridyen & Nokta İğneleme</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Uygulanan Akupunktur Noktaları:</span>
                        <span class="badge bg-success">LI4 (Hegu), ST36 (Zusanli), SP6</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">İğne Tipi & Seans Süresi:</span>
                        <span class="fw-bold text-dark">0.25x25mm Çelik İğne (30 Dakika)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Elektro-Akupunktur Frekansı:</span>
                        <span class="badge bg-primary">2 Hz Düşük Frekans (Analjezik)</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-leaf me-1"></i>GETAT Tedavi Protokolü: <strong>10 Seanslık Akupunktur Kürü (3. Seans Tamamlandı)</strong>.
                </div>
            </div>
        </div>
    </div>

    <!-- Cupping / Hacamat & Ozone Therapy Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-droplet me-2"></i>Kupa / Hacamat & Ozon Terapi seansı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Hacamat (Yaş Kupa) Bölgesi:</span>
                        <span class="badge bg-danger">C7-T1 Interscapular & Bel Bölgesi</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Ozon Tedavisi (Major Otohemoterapi):</span>
                        <span class="fw-bold text-dark">35 µg/mL Konsantrasyon (100 mL Kan)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Sülük (Hirudoterapi) Adedi:</span>
                        <span class="badge bg-dark">4 Adet Medikal Sülük</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>GETAT Hekim Onayı:</strong> T.C. Sağlık Bakanlığı GETAT Sertifikalı Hekim Tarafından Yapıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-leaf me-2 text-success"></i>GETAT Seans Kayıt & Uygulama Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="getat_unit">
            <input type="hidden" name="redirect_route" value="specialized.getat">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Uygulanan GETAT Yöntemi</label>
                    <select name="sub_specialty_data[getat_method]" class="form-select">
                        <option value="Akupunktur (Vücut/Kulak)">Akupunktur (Vücut/Kulak)</option>
                        <option value="Kupa / Hacamat (Yaş Kupa)">Kupa / Hacamat (Yaş Kupa)</option>
                        <option value="Major Ozon Tedavisi">Major Ozon Tedavisi</option>
                        <option value="Sülük Tedavisi (Hirudoterapi)">Sülük Tedavisi (Hirudoterapi)</option>
                        <option value="Mezoterapi / Proloterapı">Mezoterapi / Proloterapı</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Seans Numarası / Toplam Kür</label>
                    <input type="text" name="status_score" class="form-control fw-bold border-success text-success" value="3. Seans / 10 Seanslık Kür">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Ozon Konsantrasyonu / Kupa Adedi</label>
                    <input type="text" name="sub_specialty_data[dosage_count]" class="form-control" value="Ozon: 35 ug/mL, Hacamat: 7 Kupa">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">GETAT Hekimi Klinik Seans Notları</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="Ağrı VAS skoru öncesi/sonrası, akupunktur noktaları, sterilizasyon protokolü ve bir sonraki seans tarihi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Sertifikalı Hekim: Dr. Mehmet Taş</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>GETAT Seansını Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
