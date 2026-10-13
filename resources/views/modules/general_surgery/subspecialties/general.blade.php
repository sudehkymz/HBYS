@extends('modules.general_surgery.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-scalpel me-2 text-danger"></i>Genel Cerrahi Polikliniği (Ana Branş)
@endsection

@section('page_description')
    Laparoskopik kolesistektomi, apandektomi, hernioplasti, pre-op ASA anestezi skoru & Jackson-Pratt dren takibi.
@endsection

@section('general_surgery_workspace')
<div class="row g-4 mb-4">
    <!-- ASA Score & Anesthesia Pre-Op Clearance Card -->
    <div class="col-md-6">
        <div class="card surg-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-heart-pulse me-2"></i>ASA Anestezi Derecesi & Pre-Op Değerlendirme</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">ASA Fiziksel Durum Skoru:</span>
                        <span class="badge bg-danger fs-6">ASA II (Sistemik Hastalık Kontrollü)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Mallampati Hava Yolu Skoru:</span>
                        <span class="badge bg-primary">Class I (Kolay Entübasyon)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">NPO (Açlık) Durumu:</span>
                        <span class="badge bg-warning text-dark">8 Saat Katı/Sıvı Açlık Tam</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Pre-Op Kan Hazırlığı:</span>
                        <span class="fw-bold text-dark">2 Ünite ES Rezerve (Crossmatch Uygun)</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Anestezi Onayı:</strong> Genel Anestezi Altında Ameliyat Edilebilir Onayı Verildi.
                </div>
            </div>
        </div>
    </div>

    <!-- Surgical Procedure & Intra-Op Details Card -->
    <div class="col-md-6">
        <div class="card surg-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-scissors me-2"></i>Ameliyat Tekniği & İntra-Op Parametreler</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Uygulanan Ameliyat:</span>
                        <span class="badge bg-primary">Laparoskopik Kolesistektomi</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Cerrahi Yaklaşım:</span>
                        <span class="fw-bold text-dark">4 Port Minimal İnvaziv Laparoskopi</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">İntra-Op Kanama Miktarı:</span>
                        <span class="badge bg-success"> Minimal (<30 ml)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Cerrahi Sınır (Frozen):</span>
                        <span class="badge bg-success">Salim (Cerrahi Sınır Temiz)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>Spesimen / Patoloji:</strong> Safra Kesesi Spesimeni Histopatolojik İncelemeye Gönderildi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card surg-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-file-medical me-2 text-danger"></i>Genel Cerrahi Muayene & Ameliyat Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('general_surgery.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="general">
            <input type="hidden" name="redirect_route" value="general_surgery.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Cerrahi Teşhis & ASA Skoru</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="Semptomatik Kolelitiazis - Laparoskopik Kolesistektomi (ASA II)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Ameliyat Türü / Yaklaşım</label>
                    <select name="sub_specialty_data[surg_type]" class="form-select">
                        <option value="Laparoskopik Kolesistektomi (Minimal İnvaziv)">Laparoskopik Kolesistektomi</option>
                        <option value="Laparoskopik Apandektomi">Laparoskopik Apandektomi</option>
                        <option value="Lichtenstein İnguinal Hernioflasti (Mesh)">Lichtenstein İnguinal Hernioflasti</option>
                        <option value="Total Tiroidektomi & Santral Dissection">Total Tiroidektomi & Santral Dissection</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Dren Debisi & Mayi Karakteri</label>
                    <input type="text" name="sub_specialty_data[drain_status]" class="form-control" value="Jackson-Pratt Dren: 30 ml/gün Seröz Mayi">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Cerrah Ameliyat Notları & Post-Op İnceleme</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Abdominal palpasyon, hassasiyet/defans/rebound varlığı, insizyon hattı Pansuman görünümü, dren çıkışı miktar/renk takibi ve taburculuk kriterleri notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Sorumlu Cerrah: Prof. Dr. Cemalettin Ertekin</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Cerrahi Kaydı Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
