@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-kidney text-primary me-2"></i>Nefroloji (Böbrek Hastalıkları & Diyaliz)
@endsection

@section('page_description')
    CKD-EPI eGFR böbrek süzme hızı, 24 saatlik proteinüri, hemodiyaliz & hipertansiyon takibi.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- CKD-EPI eGFR Calculator & Staging Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-calculator me-2"></i>CKD-EPI eGFR Süzme Hızı Hesaplayıcı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Serum Kreatinin Düzeyi:</span>
                        <span class="badge bg-danger">1.8 mg/dL (Yüksek)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Hesaplanan CKD-EPI eGFR:</span>
                        <span class="badge bg-warning text-dark">42 mL/dk/1.73m² (Evre 3B KBY)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Serum Üre / BUN:</span>
                        <span class="fw-bold text-dark">Üre: 68 mg/dL, BUN: 31.7 mg/dL</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-heart-pulse me-1"></i><strong>Böbrek Evresi:</strong> Evre 3B Orta-İleri Derece Kronik Böbrek Yetmezliği (KBY).
                </div>
            </div>
        </div>
    </div>

    <!-- 24-Hour Urine Proteinuria & Dialysis Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-vial me-2"></i>24 Saatlik İdrar Proteinüri & Elektrolit</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">24 Saatlik Proteinüri:</span>
                        <span class="badge bg-danger">850 mg/24h (Aşikar Nefrotik Proteinüri)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Serum Potasyum (K+):</span>
                        <span class="fw-bold text-danger">K+: 5.4 mEq/L (Hafif Hiperkalemi)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Diyaliz Gereksinimi:</span>
                        <span class="badge bg-success">Konservatif Medikal Tedavi (Diyalizsiz)</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Nefrokoruma Tedavisi:</strong> RAS Blokajı (ACEi/ARB) + SGLT2 İnhibitörü Nefroproteksiyon Başlandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-kidney me-2 text-primary"></i>Nefroloji Muayene & Takip Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="nephrology">
            <input type="hidden" name="redirect_route" value="internal_medicine.nephrology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">CKD-EPI eGFR & Evre Notu</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="Evre 3B KBY (eGFR: 42 mL/dk, Kreatinin: 1.8)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Nefrolojik Tedavi Protokolü</label>
                    <select name="sub_specialty_data[nephro_protocol]" class="form-select">
                        <option value="Konservatif Medikal (ACEi/ARB + SGLT2i)">Konservatif Medikal (ACEi/ARB + SGLT2i)</option>
                        <option value="AV Fistül Hazırlığı & Diyaliz Eğitimi">AV Fistül Hazırlığı & Diyaliz Eğitimi</option>
                        <option value="Hemodiyaliz / Periton Diyaliz Takibi">Hemodiyaliz / Periton Diyaliz Takibi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">24-Saatlik İdrar Protein Miktarı</label>
                    <input type="text" name="sub_specialty_data[proteinuria_val]" class="form-control" value="850 mg/24h">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nefrolog Muayene & USG / Biyopsi Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Renal ultrasonografi (böbrek boyutları/parankim kalınlığı), biyopsi endikasyonu, hiperkalemi önlemleri ve diyet kısıtlamaları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Nefrolog: Prof. Dr. Murat Tekin</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Nefroloji Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
