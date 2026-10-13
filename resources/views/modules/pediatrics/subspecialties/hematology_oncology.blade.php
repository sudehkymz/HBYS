@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-droplet text-danger me-2"></i>Çocuk Hematolojisi ve Onkolojisi
@endsection

@section('page_description')
    Kemoterapi protokol kür takvimi, Mutlak Nötrofil Sayısı (ANS) hesabı, Kan ve Kan Ürünü istemi.
@endsection

@section('subspecialty_workspace')
<div class="row g-4 mb-4">
    <!-- ANS Dosing Calculator & Febrile Neutropenia Risk Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-calculator me-2"></i>Mutlak Nötrofil Sayısı (ANS / ANC) Formülü</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="fw-bold text-dark mb-1">ANS Formülü:</div>
                    <code class="text-danger fs-6 fw-bold">ANS = Lökosit (WBC) × (%Nötrofil + %Çomak) / 100</code>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <label class="form-label small fw-bold">Lökosit (WBC)</label>
                        <input type="number" class="form-control form-control-sm" value="3200">
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-bold">% Nötrofil</label>
                        <input type="number" class="form-control form-control-sm" value="25">
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-bold">% Çomak</label>
                        <input type="number" class="form-control form-control-sm" value="5">
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning d-flex justify-content-between align-items-center">
                    <span class="small fw-bold">Hesaplanan ANS:</span>
                    <span class="badge bg-danger fs-6">960 /mm³ (Orta Derece Nötropeni)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chemotherapy Cycle Tracker Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-dark">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-vials me-2"></i>Kemoterapi Protokol Takvimi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-2 bg-light rounded border mb-3 small">
                    <strong>Aktif Protokol:</strong> BFM-ALL 2000 İndüksiyon Protokolü (Grup III)
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle small mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kür / Gün</th>
                                <th>Ajan</th>
                                <th>Doz (BSA)</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Grup 1 (1. Gün)</td>
                                <td>Vinkristin</td>
                                <td>1.5 mg/m²</td>
                                <td><span class="badge bg-success">Tamamlandı</span></td>
                            </tr>
                            <tr>
                                <td>Grup 1 (8. Gün)</td>
                                <td>Daunorubisin</td>
                                <td>30 mg/m²</td>
                                <td><span class="badge bg-primary">Bugün Uygulandı</span></td>
                            </tr>
                            <tr>
                                <td>Grup 1 (15. Gün)</td>
                                <td>L-Asparaginaz</td>
                                <td>5000 U/m²</td>
                                <td><span class="badge bg-secondary">Planlandı</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-droplet me-2 text-danger"></i>Hematoloji & Onkoloji Protokol Yönetimi Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_hematology_oncology">
            <input type="hidden" name="redirect_route" value="pediatrics.hematology_oncology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-danger">Mutlak Nötrofil Sayısı (ANS) Otomatik Formülü</label>
                    <input type="text" class="form-control fw-bold text-danger bg-white" value="ANS = Lökosit (WBC) x (%Nötrofil + %Çomak) / 100" readonly>
                    <div class="form-text">Hesaplanan ANS: 960 /mm3 (Orta Derece Nötropeni Risk Grubu)</div>
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">Kemoterapi Protokol / Kür</label>
                    <input type="text" name="sub_specialty_data[chemo_protocol]" class="form-control" value="BFM-ALL 2000 Kür 2">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">Kan Ürünü İstem (EKT/Trombosit)</label>
                    <select name="sub_specialty_data[blood_product]" class="form-select">
                        <option value="Eritrosit Süspansiyonu (EKT)">Eritrosit Süspansiyonu (EKT)</option>
                        <option value="Trombosit Süspansiyonu">Trombosit Süspansiyonu</option>
                        <option value="Taze Donmuş Plazma (TDP)">Taze Donmuş Plazma (TDP)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Hematolojik Bulgular & Kemoterapi Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Hemogram bulguları (Hb, Lökosit, Trombosit), kemoterapi toksisite derecelendirmesi ve kanama/ateş takibi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Prof. Dr. Harun Tekin</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Hematoloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
