@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-droplet text-danger me-2"></i>Hematoloji (Kan Hastalıkları & Periferik Yayma)
@endsection

@section('page_description')
    Tam kan sayımı (CBC), periferik yayma mikroskopisi, anemi paneli ve kemik iliği değerlendirmesi.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- CBC & Peripheral Blood Smear Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-microscope me-2"></i>Periferik Yayma & Tam Kan (CBC) Bulguları</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Hemoglobin / Hematokrit:</span>
                        <span class="badge bg-danger">Hgb: 9.2 g/dL (Orta Derece Anemi)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Lökosit (WBC) / Trombosit (PLT):</span>
                        <span class="fw-bold text-dark">WBC: 7.800 /µL, PLT: 480.000 /µL (Reaktif Trombositoz)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Periferik Yayma Eritrosit:</span>
                        <span class="small text-muted">Mikrositer, Hipokrom Eritrositler, Anizositoz</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger small text-dark">
                    <i class="fa-solid fa-vial-circle-check me-1"></i><strong>Blast Var mı?:</strong> Blasta Rastlanmadı (Atipik Hücre Yok).
                </div>
            </div>
        </div>
    </div>

    <!-- Anemia & Iron Metabolism Panel Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-flask me-2"></i>Demir Metabolizması & Anemi Paneli</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Serum Ferritin Düzeyi:</span>
                        <span class="badge bg-danger">6 ng/mL (Şiddetli Depo Demir Eksikliği)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Serum Demir / SDBK:</span>
                        <span class="fw-bold text-dark">Demir: 28 µg/dL, SDBK: 410 µg/dL</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Vitamin B12 / Folat:</span>
                        <span class="badge bg-success">B12: 340 pg/mL, Folat: 8.5 ng/mL (Normal)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>İntravenöz Demir Tedavisi:</strong> İntravenöz Ferrik Karboksimaltoz (1000mg IV İnfüzyon) Planlandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-droplet me-2 text-danger"></i>Hematoloji Muayene & Periferik Yayma Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="hematology">
            <input type="hidden" name="redirect_route" value="internal_medicine.hematology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Hematolojik Teşhis / Anemi Tipi</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="Demir Eksikliği Anemisi (Hgb: 9.2, Ferritin: 6)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kemik İliği & İleri İstem</label>
                    <select name="sub_specialty_data[bone_marrow]" class="form-select">
                        <option value="İV Demir Tedavisi Yeterlidir (İliğe Gerek Yok)">İV Demir Tedavisi Yeterlidir</option>
                        <option value="Kemik İliği Aspirasyon & Biyopsi İstemi">Kemik İliği Aspirasyon & Biyopsi İstemi</option>
                        <option value="Akım Sitometri (Flow Cytometry) İstemi">Akım Sitometri (Flow Cytometry)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Planlanan Demir / Kan Ürünü</label>
                    <input type="text" name="sub_specialty_data[blood_product]" class="form-control" value="Ferrik Karboksimaltoz 1000mg IV İnfüzyon">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Hematolog Periferik Yayma & Muayene Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Eritrosit morfolojisi, lökosit parçalı/çentikli yapısı, lenfadenopati (LAP) muayenesi, splenomegali ve tedavi planı..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hematolog: Prof. Dr. Burak Güven</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Hematoloji Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
