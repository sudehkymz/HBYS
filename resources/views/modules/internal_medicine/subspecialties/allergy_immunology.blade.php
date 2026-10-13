@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-allergies text-primary me-2"></i>İmmünoloji ve Alerji Hastalıkları
@endsection

@section('page_description')
    Erişkin Alerjen Deri Prick Testi, Total & Spesifik IgE, İmmün Yetmezlik İmmünoglobulin paneli.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- Skin Prick Test & Allergen Map Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-hand-dots me-2"></i>Alerjen Deri Prick Testi Sonuç Haritası</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Ev Tozu Akarı (D.pteronyssinus):</span>
                        <span class="badge bg-danger">8 mm Endürasyon (Pozitif +++)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Çayır Poleni Karışımı:</span>
                        <span class="badge bg-warning text-dark">5 mm Endürasyon (Pozitif ++)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Pozitif Kontrol (Histamin):</span>
                        <span class="badge bg-success">6 mm (Geçerli Test)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-syringe me-1"></i><strong>Alerjen İmmünoterapisi (Alerji Aşısı):</strong> Subkutan/Sublingual Aşı Tedavisi Önerildi.
                </div>
            </div>
        </div>
    </div>

    <!-- Total IgE & Immunoglobulin Panel Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-shield-halved me-2"></i>Serum İmmünoglobulin & Ürtiker Skoru</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Total IgE Düzeyi:</span>
                        <span class="badge bg-danger">340 IU/mL (Yüksek Atopi Düzeyi)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">İmmünoglobulin G / A / M:</span>
                        <span class="fw-bold text-dark">IgG: 1150 mg/dL, IgA: 210 mg/dL (Normal)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Ürtiker Aktivite Skoru (UAS7):</span>
                        <span class="badge bg-warning text-dark">28 / 42 Puan (Şiddetli Kaşıntı)</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                    <strong>Omalizumab (Anti-IgE) Uyum:</strong> Dirençli Ürtiker İçin Omalizumab Biyolojik Ajan Heyet Raporu Verildi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-allergies me-2 text-primary"></i>İmmünoloji & Alerji Muayene Rapor Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="allergy_immunology">
            <input type="hidden" name="redirect_route" value="internal_medicine.allergy_immunology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Prick Testi & Alerji Statüsü</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="Total IgE 340 IU/mL - Akar & Polen Pozitif">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Planlanan İmmünoterapi / Biyolojik</label>
                    <select name="sub_specialty_data[biological_treatment]" class="form-select">
                        <option value="Antihistaminik + Nazal Steroid">Antihistaminik + Nazal Steroid</option>
                        <option value="Spesifik Alerjen İmmünoterapisi (Alerji Aşısı)">Spesifik Alerjen İmmünoterapisi (Aşı)</option>
                        <option value="Omalizumab (Anti-IgE Enjeksiyonu)">Omalizumab (Anti-IgE Enjeksiyonu)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Ürtiker Aktivite Skoru (UAS7)</label>
                    <input type="number" name="sub_specialty_data[uas7_score]" class="form-control" value="28">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Alerjist Muayene & Prick Testi Detay Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Alerjen duyarlılık endürasyon çapları, anafilaksi öyküsü, epinefrin oto-enjektör reçetesi ve immün yetmezlik kontrolü..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Alerji Uzmanı: Uzm. Dr. Merve Tunç</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Alerji Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
