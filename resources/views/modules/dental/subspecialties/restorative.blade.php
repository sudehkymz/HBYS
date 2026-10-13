@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-sparkles text-primary me-2"></i>Restoratif Diş Tedavisi
@endsection

@section('page_description')
    Estetik kompozit dolgu, porselen lamina veneer, inlay/onlay/overlay restorasyonlar.
@endsection

@section('dental_workspace')
<div class="row g-4 mb-4">
    <!-- Aesthetic Composite Resin & Shade Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>Estetik Kompozit Tabakalandırma (Layering)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Dentin Kompozit Rengi:</span>
                        <span class="badge bg-primary">A2 Dentin Reçine</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Mine Kompozit Rengi:</span>
                        <span class="badge bg-info text-dark">A1 Enamel + Şeffaf İnsizal Translucent</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Kavite Sınıfı (Black):</span>
                        <span class="badge bg-warning text-dark">Sınıf IV (Ön Diş Kırığı Restorasyonu)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small">
                    <i class="fa-solid fa-check-circle me-1"></i>Rubber Dam (Ağız İzolasyon Lastiği) takılarak nem kontrolü sağlandı.
                </div>
            </div>
        </div>
    </div>

    <!-- Porcelain Laminate & Inlay Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-tooth me-2"></i>Lamina Porselen Veneer & Inlay/Onlay</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Estetik Restorasyon Tipi:</span>
                        <span class="badge bg-success">Yaprak Porselen (Lamina Veneer)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Restorasyon Dişleri:</span>
                        <span class="fw-bold text-dark">Diş #11, #12, #21, #22 (Ön 4 Diş)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Asitleme & Adhezif:</span>
                        <span class="badge bg-secondary">%37 Fosforik Asit + 8. Kuşak Universal Bonding</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i>Gülüş tasarımı (Digital Smile Design - DSD) simülasyonu onaylandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-sparkles me-2 text-primary"></i>Restoratif Diş Tedavisi Klinik Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_restorative">
            <input type="hidden" name="redirect_route" value="dental.restorative">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Restorasyon Tipi & Materyal</label>
                    <select name="sub_specialty_data[restorative_material]" class="form-select">
                        <option value="Estetik Kompozit Dolgu">Estetik Kompozit Dolgu (Sınıf I-V)</option>
                        <option value="Porselen Lamina Veneer">Porselen Lamina Veneer (Yaprak Porselen)</option>
                        <option value="Kompozit Inlay/Onlay">Kompozit / Porselen Inlay-Onlay</option>
                        <option value="Diastema Kapatma">Diastema Kapatma (Aralık Ayrıklığı)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tabakalandırma Renk Seçimi</label>
                    <input type="text" name="sub_specialty_data[layering_shade]" class="form-control" value="Dentin A2 + Mine A1 + Clear Translucent">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Rubber Dam & Matris Sistemi</label>
                    <input type="text" name="sub_specialty_data[isolation_matrix]" class="form-control" value="Rubber Dam İzolasyonu + Kesitsel Matris Halkan">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Restoratif Muayene & Polisaj Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Aesthetic gülüş tasarımı, kavite adhezif protokolü, polisaj diskleri ile parlatma ve oklüzal yükseklik kontrolü..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Restoratif Hekim: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Restoratif Muayeneyi Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
