@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-stomach text-indigo me-2"></i>Çocuk Gastroenterolojisi
@endsection

@section('page_description')
    Waterlow ve Gomez Malnütrisyon Sınıflaması, Endoskopi/Kolonoskopi Raporu, Çölyak Takip Kartı.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-stomach me-2 text-indigo"></i>Çocuk Gastroenterolojisi & Beslenme Paneli
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_gastroenterology">
            <input type="hidden" name="redirect_route" value="pediatrics.gastroenterology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Waterlow Malnütrisyon Derecesi</label>
                    <select name="sub_specialty_data[waterlow_grade]" class="form-select">
                        <option value="Normal (>90%)">Waterlow - Normal (>90%)</option>
                        <option value="Hafif Malnütrisyon (80-90%)">Hafif Malnütrisyon (Evre 1)</option>
                        <option value="Orta Malnütrisyon (70-80%)">Orta Malnütrisyon (Evre 2)</option>
                        <option value="Ağır Malnütrisyon (<70%)">Ağır Malnütrisyon (Evre 3)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Çölyak Antikor Paneli (tTG IgA / EMA)</label>
                    <input type="text" name="sub_specialty_data[celiac_panel]" class="form-control" placeholder="ör: Doku Transglutaminaz IgA: 120 U/mL (Pozitif)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Endoskopi / Biopsi Rapor Notu</label>
                    <input type="text" name="sub_specialty_data[endoscopy_report]" class="form-control" placeholder="ör: Duodenum Biopsisi Marsh 3b (Çölyak Uyumlu)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Gastrointestinal Muayene & Diyet Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Kronik karın ağrısı, dışkılama düzeni (Bristol Skalası), karın distansiyonu ve Glutensiz Diyet reçetesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Doç. Dr. Nesrin Aydın</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Gastroenteroloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
