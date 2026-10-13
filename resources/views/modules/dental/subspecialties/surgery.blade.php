@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-user-ninja text-primary me-2"></i>Ağız, Diş ve Çene Cerrahisi
@endsection

@section('page_description')
    Gömülü 20'lik diş çekimi, dental implant planlaması, kist rezeksiyonu ve sinus lift operasyonları.
@endsection

@section('dental_workspace')
<div class="row g-4 mb-4">
    <!-- Implant Planning & Bone Quality Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-screw me-2"></i>Dental İmplant Planlayıcı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">İmplant Bölgesi Diş #</label>
                        <input type="text" class="form-control form-control-sm" value="Diş #36 (Sol Alt 1. Molar)">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Kemik Yoğunluğu (Misch)</label>
                        <select class="form-select form-select-sm">
                            <option value="D1">D1 (Kortikal Sert Kemik)</option>
                            <option value="D2" selected>D2 (Göznekli Kortikal)</option>
                            <option value="D3">D3 (İnce Kortikal)</option>
                            <option value="D4">D4 (Yumuşak Trabeküler)</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">İmplant Çapı (mm)</label>
                        <input type="text" class="form-control form-control-sm" value="Ø 4.3 mm">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">İmplant Boyu (mm)</label>
                        <input type="text" class="form-control form-control-sm" value="11.5 mm">
                    </div>
                </div>
                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small fw-bold text-primary">
                    <i class="fa-solid fa-check-circle me-1"></i>Primer Stabilizasyon: 35 Ncm Tork Başarıldı.
                </div>
            </div>
        </div>
    </div>

    <!-- Impacted Tooth Extraction Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-scissors me-2"></i>Gömülü 20'lik Diş Çekim Notları</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Winter Pozisyon Sınıflaması:</span>
                        <span class="badge bg-danger">Mesioangular Gömülü</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Pell & Gregory Derinlik:</span>
                        <span class="badge bg-warning text-dark">Sınıf II / Pozisyon B</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Nervus Alveolaris Inferior:</span>
                        <span class="small text-muted">Sinirle Temas Yok (Güvenli)</span>
                    </div>
                </div>
                <div class="p-2 bg-warning-subtle rounded border border-warning small">
                    <strong>Osteotomi & Flep:</strong> Muko-periostal flep kaldırıldı, kemik rezeksiyonu ve kron separe edilerek çıkartıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-user-ninja me-2 text-primary"></i>Çene Cerrahisi Cerrahi Operasyon Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_surgery">
            <input type="hidden" name="redirect_route" value="dental.surgery">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Operasyon Tipi</label>
                    <select name="sub_specialty_data[operation_type]" class="form-select">
                        <option value="Gömülü Diş Çekimi">Gömülü 20'lik Diş Çekimi</option>
                        <option value="Dental İmplant Operasyonu">Dental İmplant Operasyonu</option>
                        <option value="Kist Rezeksiyonu & Enükleasyon">Kist Rezeksiyonu & Enükleasyon</option>
                        <option value="Sinus Lift & Greft">Sinus Lift & Sinüs Grefti</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Dikiş / Sutur Tipi & Adedi</label>
                    <input type="text" name="sub_specialty_data[suture_info]" class="form-control" value="3/0 İpek Sutur (4 Dikiş Atıldı)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Post-Op Reçete (Antibiyotik/Analjezik)</label>
                    <input type="text" name="sub_specialty_data[post_op_drugs]" class="form-control" value="Amoksisilin+Klavulanik Asit 1000mg + Arveles 25mg">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Cerrahi Operasyon Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Lokal anestezi (Artikain %4), flep insizyonu, kemik retansiyonu, kanama kontrolü ve post-op bakım talimatları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Çene Cerrahı: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Cerrahi Operasyonu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
