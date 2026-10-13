@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-kidney text-indigo me-2"></i>Çocuk Nefrolojisi
@endsection

@section('page_description')
    Schwartz Formülü eGFR Hesaplayıcı, 24 Saatlik İdrar Protein/Kreatinin Oranı, Pediatrik Tansiyon Persentili.
@endsection

@section('subspecialty_workspace')
<div class="row g-4 mb-4">
    <!-- Schwartz eGFR Calculator Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-indigo">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-indigo mb-0"><i class="fa-solid fa-calculator me-2"></i>Schwartz eGFR Formülü (Böbrek Süzme Hızı)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="fw-bold text-dark mb-1">Schwartz Denklemi:</div>
                    <code class="text-indigo fs-6 fw-bold">eGFR = (k × Boy cm) / Serum Kreatinin</code>
                    <div class="small text-muted mt-1">k sabiti: 0.413 (Çocuklar & Ergenler)</div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Hasta Boyu (cm)</label>
                        <input type="number" class="form-control form-control-sm" value="102">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Serum Kreatinin (mg/dL)</label>
                        <input type="number" step="0.01" class="form-control form-control-sm" value="0.43">
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success d-flex justify-content-between align-items-center">
                    <span class="small fw-bold">Hesaplanan eGFR:</span>
                    <span class="badge bg-success fs-6">97.9 mL/dk/1.73m² (Normal GFR)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Blood Pressure Percentile & Proteinuria Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-droplet me-2"></i>24h İdrar Protein/Cr & Tansiyon Persentili</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Spot İdrar Protein/Kreatinin Oranı:</span>
                        <span class="fw-bold text-success">0.14 mg/mg (Fizyolojik <0.20)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 35%"></div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small fw-bold">Tansiyon Ölçümü (95/60 mmHg):</span>
                        <span class="badge bg-success">50-75. Persentil (Normotansif)</span>
                    </div>
                    <div class="small text-muted">Yaş, Cinsiyet ve Boy Persentiline Göre Uyarlanmış Tansiyon Tablosu.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-kidney me-2 text-indigo"></i>Çocuk Nefrolojisi & Schwartz eGFR Ekranı
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_nephrology">
            <input type="hidden" name="redirect_route" value="pediatrics.nephrology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-indigo">Schwartz eGFR Formülü</label>
                    <input type="text" class="form-control fw-bold text-indigo bg-white" value="eGFR = k x Boy (cm) / Kreatinin" readonly>
                    <div class="form-text">Hesaplanan eGFR: 97.9 mL/dk/1.73m2 (Normal GFR)</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">24 Saatlik İdrar Protein/Kreatinin</label>
                    <input type="number" step="0.01" name="sub_specialty_data[spot_protein_cr]" class="form-control" value="0.14">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pediatrik Tansiyon Persentili</label>
                    <select name="sub_specialty_data[bp_percentile]" class="form-select">
                        <option value="Normotansif (<90. Persentil)">Normotansif (<90. Persentil)</option>
                        <option value="Prehipertansif (90-95. Persentil)">Prehipertansif (90-95. Persentil)</option>
                        <option value="Evre 1 Hipertansiyon (>95. Persentil)">Evre 1 Hipertansiyon (>95. Persentil)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nefrolojik Muayene & Ödem/İdrar Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Pretibial ödem, idrar analizi (Proteinüri/Hematüri), böbrek ultrasonografisi ve diyaliz/antitipertansif tedavisi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Uzm. Dr. Mehmet Öz</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Nefroloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
