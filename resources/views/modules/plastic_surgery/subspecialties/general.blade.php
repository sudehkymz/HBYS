@extends('modules.plastic_surgery.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-face-smile me-2" style="color: #d97706;"></i>Plastik, Rekonstrüktif ve Estetik Cerrahi (Ana Branş)
@endsection

@section('page_description')
    Mikrovasküler serbest flep nakli (ALT / DIEP Flep), greftleme (STSG/FTSG), rinoplasti & maksillofasiyal kırık rekonstrüksiyonu.
@endsection

@section('plastic_workspace')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card plastic-card h-100 border-start border-4" style="border-left-color: #d97706 !important;">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0" style="color: #d97706;"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>Mikrovasküler Serbest Flep Rekonstrüksiyonu</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Serbest Flep Türü:</span>
                        <span class="badge bg-warning text-dark fs-6">ALT (Anterolateral Uyluk) Perforatör Flep</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Pedikül Vasküler Anastomoz:</span>
                        <span class="badge bg-success">Torakodorsal Arter-Ven Mikronastomozu (9-0)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Flep Doku Perfuzyonu:</span>
                        <span class="fw-bold text-dark">Perlatör Ses Akımı Şiddetli (+), Sıcak Pembe</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Donör Saha İyileşmesi:</span>
                        <span class="badge bg-primary">Uyluk Donör Alanı Primer Sütür Edildi</span>
                    </div>
                </div>
                <div class="p-2 rounded border small text-dark" style="background-color: #fef3c7; border-color: #fde68a !important;">
                    <i class="fa-solid fa-circle-check me-1" style="color: #d97706;"></i><strong>Flep Takibi:</strong> Saatlik El Doppler Kontrolü (Venöz Staz / Kongesyon Yok).
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card plastic-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-bandage me-2"></i>Cilt Greftleme (STSG) & Estetik Cerrahi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kısmi Kalınlıkta Cilt Grefti (STSG):</span>
                        <span class="badge bg-success fs-6">Mesh Greft %100 Tutunma (Inosculation +)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Rinoplasti / Maksillofasiyal:</span>
                        <span class="badge bg-info text-dark">Açık Yapısal Rinoplasti + Septal Kıkırdak Grefti</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Skor / Yara İyileşmesi:</span>
                        <span class="fw-bold text-dark">Silikon Jel Tabaka İle Hipertrofik Skar Önleme</span>
                    </div>
                </div>
                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <strong>Post-Op Pansuman:</strong> Tie-Over (Baskılı) Pansuman 5. Günde Berrak Olarak Açıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card plastic-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-file-medical me-2" style="color: #d97706;"></i>Plastik Cerrahi Muayene & Flep Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('plastic_surgery.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="general">
            <input type="hidden" name="redirect_route" value="plastic_surgery.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Plastik Cerrahi Teşhisi & Flep Türü</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-warning text-dark" value="Mastektomi Sonrası Serbest ALT Perforatör Flep Rekonstrüksiyonu (Doppler +)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Rekonstrüktif / Estetik Operasyon</label>
                    <select name="sub_specialty_data[plastic_surg_type]" class="form-select">
                        <option value="Serbest Mikrovasküler ALT / DIEP Flep Nakli">Serbest Mikrovasküler ALT / DIEP Flep</option>
                        <option value="Kısmi Kalınlıkta Cilt Grefti (STSG Mesh)">Kısmi Kalınlık Cilt Grefti (STSG)</option>
                        <option value="Açık Yapısal Rinoplasti & Septoplasti">Açık Yapısal Rinoplasti Cerrahisi</option>
                        <option value="Maksillofasiyal Kırık Plak-Vida Fiksasyonu">Maksillofasiyal Kırık Plak-Vida Fiksasyonu</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Flep Canlılık & Doppler Akımı</label>
                    <input type="text" name="sub_specialty_data[flap_metrics]" class="form-control" value="Doppler akımı (+), Pembe doku, Tie-over pansuman açıldı">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Plastik Cerrah Muayene & Ameliyat Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Flep boyutları, perforatör damar çapı, mikrovasküler anastomoz süresi, donör saha kapatılması ve post-op flep izlem çizelgesi notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Plastik Cerrah: Prof. Dr. Deniz Güneş</span>
                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #d97706;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Plastik Cerrahi Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
