@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-stomach text-primary me-2"></i>Gastroenteroloji
@endsection

@section('page_description')
    Üst GİS Endoskopi, Kolonoskopi evrelemesi (Los Angeles & Marsh), karaciğer enzim paneli.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- Endoscopy & Colonoscopy Findings Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-microscope me-2"></i>Üst GİS Endoskopi & Biyopsi Bulguları</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Reflü Özofajit Evresi:</span>
                        <span class="badge bg-warning text-dark">Los Angeles Evre B (Mukozal Erozyonlar)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Helicobacter pylori (H.pylori):</span>
                        <span class="badge bg-danger">CLO Testi Pozitif (++)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Mide Antrum Biyopsi:</span>
                        <span class="small text-muted">Kronik Aktif Gastrit & İntestinal Metaplazy</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-check-circle me-1"></i><strong>H.pylori Eradikasyon Tedavisi:</strong> 14 Günlük Üçlü/Dörtlü Eradikasyon Reçete Edildi.
                </div>
            </div>
        </div>
    </div>

    <!-- Liver Enzymes & Colonoscopy Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-vial me-2"></i>Karaciğer Enzim Paneli & Kolonoskopi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">ALT / AST Düzeyi:</span>
                        <span class="fw-bold text-danger">ALT: 48 U/L, AST: 42 U/L (Hafif Yükseklik)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">GGT / Alkalen Fosfataz:</span>
                        <span class="fw-bold text-dark">GGT: 38 U/L, ALP: 85 U/L (Normal)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Kolonoskopi / Polipektomi:</span>
                        <span class="badge bg-success">Sigmoidoskopide 6mm Saplı Polip Çıkarıldı</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                    <strong>Patoloji Takibi:</strong> Çıkarılan polip histopatoloji incelemesine gönderildi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-stomach me-2 text-primary"></i>Gastroenteroloji Muayene & Endoskopi Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="gastroenterology">
            <input type="hidden" name="redirect_route" value="internal_medicine.gastroenterology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Endoskopi Evresi / Teşhis</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="Los Angeles Evre B Reflü + H.pylori Gastrit">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Endoskopik İşlem Tipi</label>
                    <select name="sub_specialty_data[procedure]" class="form-select">
                        <option value="Üst GİS Endoskopi (ÖDG)">Üst GİS Endoskopi (ÖDG)</option>
                        <option value="Tüm Kolonoskopi & Polipektomi">Tüm Kolonoskopi & Polipektomi</option>
                        <option value="ERCP (Safra Yolu Taş/Stent)">ERCP (Safra Yolu Taş/Stent)</option>
                        <option value="Karaciğer Biyopsisi">Karaciğer Biyopsisi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">H.pylori Eradikasyon Reçetesi</label>
                    <input type="text" name="sub_specialty_data[eradication_med]" class="form-control" value="PPI + Klaritromisin + Amoksisilin (14 Gün)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Gastroenterolog Muayene & Endoskopi Rapor Metni</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Özofagus, mide antrum/korpus mukozası, duodenum bulbus gözlemi, polipektomi detayları ve beslenme önerileri..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Gastroenterolog: Prof. Dr. Caner Öztürk</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Gastro Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
