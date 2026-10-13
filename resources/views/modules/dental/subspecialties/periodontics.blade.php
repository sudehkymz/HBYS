@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-gear text-primary me-2"></i>Periodontoloji (Diş Eti Hastalıkları)
@endsection

@section('page_description')
    Periodontal cep derinliği sondlaması (mm), diş eti çekilmesi, subgingival küretaj ve flep operasyonu.
@endsection

@section('dental_workspace')
<div class="row g-4 mb-4">
    <!-- Periodontal Probing Depth Matrix Card -->
    <div class="col-md-7">
        <div class="card dental-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-ruler-horizontal me-2"></i>Periodontal Sondlama Cep Derinlik Matrisi (mm)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="p-2 bg-light rounded border text-center">
                            <span class="small text-muted d-block">Sağ Üst Molar (#16):</span>
                            <strong class="text-danger">5 mm Cep (Derin Cep)</strong>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 bg-light rounded border text-center">
                            <span class="small text-muted d-block">Sol Alt Molar (#36):</span>
                            <strong class="text-danger">6 mm Cep + Furkasyon II</strong>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 bg-light rounded border text-center">
                            <span class="small text-muted d-block">Ön Kesiciler (#11,#21):</span>
                            <strong class="text-success">2 mm (Normal)</strong>
                        </div>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-primary fw-bold">
                    <i class="fa-solid fa-droplet me-1"></i>Sondlamada Kanama İndeksi (BOP): %42 (Yüksek İltihap)
                </div>
            </div>
        </div>
    </div>

    <!-- Plaque Index & Flap Operation Card -->
    <div class="col-md-5">
        <div class="card dental-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-notes-medical me-2"></i>Plak İndeksi & Cerrahi Planı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Silness-Löe Plak İndeksi:</span>
                        <span class="badge bg-danger">Skor 2.4 (Kötü)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Diş Eti Çekilmesi (Recession):</span>
                        <span class="fw-bold text-dark">Miller Sınıf II (3 mm)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Periodontal Teşhis:</span>
                        <span class="badge bg-danger">Evre III Derece B Periodontitis</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger small text-dark">
                    <strong>Planlanan Operasyon:</strong> Açık Flep Operasyonu + Subgingival Küretaj & Kök Düzeltmesi (SRP).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-gear me-2 text-primary"></i>Periodontoloji Klinik Muayene Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_periodontics">
            <input type="hidden" name="redirect_route" value="dental.periodontics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Periodontal Sondlama Cep Derinliği (mm)</label>
                    <input type="text" name="sub_specialty_data[probing_depth]" class="form-control" value="#16: 5mm, #36: 6mm (BOP + %42)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Periodontal Cerrahi / İşlem Tipi</label>
                    <select name="sub_specialty_data[periodontal_procedure]" class="form-select">
                        <option value="Subgingival Küretaj (SRP)">Subgingival Küretaj & Kök Düzeltmesi (SRP)</option>
                        <option value="Açık Flep Operasyonu">Açık Flep Operasyonu</option>
                        <option value="Serbest Diş Eti Grefti (SDG)">Serbest Diş Eti Grefti (SDG)</option>
                        <option value="Gingivektomi / Gingivoplasti">Gingivektomi / Gingivoplasti</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Gargara & Ağız Bakım Reçetesi</label>
                    <input type="text" name="sub_specialty_data[mouthwash]" class="form-control" value="Klorheksidin %0.12 Ağız Gargarası + Arayüz Fırçası">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Periodontal Muayene & Mobilite Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Diş mobilitesi (Derece I-III), furkasyon tutulumu, plak indeksi, kalsiyum birikimi ve periodontal idame randevu takvimi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Periodontolog: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Periodontoloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
