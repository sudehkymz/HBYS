@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-stethoscope text-primary me-2"></i>İç Hastalıkları (Dahiliye Ana Branş)
@endsection

@section('page_description')
    Erişkin ameliyatsız dahili tanı, hipertansiyon, diyabet, sistemik muayene ve medikal tedavi.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- General Internal Vitals Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-heart-pulse me-2"></i>Sistemik Vital & Metaboli̇k Takip</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kan Basıncı (Tansiyon):</span>
                        <span class="badge bg-danger">145 / 90 mmHg (Hipertansif)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Açlık Kan Şekeri (AKŞ):</span>
                        <span class="badge bg-warning text-dark">186 mg/dL (Hiperglisemi)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">HbA1c (3 Aylık Şeker):</span>
                        <span class="fw-bold text-danger">%8.4 (Diyabet Kontrolsüz)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-calculator me-1"></i><strong>VKİ (Vücut Kitle İndeksi):</strong> 29.4 kg/m² (Hafif Obez Seviye).
                </div>
            </div>
        </div>
    </div>

    <!-- Treatment & Medication Plan Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-pills me-2"></i>Dahiliye Medikal Tedavi Protokolü</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Diyabet İlacı:</span>
                        <span class="fw-bold text-dark">Metformin 1000mg 2x1 + SGLT2i</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Antihipertansif:</span>
                        <span class="fw-bold text-dark">ARB + HCTZ Kombinasyon 1x1</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Lipid Düzeyi (LDL):</span>
                        <span class="badge bg-danger">155 mg/dL (Statin Başlama Uyumlu)</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                    <i class="fa-solid fa-calendar-day me-1"></i><strong>Kontrol Randevusu:</strong> 1 Ay Sonra Açlık Kan Şekeri & Böbrek Fonksiyon Testi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-stethoscope me-2 text-primary"></i>Genel Dahiliye Muayene & Reçete Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="general">
            <input type="hidden" name="redirect_route" value="internal_medicine.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">HbA1c & Tansiyon Statüsü</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="HbA1c %8.4 - Tansiyon 145/90 mmHg (Tip 2 DM + HT)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Dahiliye Klinik Değerlendirme</label>
                    <select name="sub_specialty_data[clinical_status]" class="form-select">
                        <option value="Diyabet Tedavisi Regüle Edildi">Diyabet Tedavisi Regüle Edildi</option>
                        <option value="Hipertansiyon Tedavisi Düzenlendi">Hipertansiyon Tedavisi Düzenlendi</option>
                        <option value="İç Hastalıkları Tetkik İstem Verildi">İç Hastalıkları Tetkik İstem Verildi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">E-Reçete Protokol No</label>
                    <input type="text" name="sub_specialty_data[prescription_no]" class="form-control" value="REC-2026-99182">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Dahiliye Uzmanı Muayene & Anamnez Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Fizik muayene bulguları, kardiyovasküler sistem dinleme, batın palpasyonu, böbrek fonksiyonları ve reçete notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: {{ $selectedAdmission['attending_physician'] }}</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Dahiliye Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
