@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-lungs text-indigo me-2"></i>Çocuk Göğüs Hastalıkları
@endsection

@section('page_description')
    Solunum Fonksiyon Testi (SFT), Kistik Fibrozis Ter Testi, Çocukluk Çağı Astım Kontrol Testi.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-lungs me-2 text-indigo"></i>Çocuk Göğüs Hastalıkları & Solunum Takip Paneli
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_pulmonology">
            <input type="hidden" name="redirect_route" value="pediatrics.pulmonology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Solunum Fonksiyon Testi (SFT FEV1/FVC)</label>
                    <input type="text" name="sub_specialty_data[sft_fev1]" class="form-control" placeholder="ör: FEV1: %88, FVC: %92 (Normal)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kistik Fibrozis Ter Testi (Klor mM/L)</label>
                    <input type="text" name="sub_specialty_data[sweat_test]" class="form-control" placeholder="ör: Ter Kloru: 22 mM/L (Negatif <30)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Astım Kontrol Skoru (AKT Puanı)</label>
                    <select name="sub_specialty_data[act_score]" class="form-select">
                        <option value="Tam Kontrol Altında (25 Puan)">Tam Kontrol Altında (25 Puan)</option>
                        <option value="Kısmen Kontrol Altında (20-24 Puan)">Kısmen Kontrol Altında (20-24 Puan)</option>
                        <option value="Kontrolsüz Astım (<20 Puan)">Kontrolsüz Astım (<20 Puan)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Solunum Muayenesi & Nebülizasyon Reçete Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Oskültasyon bulguları (Raller/Ronküs), wheezing varlığı, inhaler/nebül tedavisi ve oksijen satürasyonu (SpO2)..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Uzm. Dr. Serkan Bulut</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Göğüs Hastalıkları Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
