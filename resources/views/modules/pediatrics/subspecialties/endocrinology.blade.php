@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-dna text-indigo me-2"></i>Çocuk Endokrinolojisi
@endsection

@section('page_description')
    Tanner Evrelemesi (Ergenlik Büyüme Skalası), Kemik Yaşı Raporu, Yıllık Büyüme Hızı (cm/yıl) hesabı.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-dna me-2 text-indigo"></i>Çocuk Endokrinolojisi & Ergenlik / Büyüme Paneli
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_endocrinology">
            <input type="hidden" name="redirect_route" value="pediatrics.endocrinology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">Tanner Evresi (Ergenlik)</label>
                    <select name="sub_specialty_data[tanner_stage]" class="form-select">
                        <option value="Evre 1 (Prepubertal)">Evre 1 (Prepubertal)</option>
                        <option value="Evre 2 (Erken Ergenlik)">Evre 2 (Erken Ergenlik)</option>
                        <option value="Evre 3 (Pubertal)">Evre 3 (Pubertal)</option>
                        <option value="Evre 4 (Geç Ergenlik)">Evre 4 (Geç Ergenlik)</option>
                        <option value="Evre 5 (Erişkin Düzeyi)">Evre 5 (Erişkin Düzeyi)</option>
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">Kemik Yaşı (Sol El-Bilek)</label>
                    <input type="text" name="sub_specialty_data[bone_age]" class="form-control" placeholder="ör: 9 Yaş 6 Ay (Greulich-Pyle)">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">Yıllık Büyüme Hızı (cm/yıl)</label>
                    <input type="number" step="0.1" name="sub_specialty_data[growth_velocity]" class="form-control" placeholder="ör: 6.2 cm/yıl">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">İnsülin / Hba1c Skoru</label>
                    <input type="text" name="sub_specialty_data[hba1c]" class="form-control" placeholder="ör: HbA1c: %6.8 (Tip 1 Diyabet)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Endokrinolojik Bulgular & Reçete Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Büyüme hormonu (GH) stimülasyon testleri, tiroit hormon düzeyleri ve insülin pompa ayarları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Prof. Dr. Ahmet Can</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Endokrin Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
