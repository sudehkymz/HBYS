@extends('modules.ophthalmology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-sun me-2 text-info"></i>Kornea & Refraktif Cerrahi Birimi
@endsection

@section('page_description')
    Pentacam kornea topografisi, keratokonus Kmax takibi, Corneal Cross-Linking (CXL), Femto-LASIK & Kornea Nakli (PKP/DMEK).
@endsection

@section('ophthalmology_workspace')
<div class="row g-4 mb-4">
    <!-- Pentacam Topography & Keratoconus Kmax Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-sun me-2"></i>Pentacam Kornea Topografisi & Keratokonus</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Keratometri (Kmax Tepe Değeri):</span>
                        <span class="badge bg-danger fs-6">Kmax: 54.8 D (Progresif Keratokonus)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">En İnce Kornea Noktası:</span>
                        <span class="badge bg-warning text-dark">440 µm (CXL İçin Güvenli Sınır)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kornea Astigmatizması:</span>
                        <span class="fw-bold text-dark">-4.25 D @ 85° Düzensiz Astigmatizma</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">BELIN-AMBROSIO İndeksi:</span>
                        <span class="badge bg-danger">BAD-D: 4.85 (Keratokonus Ektopi)</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Çapraz Bağlama Protokolü:</strong> Epi-Off Riboflavin + UV-A Corneal Cross-Linking (CXL) Planlandı.
                </div>
            </div>
        </div>
    </div>

    <!-- Refractive Surgery & Keratoplasty (PKP/DMEK) Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-eye me-2"></i>Refraktif Lazer & Kornea Nakli (Keratoplasti)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Refraktif Cerrahi Yöntemi:</span>
                        <span class="badge bg-success">Femto-LASIK / PRK / SMILE Lazer</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Penetran Keratoplasti (PKP):</span>
                        <span class="fw-bold text-dark">Donör Kornea Grefti 7.5mm (Graft Berrak)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Endotelyal Keratoplasti (DMEK):</span>
                        <span class="badge bg-primary">Descemet Membran Endotelyal Nakli</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <strong>Post-CXL Bakımı:</strong> Bandaj Kontakt Lens Uygulandı, Florometolon %0.1 Damla 4x1 Başlatıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card oph-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-sun me-2 text-info"></i>Kornea Birimi Muayene & CXL/Topografi Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('ophthalmology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="cornea">
            <input type="hidden" name="redirect_route" value="ophthalmology.cornea">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kornea Teşhisi & Pentacam Kmax</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-info text-dark" value="Progresif Keratokonus - Kmax: 54.8 D (Epi-Off CXL Çapraz Bağlama)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kornea / Refraktif Prosedür</label>
                    <select name="sub_specialty_data[cornea_procedure]" class="form-select">
                        <option value="Epi-Off Corneal Cross-Linking (CXL)">Corneal Cross-Linking (CXL)</option>
                        <option value="Femto-LASIK Refraktif Lazer Cerrahisi">Femto-LASIK Refraktif Lazer</option>
                        <option value="Penetran Keratoplasti (PKP Kornea Nakli)">Penetran Keratoplasti (PKP)</option>
                        <option value="DMEK Descemet Membran Endotel Nakli">DMEK Endotelyal Nakil</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Topografi & Kalınlık Ölçümü</label>
                    <input type="text" name="sub_specialty_data[pentacam_detail]" class="form-control" value="En İnce Nokta: 440 µm, BAD-D: 4.85">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Kornea Uzmanı Muayene Notları & Topografi</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Pentacam keratokonus evresi, kornea endotel hücre yoğunluğu (konfokal mikroskopi), CXL sonrası epitelize olma süresi ve greft reddi riski takibi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Kornea Uzmanı: Prof. Dr. Halil İbrahim Altın</span>
                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #0891b2;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Kornea Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
