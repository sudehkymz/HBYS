@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-radiation text-success me-2"></i>Nükleer Tıp (PET-CT & Radyoaktif Atom Tedavisi)
@endsection

@section('page_description')
    FDG PET-CT SUVmax skorlama, tiroit sintigrafisi, I-131 Radyoaktif İyot (Atom) tedavisi dozajı.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- PET-CT SUVmax & Lesion Scan Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-bolt me-2"></i>18F-FDG PET-CT SUVmax Bulguları</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Primer Lezyon SUVmax:</span>
                        <span class="badge bg-danger">SUVmax: 12.8 (Yüksek Metabolik Aktivite)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Lenf Nodları (N-Evresi):</span>
                        <span class="badge bg-warning text-dark">Mediastinal LN SUVmax: 6.4</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Uzak Metastaz (M-Evresi):</span>
                        <span class="small text-muted">FDG Tutulumu Saptanmadı (M0)</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-circle-check me-1"></i>Metabolik yanıt değerlendirmesinde Deauville Skoru: 2 (Tam Yanıt).
                </div>
            </div>
        </div>
    </div>

    <!-- Thyroid Scintigraphy & Radioiodine Therapy Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-atom me-2"></i>I-131 Radyoaktif İyot (Atom) Tedavisi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Planlanan Atom Dozu:</span>
                        <span class="badge bg-danger">100 mCi I-131 Kapsül</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Tiroit Sintigrafisi (Tc-99m):</span>
                        <span class="fw-bold text-dark">Hiperaktif Sıcak Nodül (Toxic Adenoma)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Yataklı Radyasyon İzolasyon:</span>
                        <span class="badge bg-warning text-dark">2 Gün Özel Kurşunlu Oda</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Radyasyon Güvenliği:</strong> Taburculuk sonrası 1 hafta ev içi mesafe kuralları tebliğ edildi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-radiation me-2 text-success"></i>Nükleer Tıp Görüntüleme & Tedavi Rapor Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="nuclear_medicine">
            <input type="hidden" name="redirect_route" value="specialized.nuclear_medicine">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">PET-CT SUVmax Skoru</label>
                    <input type="text" name="status_score" class="form-control fw-bold border-success text-success" value="SUVmax: 12.8 (Mediastinal LN: 6.4)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Nükleer Tıp İşlem Tipi</label>
                    <select name="sub_specialty_data[procedure_type]" class="form-select">
                        <option value="18F-FDG Tüm Vücut PET-CT">18F-FDG Tüm Vücut PET-CT</option>
                        <option value="Tc-99m Tiroit Sintigrafisi">Tc-99m Tiroit Sintigrafisi</option>
                        <option value="I-131 Atom Tedavisi (RIT)">I-131 Atom Tedavisi (RIT)</option>
                        <option value="Miyokard Perfüzyon Sintigrafisi (MPS)">Miyokard Perfüzyon Sintigrafisi (MPS)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Atom Dozu (mCi)</label>
                    <input type="text" name="sub_specialty_data[atom_dose]" class="form-control" value="100 mCi I-131 Oral Kapsül">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nükleer Tıp Uzmanı Rapor Notları</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="FDG tutulum odakları, SUVmax değerleri, sintigrafi perfüzyon skoru ve radyoaktif iyot tedavi detayları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Nükleer Tıp Uzmanı: Prof. Dr. Kemal Demirel</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Nükleer Tıp Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
