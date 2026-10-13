@extends('modules.ophthalmology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-arrows-split-up-and-left me-2 text-primary"></i>Şaşılık & Pediatrik Oftalmoloji Birimi
@endsection

@section('page_description')
    Prizm kapama testleri (PD), Hirschberg refleksi, Titmus stereopsis, ambliyopi kapama & ekstraoküler kas cerrahisi.
@endsection

@section('ophthalmology_workspace')
<div class="row g-4 mb-4">
    <!-- Prism Deviation Angle & Hirschberg Reflex Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-arrows-split-up-and-left me-2"></i>Şaşılık Prizm Açısı (PD) & Hirschberg Testi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Şaşılık Açısı (Prizm Kapama):</span>
                        <span class="badge bg-primary fs-6">25 Prizm Diyoptri (PD) Sağ Ezotropya</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Hirschberg Korneal Işık Refleksi:</span>
                        <span class="fw-bold text-dark">+15° Temporal Kayma (İçe Şaşılık)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Ekstraoküler Kas Hareketleri:</span>
                        <span class="badge bg-success">Her 9 Yönde Kas Kısıtlılığı Yok</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Sikloplejik Refraksiyon:</span>
                        <span class="badge bg-info text-dark">OD: +3.50 D, OS: +1.25 D (Hipermetropi)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Şaşılık Ameliyat Planı:</strong> Bilateral İç Rektus Kas Geriletmesi (Recession 5.5mm) Planlandı.
                </div>
            </div>
        </div>
    </div>

    <!-- Amblyopia & Titmus Stereopsis Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-child me-2"></i>Ambliyopi (Göz Tembelliği) & Stereopsis</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Titmus Fly Derinlik Hissi (Stereoacuity):</span>
                        <span class="badge bg-success">100 arcsec (Binoküler Derinlik Algısı)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Ambliyopi Kapama Tedavisi:</span>
                        <span class="badge bg-warning text-dark">Sağ Göz İçin Günde 4 Saat Sol Göz Kapaması</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Fiksasyon Tipi (Visuscope):</span>
                        <span class="fw-bold text-dark">Santral Foveal Fiksasyon Korunuyor</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <strong>Pediatrik Takip:</strong> 3 Aylık Gözlük ve Kaplı Kapama Tedavisi Sonrası Görme Keskinliği 0.4'ten 0.7'ye Yükseldi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card oph-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-arrows-split-up-and-left me-2 text-primary"></i>Şaşılık Birimi Muayene & Cerrahi Planlama Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('ophthalmology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="strabismus">
            <input type="hidden" name="redirect_route" value="ophthalmology.strabismus">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Şaşılık Teşhisi & Prizm Açısı (PD)</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="İnfantil Ezotropya - 25 PD Sağ Kayma (Ambliyopi Kapama 4 Saat/gün)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Planlanan Şaşılık Ameliyatı</label>
                    <select name="sub_specialty_data[strabismus_surg]" class="form-select">
                        <option value="Bilateral İç Rektus Geriletmesi (Recession 5.5mm)">Bilateral İç Rektus Geriletmesi (5.5mm)</option>
                        <option value="Tek Taraflı Rektus Rezeksiyonu + Geriletmesi">Rektus Rezeksiyonu + Geriletmesi</option>
                        <option value="Alt Oblik Kas Zayıflatması (Myektomi)">Alt Oblik Kas Myektomisi</option>
                        <option value="Akomodatif Ezotropya Gözlük Tedavisi">Akomodatif Ezotropya Gözlük Tedavisi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Stereopsis & Ambliyopi Reçetesi</label>
                    <input type="text" name="sub_specialty_data[amblyopia_protocol]" class="form-control" value="Titmus: 100 arcsec, Günde 4 Saat Göz Kapaması">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Şaşılık Uzmanı Muayene Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Göz hareketleri (9 yön), diplopi şikayeti, nistagmus varlığı, sikloplejik refraksiyon derecesi, prizm kapama test açısı ve cerrahi milimetre ölçüm notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Şaşılık Uzmanı: Uzm. Dr. Aylin Can</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Şaşılık Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
