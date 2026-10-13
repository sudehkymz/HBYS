@extends('modules.orthopedics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-bone me-2 text-warning"></i>Ortopedi ve Travmatoloji (Ana Branş)
@endsection

@section('page_description')
    Total diz/kalça protezi (Artroplasti TKA/THA), ön çapraz bağ (ÖÇB / ACL) artroskopisi & travma kırık fiksasyonu.
@endsection

@section('orthopedics_workspace')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card ortho-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-bone me-2"></i>Total Diz Protezi (TKA Arthroplasty)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kellgren-Lawrence Evresi:</span>
                        <span class="badge bg-danger fs-6">Evre 4 (Tam Eklem Daralması)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Diz Eklem Harabiyeti:</span>
                        <span class="badge bg-warning text-dark">Varus Deformitesi 12° & Osteofitler</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">İmplant Seçimi:</span>
                        <span class="fw-bold text-dark">Posterior Stabilize (PS) Çimentolu Protez</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Post-Op ROM Hareketi:</span>
                        <span class="badge bg-success">CPM Cihazı İle 0-90° Fleksiyon Uyumlu</span>
                    </div>
                </div>
                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Arthroplasti Takibi:</strong> Post-Op 1. Gün Yürüteç İle Tam Yük Verilerek Mobilize Edildi.
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card ortho-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-person-running me-2"></i>Artroskopik ÖÇB (ACL) Rekonstrüksiyonu</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Lachman & Çekmece Testi:</span>
                        <span class="badge bg-danger">Lachman (+++), Ön Çekmece Pozitif</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Otogreft Seçimi:</span>
                        <span class="badge bg-primary">Hamstring (Semitendinosus/Gracilis) Dörtlü Greft</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Femoral / Tibial Fiksasyon:</span>
                        <span class="fw-bold text-dark">Endobutton Femoral + Biyoemilebilir Vida Tibial</span>
                    </div>
                </div>
                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>Fizik Tedavi Protokolü:</strong> Açılı Dizlik (0-30°) İle Fizyoterapi Egzersiz Programı Başlatıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ortho-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-file-medical me-2 text-warning"></i>Ortopedi ve Travmatoloji Ameliyat Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('orthopedics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="general">
            <input type="hidden" name="redirect_route" value="orthopedics.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Ortopedik Teşhis & Protez Türü</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-warning text-dark" value="Evre 4 Gonartroz - Total Diz Protezi (TKA PS Çimentolu)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Cerrahi Prosedür</label>
                    <select name="sub_specialty_data[ortho_surg]" class="form-select">
                        <option value="Total Diz Protezi (TKA Arthroplasty)">Total Diz Protezi (TKA Arthroplasty)</option>
                        <option value="Total Kalça Protezi (THA Arthroplasty)">Total Kalça Protezi (THA Arthroplasty)</option>
                        <option value="Artroskopik Ön Çapraz Bağ (ÖÇB) Rekonstrüksiyonu">Artroskopik ÖÇB (ACL) Rekonstrüksiyonu</option>
                        <option value="İntramedüller Çivileme (IMN) Kırık Fiksasyonu">İntramedüller Çivileme Kırık Cerrahisi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Grafi & Mobilizasyon Notu</label>
                    <input type="text" name="sub_specialty_data[ortho_metrics]" class="form-control" value="CPM 0-90°, Post-Op Yürüteç İle Tam Yük Mobilizasyon">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Ortopedi Cerrahı Muayene & Cerrahi Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Eklem hareket açıklığı (ROM), kemik kesileri, osteofit temizliği, dengeleme, dren miktarı ve fizik tedavi başlama talimatları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Ortopedi Cerrahı: Prof. Dr. Zafer Alp</span>
                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #ea580c;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Ortopedi Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
