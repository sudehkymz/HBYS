@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-dna text-primary me-2"></i>Endokrinoloji ve Metabolizma Hastalıkları
@endsection

@section('page_description')
    HOMA-IR İnsülin direnci hesabı, Tiroit TIRADS USG evrelemesi, Hipofiz & Adrenal hormon aksı.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- HOMA-IR Insulin Resistance Calculator Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-calculator me-2"></i>HOMA-IR İnsülin Direnci Hesaplayıcı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="fw-bold text-dark mb-1">HOMA-IR Formülü:</div>
                    <code class="text-primary fs-6 fw-bold">HOMA-IR = (Açlık Kan Şekeri [mg/dL] × Açlık İnsülin [µU/mL]) / 405</code>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Açlık Kan Şekeri</label>
                        <input type="number" class="form-control form-control-sm" value="118">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Açlık İnsülini</label>
                        <input type="number" class="form-control form-control-sm" value="22">
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary d-flex justify-content-between align-items-center">
                    <span class="small fw-bold">Hesaplanan HOMA-IR Skoru:</span>
                    <span class="badge bg-danger fs-6">HOMA-IR: 6.4 (Yüksek İnsülin Direnci)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Thyroid TIRADS USG & Hormone Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-microscope me-2"></i>Tiroit TIRADS USG & Hormon Paneli</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">TIRADS Ultrason Evresi:</span>
                        <span class="badge bg-warning text-dark">EU-TIRADS 4 (Şüpheli Nodül 14mm)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">TSH Serbest T4 / T3:</span>
                        <span class="fw-bold text-danger">TSH: 8.2 mIU/L (Subklinik Hipotiroidi)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Anti-TPO & Anti-Tg:</span>
                        <span class="badge bg-danger">Pozitif (Hashimoto Tiroiditi)</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Biyopsi Kararı:</strong> TIRADS 4 Nodül İçin USG Eşliğinde İnce İğne Aspirasyon Biyopsisi (İİAB) Önerildi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-dna me-2 text-primary"></i>Endokrinoloji Değerlendirme Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="endocrinology">
            <input type="hidden" name="redirect_route" value="internal_medicine.endocrinology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">HOMA-IR & İnsülin Skoru</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="HOMA-IR: 6.4 (İnsülin Direnci + TSH: 8.2)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">TIRADS Nodül USG Kategorisi</label>
                    <select name="sub_specialty_data[tirads_category]" class="form-select">
                        <option value="TIRADS 2 (Benign Nodül)">TIRADS 2 (Benign Nodül)</option>
                        <option value="TIRADS 3 (Düşük Risk)">TIRADS 3 (Düşük Risk)</option>
                        <option value="TIRADS 4 (Orta Şüpheli - Biyopsi Endikasyonu)">TIRADS 4 (Orta Şüpheli - Biyopsi)</option>
                        <option value="TIRADS 5 (Yüksek Şüpheli Malignite)">TIRADS 5 (Yüksek Şüpheli)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Başlanan Hormon Reçetesi</label>
                    <input type="text" name="sub_specialty_data[hormone_med]" class="form-control" value="Levotiroksin 50 mcg 1x1 (Aç Karnına)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Endokrinolog Muayene & Biyopsi Karar Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Hipofiz-adrenal aks tetkikleri, kortizol/ACTH düzeyleri, tiroit ultrasonografisi ve insülin duyarlaştırıcı tedavi notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Endokrinolog: Doç. Dr. Zeynep Şahin</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Endokrin Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
