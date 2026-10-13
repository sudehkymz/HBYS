@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-allergies text-indigo me-2"></i>Çocuk İmmünolojisi ve Alerji Hastalıkları
@endsection

@section('page_description')
    Görsel Deri Prick Testi Alerjen Haritası, Spesifik IgE Değer Takip Şablonu, Besin Alerjisi Yükleme Testi.
@endsection

@section('subspecialty_workspace')
<div class="row g-4 mb-4">
    <!-- Skin Prick Test Interactive Map Card -->
    <div class="col-md-7">
        <div class="card ped-card h-100 border-start border-4 border-indigo">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-indigo mb-0"><i class="fa-solid fa-vial-circle-check me-2"></i>İnteraktif Deri Prick Testi Alerjen Haritası</h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold">Ev Tozu Akarı (D. pteronyssinus):</span>
                                <span class="badge bg-danger">7 mm (Şiddetli Pozitif)</span>
                            </div>
                            <input type="range" class="form-range" min="0" max="15" value="7">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold">İnek Sütü Proteini:</span>
                                <span class="badge bg-warning text-dark">5 mm (Pozitif)</span>
                            </div>
                            <input type="range" class="form-range" min="0" max="15" value="5">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold">Yumurta Akı (Ovalbumin):</span>
                                <span class="badge bg-danger">8 mm (Şiddetli Pozitif)</span>
                            </div>
                            <input type="range" class="form-range" min="0" max="15" value="8">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold">Zeytin / Çayır Poleni:</span>
                                <span class="badge bg-success">0 mm (Negatif)</span>
                            </div>
                            <input type="range" class="form-range" min="0" max="15" value="0">
                        </div>
                    </div>
                </div>

                <div class="p-2 bg-indigo-subtle rounded border border-indigo-subtle small text-indigo fw-bold">
                    <i class="fa-solid fa-circle-check me-1"></i>Pozitif Kontrol (Histamin): 6 mm | Negatif Kontrol (Serum Fizyolojik): 0 mm
                </div>
            </div>
        </div>
    </div>

    <!-- IgE Level & Anaphylaxis Epipen Plan Card -->
    <div class="col-md-5">
        <div class="card ped-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-syringe me-2"></i>IgE Düzeyi & Anafilaksi Eylem Planı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-3 p-3 bg-light rounded border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Total IgE:</span>
                        <span class="fw-bold text-danger">340 IU/mL (Yüksek >100)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Spesifik f2 (Süt IgE):</span>
                        <span class="badge bg-warning text-dark">Class 3 (Sınıf 3)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Spesifik f1 (Yumurta IgE):</span>
                        <span class="badge bg-danger">Class 4 (Sınıf 4)</span>
                    </div>
                </div>

                <div class="p-3 bg-danger-subtle rounded border border-danger">
                    <div class="fw-bold text-danger mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i>Anafilaksi Riski:</div>
                    <div class="small text-dark mb-2">Hastaya <strong>Adrenalin Oto-Enjektör (Epipen Jr. 0.15mg)</strong> Reçetesi Düzenlendi.</div>
                    <button type="button" class="btn btn-danger btn-sm w-100 fw-bold"><i class="fa-solid fa-file-pdf me-1"></i>Anafilaksi Eylem Planı Çıktısı Al</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-allergies me-2 text-indigo"></i>Alerji & İmmünoloji Klinik Muayene Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_allergy_immunology">
            <input type="hidden" name="redirect_route" value="pediatrics.allergy_immunology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Spesifik IgE & Total IgE Düzeyi (IU/mL)</label>
                    <input type="text" name="sub_specialty_data[total_ige]" class="form-control" value="Total IgE: 340 IU/mL, f2 (Süt IgE): Class 3, f1 (Yumurta): Class 4">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Besin Alerjisi Provokasyon / Yükleme Testi</label>
                    <select name="sub_specialty_data[food_challenge]" class="form-select">
                        <option value="Yükleme Yapılmadı">Yükleme Yapılmadı (Strict Diyet Devam Ediyor)</option>
                        <option value="Açık Yükleme Tolere Edildi">Açık Yükleme Tolere Edildi (Tolerans Gelişmiş)</option>
                        <option value="Yüklemede Reaksiyon Gelişti">Yükleme Testinde Reaksiyon Gelişti (Pozitif)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">İmmünoloji & Alerji Muayene Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Ürtiker/Atopik dermatit lejyonları, anafilaksi riski, eliminasyon diyeti ve Adrenalin Oto-Enjektör (Epipen) reçetesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Uzm. Dr. Canan Yılmaz</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Alerji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
