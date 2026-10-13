@extends('modules.ophthalmology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-shield-virus me-2 text-danger"></i>Üvea & Uveitis Hastalıkları Birimi
@endsection

@section('page_description')
    Ön/Arka Üveit reaksiyon derecesi (SUN Cell/Haze), hipopiyon takibi, Behçet HLA-B27 taraması & Infliximab biyolojik tedavisi.
@endsection

@section('ophthalmology_workspace')
<div class="row g-4 mb-4">
    <!-- SUN Chamber Flare/Cell & Hypopyon Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-fire-flame-curved me-2"></i>Ön Kamara Hücre & Hipopiyon Derecelendirmesi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">SUN Skoru Hücre / Flare:</span>
                        <span class="badge bg-danger fs-6">SUN Cell 3+ / Flare 2+ (Şiddetli Ön Üveit)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Ön Kamara Hipopiyon Seviyesi:</span>
                        <span class="badge bg-danger">1.2 mm Steril Pürülan Çökelti (Hipopiyon)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Keratik Presipitatlar (KP):</span>
                        <span class="fw-bold text-dark">İnce Non-Granülomatöz Presipitatlar</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Sinerşi (İridokorneal):</span>
                        <span class="badge bg-warning text-dark">360° Posterior Sinerşi (Pupil Düzensiz)</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Behçet Üveiti Paneli:</strong> Sistemik İnfliksimab (Remicade) Biyolojik İnfüzyonu Başlatıldı.
                </div>
            </div>
        </div>
    </div>

    <!-- Posterior Vitritis & Biologic Therapy Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-syringe me-2"></i>Arka Segment Vitrit & Biyolojik İmimmünosüpresyon</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Vitreus Haze (Bulanıklık):</span>
                        <span class="badge bg-warning text-dark">Grade 2+ Vitrit & Retinal Vaskülit</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">HLA-B27 / Behçet Testi:</span>
                        <span class="badge bg-danger">Pathergy Testi Pozitif (Behçet Uyumlu)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Sistemik İmmünosüpresan:</span>
                        <span class="fw-bold text-dark">Metilprednizolon 1mg/kg + Azatioprin 150mg</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Topikal Sikloplejik:</strong> Siklopentolat 1% 3x1 (Sinerşi Önleme) + Deksametazon Damla Saat Başı Başlandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card oph-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-shield-virus me-2 text-danger"></i>Üvea Birimi Muayene & Biyolojik İlaç Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('ophthalmology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="uvea">
            <input type="hidden" name="redirect_route" value="ophthalmology.uvea">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Üveit Teşhisi & SUN Skoru</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="Behçet Ön ve Arka Üveit - SUN Cell 3+, 1.2mm Hipopiyon (İnfliksimab)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">İmmünosüpresan / Biyolojik İlaç</label>
                    <select name="sub_specialty_data[uvea_biologic]" class="form-select">
                        <option value="İnfliksimab (Remicade 5mg/kg IV İnfaz)">İnfliksimab 5mg/kg Biyolojik İnfizyon</option>
                        <option value="Adalimumab (Humira 40mg SC Enjeksiyon)">Adalimumab 40mg SC Enjeksiyon</option>
                        <option value="Metilprednizolon Pulse Steroid + Siklosporin">Pulse Steroid + Siklosporin A</option>
                        <option value="Deksametazon Göz Damlası Saat Başı">Deksametazon Damla (Saat Başı)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Hipopiyon & Vaskülit Bulgusu</label>
                    <input type="text" name="sub_specialty_data[hypopyon_detail]" class="form-control" value="1.2mm Hipopiyon, Grade 2+ Vitreus Haze">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Üvea Uzmanı Muayene Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Biyomikroskopik SUN hücre/flare derecesi, posterior sinerşi mevcudiyeti, fundus retinal vaskülit kılıflanması, optik disk ödemi ve biyolojik ilaç infüzyon tolerans notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Üvea Uzmanı: Doç. Dr. Meltem Yılmaz</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Üvea Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
