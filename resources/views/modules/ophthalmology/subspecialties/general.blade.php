@extends('modules.ophthalmology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-eye me-2" style="color: #0891b2;"></i>Göz Hastalıkları Polikliniği (Ana Branş)
@endsection

@section('page_description')
    Snellen görme keskinliği, otorefraktometre, Goldmann göz içi basıncı (GİB) & FAKO katarakt cerrahisi takibi.
@endsection

@section('ophthalmology_workspace')
<div class="row g-4 mb-4">
    <!-- Visual Acuity & Tonometry Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4" style="border-left-color: #0891b2 !important;">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0" style="color: #0891b2;"><i class="fa-solid fa-eye me-2"></i>Görme Keskinliği & Tonometri (GİB)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Snellen Görme Keskinliği:</span>
                        <span class="badge bg-primary fs-6">OD: 0.2 / OS: 0.9 (Snellen)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Göz İçi Basınç (GİB Goldmann):</span>
                        <span class="badge bg-success">OD: 15 mmHg / OS: 14 mmHg</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Autorefractor Ölçümü:</span>
                        <span class="fw-bold text-dark">OD: +2.50 / -1.25 x 90°</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Biyomikroskopi (Slit-Lamp):</span>
                        <span class="badge bg-secondary">Lens: Evre 3 Nükleer Sklerotik Katarakt</span>
                    </div>
                </div>

                <div class="p-2 rounded border small text-dark" style="background-color: #ecfeff; border-color: #a5f3fc !important;">
                    <i class="fa-solid fa-circle-check me-1" style="color: #0891b2;"></i><strong>Katarakt Cerrahisi Planı:</strong> FAKO + Katlanabilir Monofokal Göz İçi Lens (IOL) Ameliyatı Onaylandı.
                </div>
            </div>
        </div>
    </div>

    <!-- Phacoemulsification (FAKO) & Intraocular Lens Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>FAKO Katarakt Cerrahisi & IOL Biyometri</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">A-Scan Biyometri K-Değerleri:</span>
                        <span class="fw-bold text-dark">K1: 43.25 D, K2: 44.10 D</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Axial Length (AL Aksiyel Boy):</span>
                        <span class="badge bg-info text-dark">23.42 mm (Normal Aksiyel Uzunluk)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Hesaplanan IOL Gücü:</span>
                        <span class="badge bg-success fs-6">+21.5 D Monofokal Akrilik Göz İçi Lens</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <strong>Post-Op Reçete:</strong> Tobramisin/Deksametazon 4x1 + Nepafenak 0.1% Damla Başlatıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card oph-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-file-medical me-2" style="color: #0891b2;"></i>Göz Hastalıkları Muayene & FAKO Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('ophthalmology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="general">
            <input type="hidden" name="redirect_route" value="ophthalmology.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Göz Teşhisi & FAKO Planı</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-info" style="border-color: #0891b2 !important; color: #0891b2;" value="Senil Nükleer Katarakt - FAKO + Katlanabilir IOL İmplantasyonu">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Reçete Edilen Göz Damlası</label>
                    <select name="sub_specialty_data[eye_drops]" class="form-select">
                        <option value="Moxifloksasin 0.5% + Prednizolon Asetat 4x1">Moxifloksasin + Prednizolon Damla</option>
                        <option value="Tobramisin/Deksametazon (TobraDex) 4x1">Tobramisin/Deksametazon 4x1</option>
                        <option value="Nepafenak 0.1% Antiinflamatuar Damla">Nepafenak 0.1% Antiinflamatuar</option>
                        <option value="Sodyum Hiyaluronsat Suni Göz Yaşı 4x1">Sodyum Hiyaluronat Suni Göz Yaşı</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Göz İçi Basınç (GİB) & IOL Gücü</label>
                    <input type="text" name="sub_specialty_data[iop_biometry]" class="form-control" value="OD: 15 mmHg, IOL: +21.5 D Monofokal">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Göz Hekimi Muayene Notları & Biyomikroskopi</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Kornea saydamlığı, ön kamara derinliği (Tyndall reaksiyonu), pupil refleksi, lens skleroz derecesi, fundus/makula muayenesi ve ameliyat kararı notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Göz Hekimi: Prof. Dr. Halil İbrahim Altın</span>
                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #0891b2;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Göz Muayene Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
