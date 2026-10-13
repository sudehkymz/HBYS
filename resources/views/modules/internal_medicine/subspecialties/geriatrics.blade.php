@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-person-cane text-primary me-2"></i>Geriatri (Yaşlı Sağlığı & Kırılganlık)
@endsection

@section('page_description')
    Kapsamlı geriatrik değerlendirme, Katz Günlük Yaşam Aktiviteleri (GYA), Mini-Mental (MMSE) test.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- Katz Index of Activities of Daily Living (ADL) Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-clipboard-check me-2"></i>Katz Günlük Yaşam Aktiviteleri (GYA) Skoru</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Katz GYA Skoru:</span>
                        <span class="badge bg-warning text-dark">5 / 6 Puan (Hafif Bağımlı)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Banyo / Giyinme:</span>
                        <span class="fw-bold text-dark">Gözetim Altında Bağımsız</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Kontinans (Sıkıntı Var mı?):</span>
                        <span class="small text-muted">Gece İnkontinansı Mevcut</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-person-falling me-1"></i><strong>Düşme Riski Değerlendirmesi:</strong> Tinetti Denge Skoru: 18/28 (Orta Düşme Riski).
                </div>
            </div>
        </div>
    </div>

    <!-- Mini-Mental State Exam & Frailty Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-brain me-2"></i>MMSE Kognitif Test & Kırılganlık (Frailty)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">MMSE Kognitif Skoru:</span>
                        <span class="badge bg-primary">24 / 30 Puan (Hafif Kognitif Bozukluk)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Fried Kırılganlık İndeksi:</span>
                        <span class="badge bg-danger">Prefrail / Frail (Kırılgan Yaşlı)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Sarkopeni Kas Kütlesi:</span>
                        <span class="small text-muted">BİA Kas Dokusu Azalmış (Sarkopeni +)</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Polifarmasi Uyarısı:</strong> Hasta 6 Farklı İlaç Kullanıyor (BEERS Kriteri İle İnceleme Yapıldı).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-person-cane me-2 text-primary"></i>Kapsamlı Geriatrik Değerlendirme Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="geriatrics">
            <input type="hidden" name="redirect_route" value="internal_medicine.geriatrics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Katz GYA & MMSE Skor Notu</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="Katz: 5/6, MMSE: 24/30 (Kırılganlık Sendromu)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Geriatrik Bakım & Destek Kararı</label>
                    <select name="sub_specialty_data[care_plan]" class="form-select">
                        <option value="Evde Bakım & Düşme Önlemleri Önerildi">Evde Bakım & Düşme Önlemleri</option>
                        <option value="Fiziksel Rehabilitasyon & Kas Güçlendirme">Fiziksel Rehabilitasyon & Kas Güçlendirme</option>
                        <option value="Nöroloji Unutkanlık Polikliniğine Sevk">Nöroloji Unutkanlık Polikliniğine Sevk</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Osteoporoz & Vitamin D Reçetesi</label>
                    <input type="text" name="sub_specialty_data[osteo_med]" class="form-control" value="D3 Vit 50.000 IU + Kalsiyum + Alendronat">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Geriatri Uzmanı Kapsamlı Muayene Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Beslenme (MNA Skoru), kırılganlık parametreleri, duyusal kayıplar (işitme/görme) ve polifarmasi düzenlemeleri..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Geriatr: Doç. Dr. Selin Arslan</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Geriatri Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
