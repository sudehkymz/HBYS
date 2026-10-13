@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-bone text-primary me-2"></i>Romatoloji (Romatizmal Hastalıklar)
@endsection

@section('page_description')
    DAS28 Romatoid Artrit Hastalık Aktivite Skoru, ANA/Anti-CCP otoantikor paneli, eklem muayenesi.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- DAS28 Rheumatoid Arthritis Activity Score Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-calculator me-2"></i>DAS28 Romatoid Artrit Hastalık Aktivitesi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Hassas / Şiş Eklem Sayısı:</span>
                        <span class="fw-bold text-dark">6 Hassas Eklem / 4 Şiş Eklem</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Sedimentasyon (ESH) / CRP:</span>
                        <span class="badge bg-danger">ESH: 45 mm/s, CRP: 24 mg/L</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Hesaplanan DAS28 Skoru:</span>
                        <span class="badge bg-danger fs-6">DAS28: 4.8 (Yüksek Hastalık Aktivitesi)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-bone me-1"></i><strong>DMARD / Biyolojik Kararı:</strong> Metotreksat Doz Artırımı + Anti-TNF Biyolojik Tedavi Uyumlu.
                </div>
            </div>
        </div>
    </div>

    <!-- Autoantibody Panel & Joint Examination Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-dna me-2"></i>Otoantikor Paneli & Eklem Şeması</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Anti-CCP (Sitrüline Peptid):</span>
                        <span class="badge bg-danger">>200 U/mL (Pozitif +++)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Romatoid Faktör (RF):</span>
                        <span class="badge bg-danger">128 IU/mL (Pozitif ++)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">ANA (Antinükleer Antikor):</span>
                        <span class="badge bg-warning text-dark">1/320 Homojen İmmünfloresan</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Etkilenen Eklem Bölgeleri:</strong> Bilateral MCP, PIP ve El Bileği Eklemleri (Simetrik Tutulum).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-bone me-2 text-primary"></i>Romatoloji Muayene & Aktivite Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="rheumatology">
            <input type="hidden" name="redirect_route" value="internal_medicine.rheumatology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">DAS28 Skoru & Aktivite</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="DAS28: 4.8 (Yüksek Aktivite RA - Anti-CCP >200)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Reçete Edilen DMARD / Biyolojik</label>
                    <select name="sub_specialty_data[rheuma_med]" class="form-select">
                        <option value="Metotreksat 15mg/Hafta + Folebi">Metotreksat 15mg/Hafta + Folebi</option>
                        <option value="Leflunomid 20mg + Klorokin">Leflunomid 20mg + Klorokin</option>
                        <option value="Anti-TNF Biyolojik (Adalimumab / Etanersept)">Anti-TNF Biyolojik (Adalimumab)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Şiş / Hassas Eklem Adedi</label>
                    <input type="text" name="sub_specialty_data[joint_count]" class="form-control" value="6 Hassas / 4 Şiş Eklem (MCP/PIP)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Romatolog Muayene & Eklem USG Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Sabah tutukluğu süresi (dakika), eklem ultrasonografisinde sinovit/erozyon bulguları ve biyolojik ajan heyet kararı..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Romatolog: Prof. Dr. Hande Köse</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Romatoloji Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
