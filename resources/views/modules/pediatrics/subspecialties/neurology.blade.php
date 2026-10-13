@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-brain text-indigo me-2"></i>Çocuk Nörolojisi
@endsection

@section('page_description')
    Nöromotor gelişim cetveli, EEG/MR izleme, epilepsi nöbet günlüğü, antiepileptik ilaç kan düzeyi.
@endsection

@section('subspecialty_workspace')
<div class="row g-4 mb-4">
    <!-- Seizure Tracker & EEG Monitor Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-indigo">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-indigo mb-0"><i class="fa-solid fa-bolt me-2"></i>Epilepsi Nöbet Günlüğü & EEG</h6>
                <span class="badge bg-indigo-subtle text-indigo">Aktif Takip</span>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="fw-bold text-dark mb-1"><i class="fa-solid fa-wave-square text-indigo me-1"></i>Son EEG Raporu:</div>
                    <div class="small text-secondary">Bilateral Fokal Diken-Dalga Kompleksleri (Sol Sentro-Temporal Deşarj).</div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle small mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tarih/Saat</th>
                                <th>Nöbet Tipi</th>
                                <th>Süre</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Bugün 08:30</td>
                                <td>Fokal Motor Nöbet</td>
                                <td>45 sn</td>
                                <td><span class="badge bg-warning text-dark">Spontan Durdu</span></td>
                            </tr>
                            <tr>
                                <td>Dün 21:15</td>
                                <td>Absans Nöbeti</td>
                                <td>15 sn</td>
                                <td><span class="badge bg-secondary">Hafif</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Antiepileptic Drug Level & Reflex Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-vial me-2"></i>Antiepileptik İlaç Kan Düzeyleri</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-3 p-3 bg-light rounded border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small fw-bold">Valproik Asit (Depakin):</span>
                        <span class="fw-bold text-success">68 µg/mL (Terapötik: 50-100)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 68%"></div>
                    </div>
                </div>

                <div class="mb-3 p-3 bg-light rounded border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small fw-bold">Levetirasetam (Keppra):</span>
                        <span class="fw-bold text-primary">24 µg/mL (Terapötik: 12-46)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%"></div>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small">
                    <i class="fa-solid fa-circle-info text-primary me-1"></i><strong>Refleks Muayenesi:</strong> DTR +2/4 Normoaktif. Babinski Bilateral Negatif.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-brain me-2 text-indigo"></i>Çocuk Nörolojisi Klinik Değerlendirme Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_neurology">
            <input type="hidden" name="redirect_route" value="pediatrics.neurology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Epilepsi Nöbet Tipi & Sıklığı</label>
                    <input type="text" name="sub_specialty_data[seizure_type]" class="form-control" value="Fokal Motor Nöbet (2 kez/ay)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">EEG Çekim Sonucu & Dalga Yapısı</label>
                    <input type="text" name="sub_specialty_data[eeg_result]" class="form-control" value="Bilateral Fokal Diken-Dalga Kompleksleri">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Antiepileptik Kan Düzeyi (Valproat/Levetirasetam)</label>
                    <input type="text" name="sub_specialty_data[drug_level]" class="form-control" value="Valproik Asit: 68 ug/mL (Terapötik)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nöromotor Gelişim & Klinik Muayene Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Kas tonusu (Hipotoni/Spastisite), derin tendon refleksleri, cranial sinir muayenesi ve nöbet günlüğü..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Uzm. Dr. Mehmet Öz</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Nöroloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
