@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-equals text-primary me-2"></i>Ortodonti (Tel & Plak Tedavisi)
@endsection

@section('page_description')
    Sabit tel tedavisi, şeffaf plak (Invisalign), Angle maloklüzyon sınıflaması ve ark teli değişimi.
@endsection

@section('dental_workspace')
<div class="row g-4 mb-4">
    <!-- Angle Classification & Bracket Type Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-teeth-open me-2"></i>Angle Sınıflaması & Braket Sistemi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Angle Maloklüzyon Sınıfı:</span>
                        <span class="badge bg-warning text-dark">Class II Division 1 (Kapanış Bozukluğu)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Overjet / Overbite:</span>
                        <span class="fw-bold text-dark">Overjet: +5.5 mm | Overbite: +4.0 mm</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Braket Tipi:</span>
                        <span class="badge bg-primary">Damon Q Self-Ligating Metal Braket</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small">
                    <i class="fa-solid fa-info-circle me-1"></i>Üst çene darlık nedeniyle <strong>RPE (Hızlı Üst Çene Genişletme)</strong> yapıldı.
                </div>
            </div>
        </div>
    </div>

    <!-- Archwire Change & Elastic Traction Card -->
    <div class="col-md-6">
        <div class="card dental-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-timeline me-2"></i>Ark Teli & Lastik Çekim Takvimi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Üst Ark Teli:</span>
                        <span class="badge bg-indigo text-white">0.018 x 0.025 NiTi Tel</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Alt Ark Teli:</span>
                        <span class="badge bg-indigo text-white">0.016 NiTi Esnek Tel</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">İntermaksiller Lastik:</span>
                        <span class="badge bg-danger">Class II 3/16" 4.5 oz Lastik (Gece)</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small">
                    <i class="fa-solid fa-calendar me-1"></i><strong>Sonraki Aktivasyon:</strong> 4 Hafta Sonra (Tel Değişimi & Ark Daraltma).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-equals me-2 text-primary"></i>Ortodontik Muayene & Aktivasyon Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_orthodontics">
            <input type="hidden" name="redirect_route" value="dental.orthodontics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Angle Maloklüzyon Evresi</label>
                    <select name="sub_specialty_data[angle_class]" class="form-select">
                        <option value="Class I (Normal Kapanış)">Class I (Normal Kapanış)</option>
                        <option value="Class II Div 1 (Üst Çene İleride)">Class II Div 1 (Üst Çene İleride)</option>
                        <option value="Class II Div 2">Class II Div 2</option>
                        <option value="Class III (Alt Çene İleride)">Class III (Alt Çene İleride)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Braket & Tedavi Tipi</label>
                    <select name="sub_specialty_data[bracket_system]" class="form-select">
                        <option value="Metal Braket (Sabit Tel)">Metal Braket (Sabit Tel)</option>
                        <option value="Estetik Seramik Braket">Estetik Seramik Braket</option>
                        <option value="Damon Kapaklı Sistem">Damon Kapaklı Sistem</option>
                        <option value="Şeffaf Plak (Invisalign)">Şeffaf Plak (Invisalign)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Aktif Takılan Ark Teli Kalınlığı</label>
                    <input type="text" name="sub_specialty_data[archwire]" class="form-control" value="0.018 x 0.025 NiTi Dikdörtgen Tel">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">İntermaksiller Lastik Çekimi</label>
                    <input type="text" name="sub_specialty_data[elastics]" class="form-control" value="Class II 3/16-4.5oz Gece Kullanımı">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Ortodontik Muayene & Aktivasyon Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Çapraşıklık miktarı (mm), sefalometrik analiz değerleri (SNA/SNB), ligatür değişimi ve hasta uyumu..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Ortodontist: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Ortodonti Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
