@extends('modules.ophthalmology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-gauge-high me-2 text-warning"></i>Glokom Birimi
@endsection

@section('page_description')
    Göz içi basınç (GİB) takibi, paşimetri kornea kalınlığı, OCT RNFL sinir lifi & Humphrey görsel alan perimetrisi.
@endsection

@section('ophthalmology_workspace')
<div class="row g-4 mb-4">
    <!-- IOP Curve & Central Corneal Thickness (CCT) Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-gauge-high me-2"></i>Göz İçi Basıncı (GİB) & Kornea Paşimetri</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Goldmann Tonometri GİB:</span>
                        <span class="badge bg-danger fs-6">OD: 24 mmHg / OS: 18 mmHg</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Merkezi Kornea Kalınlığı (CCT):</span>
                        <span class="fw-bold text-dark">535 µm (Düzeltilmiş Hedef GİB 22 mmHg)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Ön Kamara Açısı (Goniyoskopi):</span>
                        <span class="badge bg-success">Evre 4 Açık Açı (Shaffer Sınıflaması)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Cup/Disk (C/D) Oranı:</span>
                        <span class="badge bg-warning text-dark">OD C/D: 0.7 Glokomatöz Çukurlaşma</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Glokom Tedavi Protokolü:</strong> SLT (Selektif Lazer Trabeküloplasti) Lazer Uygulaması Planlandı.
                </div>
            </div>
        </div>
    </div>

    <!-- OCT RNFL & Humphrey Visual Field Perimetry Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-chart-line me-2"></i>OCT RNFL Sinir Lifi & Görsel Alan Perimetrisi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">OCT Retinal Sinir Lifi (RNFL):</span>
                        <span class="badge bg-danger">Superior & İnferior Kadran İnceltme</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Humphrey Görsel Alan MD Değeri:</span>
                        <span class="badge bg-warning text-dark">MD: -4.8 dB (Glokomatöz Skotom)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">GHT (Hemifield Test):</span>
                        <span class="badge bg-danger">Outside Normal Limits (Anormal)</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <strong>Antiglokomatöz İlaç:</strong> Latanoprost 0.005% Gece 1x1 + Timolol/Dorzolamid 2x1 Kombinasyonu Başlatıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card oph-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-gauge-high me-2 text-warning"></i>Glokom Birimi Muayene & Lazer Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('ophthalmology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="glaucoma">
            <input type="hidden" name="redirect_route" value="ophthalmology.glaucoma">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Glokom Teşhisi & GİB Değeri</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-warning text-dark" value="PAAG Açık Açılı Glokom - GİB OD 24 mmHg (C/D: 0.7, MD: -4.8 dB)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Antiglokomatöz İlaç / Prosedür</label>
                    <select name="sub_specialty_data[glaucoma_med]" class="form-select">
                        <option value="Latanoprost 0.005% + Timolol/Dorzolamid">Latanoprost + Timolol/Dorzolamid</option>
                        <option value="SLT (Selektif Lazer Trabeküloplasti)">SLT Selektif Lazer Trabeküloplasti</option>
                        <option value="Trabekülektomi Cerrahi + Mitomisin-C">Trabekülektomi Cerrahi + MMC</option>
                        <option value="Ahmed Glokom Valf Tüp İmplantasyonu">Ahmed Glokom Valf İmplantasyonu</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kornea Paşimetri & RNFL Bulgusu</label>
                    <input type="text" name="sub_specialty_data[pachymetry_rnfl]" class="form-control" value="CCT: 535 µm, Superior/İnferior RNFL Defekti">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Glokom Hekimi Muayene Notları & Perimetri</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Göz içi basınç trendi, optic disk ekskavasyon görünümü (C/D), Humphrey görme alanı skotom yayılımı, SLT lazer atış sayısı ve hedef GİB belirleme notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Glokom Hekimi: Doç. Dr. Meltem Yılmaz</span>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Glokom Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
