@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-head-side-virus text-warning me-2"></i>Çocuk ve Ergen Ruh Sağlığı ve Hastalıkları (Psikiyatri)
@endsection

@section('page_description')
    🔒 Gizli Protokol (Privacy Lock) Modülü, WISC-IV Zeka Testi, MOXO Dikkat Testi, Okul Rehberlik Formu.
@endsection

@section('subspecialty_workspace')
<div class="row g-4 mb-4">
    <!-- WISC-IV IQ Test Scorecard Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-warning-subtle border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-brain me-2 text-warning"></i>WISC-IV Zeka Testi Puanlama Kartı</h6>
                <span class="badge bg-warning text-dark"><i class="fa-solid fa-lock me-1"></i>Mahrem</span>
            </div>
            <div class="card-body pt-0">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded border">
                            <span class="small text-muted d-block">Sözel Kavrama (VCI):</span>
                            <strong class="text-dark">112 Puan (%79)</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded border">
                            <span class="small text-muted d-block">Algısal Akıl Yürütme (PRI):</span>
                            <strong class="text-dark">118 Puan (%88)</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded border">
                            <span class="small text-muted d-block">Çalışma Belleği (WMI):</span>
                            <strong class="text-warning-emphasis">94 Puan (%34)</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded border">
                            <span class="small text-muted d-block">İşlem Hızı (PSI):</span>
                            <strong class="text-danger">88 Puan (%21)</strong>
                        </div>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning d-flex justify-content-between align-items-center">
                    <span class="small fw-bold text-dark">Toplam Zeka Katsayısı (FSIQ):</span>
                    <span class="badge bg-dark fs-6">106 (Normal Zeka Düzeyi)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MOXO ADHD Test Scorecard Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-dark">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-chart-line me-2"></i>MOXO Dikkat Eksikliği & Hiperaktivite Testi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-2 p-2 bg-light rounded border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Dikkat (Attention):</span>
                        <span class="badge bg-danger">-2.6 SD (Belirgin Sapma)</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 85%"></div>
                    </div>
                </div>

                <div class="mb-2 p-2 bg-light rounded border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Zamanlama (Timing):</span>
                        <span class="badge bg-warning text-dark">-1.2 SD (Hafif Sapma)</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 50%"></div>
                    </div>
                </div>

                <div class="mb-2 p-2 bg-light rounded border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Dürtüsellik (Impulsivity):</span>
                        <span class="badge bg-danger">-3.1 SD (Yüksek Risk)</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 90%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ped-card mb-4 border-start border-warning border-4">
    <div class="card-header bg-warning-subtle border-0 py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fa-solid fa-user-lock me-2 text-warning"></i>Çocuk Psikiyatrisi Mahremiyet Yönetimi (İzole Gizli Protokol)
            </h5>
            <span class="badge bg-warning text-dark"><i class="fa-solid fa-lock me-1"></i>Gizli Protokol Korumalı</span>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-warning border-warning rounded-3 small mb-4">
            <i class="fa-solid fa-shield-halved me-2"></i><strong>Mahremiyet Bildirimi:</strong> Bu sayfadaki psikiyatri muayene notları ve psikometrik test sonuçları genel pediatri ve diğer poliklinik hekimlerinden gizlenir. Sadece yetkili Çocuk Psikiyatristi görebilir.
        </div>

        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_psychiatry">
            <input type="hidden" name="redirect_route" value="pediatrics.psychiatry">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">WISC-IV / WISC-R Zeka Testi Puanı</label>
                    <input type="text" name="sub_specialty_data[wisc_score]" class="form-control" value="FSIQ: 106, Çalışma Belleği: 94, İşlem Hızı: 88">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">MOXO Dikkat Eksikliği & Hiperaktivite Testi</label>
                    <input type="text" name="sub_specialty_data[moxo_score]" class="form-control" value="Dikkat: -2.6 SD, Dürtüsellik: -3.1 SD">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Okul Bilgilendirme & Rehberlik Formu</label>
                    <button type="button" class="btn btn-dark btn-sm w-100 mt-1"><i class="fa-solid fa-file-pdf me-1"></i>Rehberlik Formu Çıktısı Al</button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-danger">🔒 Gizli Psikiyatri Muayene & Terapi Notları *</label>
                <textarea name="clinical_notes" class="form-control border-warning" rows="5" required placeholder="DEHB, okul fobisi, kaygı bozukluğu, psikoterapi seans notları ve Metilfenidat (Ritalin/Concerta) reçetesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-lock me-1"></i>Yetkili Psikiyatrist: Uzm. Dr. Canan Yılmaz</span>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-lock me-2"></i>Gizli Psikiyatri Notunu Şifreli Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
