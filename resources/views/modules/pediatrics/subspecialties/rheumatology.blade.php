@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-bone text-indigo me-2"></i>Çocuk Romatolojisi
@endsection

@section('page_description')
    İnteraktif Görsel Eklem Haritası, FMF (Ailevi Akdeniz Ateşi) & JIA (Jüvenil İdiyopatik Artrit) Takip Skalası.
@endsection

@section('subspecialty_workspace')
<div class="row g-4 mb-4">
    <!-- Joint Examination Map Card -->
    <div class="col-md-7">
        <div class="card ped-card h-100 border-start border-4 border-indigo">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-indigo mb-0"><i class="fa-solid fa-hand me-2"></i>İnteraktif Görsel Eklem Haritası (Aktif Artrit / Ağrı Seçici)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="small fw-bold text-dark mb-2">Muayenede Hassas/Şiş Eklem İşaretleri:</div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-danger active"><i class="fa-solid fa-circle-dot me-1"></i>Sağ Diz (Şiş + Sıcak)</button>
                        <button type="button" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-circle me-1"></i>Sol Diz</button>
                        <button type="button" class="btn btn-sm btn-warning text-dark active"><i class="fa-solid fa-circle-dot me-1"></i>Sağ El Bileği (Hassas)</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-circle me-1"></i>Sol El Bileği</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-circle me-1"></i>Sağ Ayak Bileği</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-circle me-1"></i>Sol Ayak Bileği</button>
                    </div>
                </div>

                <div class="p-2 bg-indigo-subtle rounded border border-indigo-subtle small">
                    <strong>Sabah Sertliği Süresi:</strong> 45 Dakika | <strong>JADAS-27 Aktivite Puanı:</strong> 12.5 (Orta-Yüksek Aktivite)
                </div>
            </div>
        </div>
    </div>

    <!-- MEFV Gene & FMF Card -->
    <div class="col-md-5">
        <div class="card ped-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-dna me-2"></i>FMF Mutasyon & Kolşisin Düzeyi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="fw-bold text-dark mb-1">MEFV Gen Analizi:</div>
                    <span class="badge bg-danger">M694V Homozigot Mutasyon</span>
                    <div class="small text-muted mt-1">Şiddetli FMF Klinik Seyri & Amiloidoz Riski</div>
                </div>

                <div class="p-3 bg-light rounded border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Sedimantasyon (ESR):</span>
                        <span class="fw-bold text-danger">48 mm/saat</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Serum CRP:</span>
                        <span class="fw-bold text-danger">32 mg/L</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-bone me-2 text-indigo"></i>Romatoloji Klinik Muayene Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_rheumatology">
            <input type="hidden" name="redirect_route" value="pediatrics.rheumatology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">FMF Gen Mutasyonu (MEFV Geni)</label>
                    <input type="text" name="sub_specialty_data[mefv_mutation]" class="form-control" value="M694V Homozigot Mutasyon">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Sedimantasyon (ESR) / CRP Düzeyi</label>
                    <input type="text" name="sub_specialty_data[esr_crp]" class="form-control" value="ESR: 48 mm/saat, CRP: 32 mg/L">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Romatolojik Muayene & Kolşisin Reçete Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Sabah sertliği süresi, döküntü varlığı, FMF atak sıklığı ve Kolşisin/Biyolojik ajan tedavisi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Prof. Dr. Harun Tekin</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Romatoloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
