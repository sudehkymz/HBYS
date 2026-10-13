@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-user-doctor text-success me-2"></i>Aile Hekimliği Polikliniği (Primary Care)
@endsection

@section('page_description')
    Periyodik sağlık taraması, HYP kronik hastalık takibi, aşı ve bağışıklama, gebe/bebek izlem.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- HYP Chronic Disease Risk Matrix Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-heart-circle-check me-2"></i>HYP (Hastalık Yönetim Platformu) Risk İzlemi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Diyabetes Mellitus Risk Taraması:</span>
                        <span class="badge bg-success">Düşük Risk (AKŞ: 92 mg/dL)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kardiyovasküler Risk Skoru (SCORE):</span>
                        <span class="badge bg-warning text-dark">%2.4 (10 Yıllık Risk - Düşük/Orta)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Tansiyon & Obezite İzlemi:</span>
                        <span class="fw-bold text-dark">TA: 120/80 mmHg, VKİ: 24.2 kg/m²</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Sağlık Bakanlığı HYP Bildirimi:</strong> Yıllık HYP Kronik Hastalık Taraması Başarıyla Onaylandı.
                </div>
            </div>
        </div>
    </div>

    <!-- Vaccination & Screening Schedule Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-syringes me-2"></i>Aşı, Bağışıklama & Kanser Taramaları</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Erişkin Tetanoz (Td) Aşısı:</span>
                        <span class="badge bg-success">Yapıldı (10 Yıllık Rapel Tamam)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kanser Taraması (HPV / Smear):</span>
                        <span class="badge bg-primary">Pap-Smear Yapıldı (Negatif)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Gaita Gizli Kan (GGK - Kolorektal):</span>
                        <span class="small text-muted">GGK Test Kit Teslim Edildi</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>Mevsimsel Aşı Önerisi:</strong> Sonbahar dönemi için İnfluenza (Grip) Aşısı reçete edildi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-user-doctor me-2 text-success"></i>Aile Hekimliği Muayene & HYP Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="family_medicine">
            <input type="hidden" name="redirect_route" value="internal_medicine.family_medicine">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">HYP Tarama Statüsü</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-success text-success" value="HYP İzlemi Yapıldı - Kardiyovasküler Risk %2.4 (Normal)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Uygulanan Aşı / İstem</label>
                    <select name="sub_specialty_data[vaccine_given]" class="form-select">
                        <option value="Td (Tetanoz-Difteri) Rapel Dozu">Td (Tetanoz-Difteri) Rapel Dozu</option>
                        <option value="İnfluenza (Grip) Aşısı Reçetesi">İnfluenza (Grip) Aşısı Reçetesi</option>
                        <option value="Hepatit B Aşı Serisi">Hepatit B Aşı Serisi</option>
                        <option value="Pnomokok (Zatürre) Aşısı">Pnomokok (Zatürre) Aşısı</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kanser Tarama Tipi</label>
                    <input type="text" name="sub_specialty_data[screening_type]" class="form-control" value="GGK (Gaita Gizli Kan) + Pap-Smear">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Aile Hekimi Muayene & Periyodik İzlem Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Fizik muayene bulguları, beslenme ve yaşam tarzı danışmanlığı, HYP protokolü ve bir sonraki izlem tarihi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Aile Hekimi: Uzm. Dr. Aylin Güneş</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Aile Hekimliği Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
