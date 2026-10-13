@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-heart-circle-check text-danger me-2"></i>Çocuk Kalp Damar Cerrahisi (KDC)
@endsection

@section('page_description')
    Perfüzyon ve Ekstrakorporal Dolaşım (EKD) Veri Formu, Post-Op Yoğun Bakım Arter/CVP Trend Grafikleri.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-heart-circle-check me-2 text-danger"></i>Pediatrik Kalp Damar Cerrahisi & EKD Paneli
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_cardiovascular_surgery">
            <input type="hidden" name="redirect_route" value="pediatrics.cardiovascular_surgery">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Perfüzyon & EKD (Pompa) Süresi</label>
                    <input type="text" name="sub_specialty_data[ekd_duration]" class="form-control" placeholder="ör: Klempleme: 45 dk, EKD: 62 dk">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Cerrahi Onarım / Şant Ameliyatı</label>
                    <input type="text" name="sub_specialty_data[repair_type]" class="form-control" placeholder="ör: VSD Yama Onarımı / Blalock-Taussig Şant">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Post-Op İnotrop Destek Skoru (VIS)</label>
                    <input type="text" name="sub_specialty_data[vis_score]" class="form-control" placeholder="ör: VIS Puanı: 8 (Adrenalin + Milrinon)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">KDC Operasyon & Ameliyathane Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Açık kalp cerrahisi yama tekniği, kanama kontrolü, dren takibi ve post-op yoğun bakım devir parametreleri..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Prof. Dr. Deniz Yıldız</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>KDC Operasyon Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
