@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-heart-pulse text-danger me-2"></i>Çocuk Kardiyolojisi
@endsection

@section('page_description')
    Pediatri EKO Z-Score Hesaplayıcı (kapak ve damar çapları), Fetal EKO & Pediatrik EKG Şablonu.
@endsection

@section('subspecialty_workspace')
<div class="row g-4 mb-4">
    <!-- ECHO Z-Score Calculator Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-heart-circle-bolt me-2"></i>Ekokardiyografi (EKO) Z-Score Hesaplayıcı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Aort Anulus Çapı (mm)</label>
                        <input type="number" step="0.1" class="form-control form-control-sm" value="12.4">
                        <span class="badge bg-success mt-1">Z-Score: +0.2 SD (Normal)</span>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Mitral Kapak Çapı (mm)</label>
                        <input type="number" step="0.1" class="form-control form-control-sm" value="15.8">
                        <span class="badge bg-success mt-1">Z-Score: +0.4 SD (Normal)</span>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Sol Ventrikül EDD (mm)</label>
                        <input type="number" step="0.1" class="form-control form-control-sm" value="32.0">
                        <span class="badge bg-success mt-1">Z-Score: +0.8 SD</span>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Pulmoner Kapak Çapı (mm)</label>
                        <input type="number" step="0.1" class="form-control form-control-sm" value="13.1">
                        <span class="badge bg-success mt-1">Z-Score: +0.1 SD</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CHD Defect Classification & EKG Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-file-waveform me-2"></i>Pediatrik EKG & Siyanotik CHD Sınıflaması</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">EKG Kalp Hızı:</span>
                        <span class="fw-bold text-dark">112 atım/dakika (Sinüs Ritmi)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">QTc İntervali:</span>
                        <span class="fw-bold text-success">410 ms (Normal Bazal <440ms)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Ejeksiyon Fraksiyonu (EF %):</span>
                        <span class="badge bg-success">EF %68 (Normal Sistolik Fonksiyon)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small">
                    <i class="fa-solid fa-stethoscope me-1"></i><strong>Üfürüm Derecesi:</strong> 2/6 Sistolik Ejeksiyon Üfürümü (Sol 2. İnterkostal Aralık).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-heart-pulse me-2 text-danger"></i>Pediatrik Kardiyoloji Klinik Değerlendirme Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_cardiology">
            <input type="hidden" name="redirect_route" value="pediatrics.cardiology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-danger">Ekokardiyografi (EKO) Z-Score Hesabı</label>
                    <input type="text" name="sub_specialty_data[echo_zscore]" class="form-control" value="Mitral Kapak Z-Score: +0.4 SD, Aort Anulus: +0.2 SD, EF: %68">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Doğumsal Kalp Defekti (CHDs)</label>
                    <select name="sub_specialty_data[chd_defect]" class="form-select">
                        <option value="Yok (Normal Kalp Yapısı)">Yok (Normal Kalp Yapısı)</option>
                        <option value="VSD (Ventriküler Septal Defekt)">VSD (Ventriküler Septal Defekt)</option>
                        <option value="ASD (Atriyal Septal Defekt)">ASD (Atriyal Septal Defekt)</option>
                        <option value="PDA (Patent Duktus Arteriyozus)">PDA (Patent Duktus Arteriyozus)</option>
                        <option value="Fallot Tetralojisi (TOF)">Fallot Tetralojisi (TOF)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pediatrik EKG Ritim Değerlendirmesi</label>
                    <input type="text" name="sub_specialty_data[ekg_rhythm]" class="form-control" value="Sinüs Ritmi, Hız: 112 atım/dk, QTc: 410 ms">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Kardiyolojik Muayene & Üfürüm Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Üfürüm derecesi (Systolic 2/6), femoraller açık, siyanoz yok, EKO oda boyutları ve ejeksiyon fraksiyonu (EF %68)..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Prof. Dr. Deniz Yıldız</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Kardiyoloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
