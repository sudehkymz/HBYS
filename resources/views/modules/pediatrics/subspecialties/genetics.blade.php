@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-microscope text-indigo me-2"></i>Çocuk Genetik Hastalıkları
@endsection

@section('page_description')
    Dijital Soyağacı (Pedigree) Çizim & Veri Giriş Şablonu, Dismorfoloji Muayenesi, Genetik Test Paneli.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-microscope me-2 text-indigo"></i>Çocuk Genetik & Dijital Soyağacı (Pedigree) Paneli
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_genetics">
            <input type="hidden" name="redirect_route" value="pediatrics.genetics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Karyotip / Sitogenetik Analiz</label>
                    <input type="text" name="sub_specialty_data[karyotype]" class="form-control" placeholder="ör: 46,XY (Normal Erkek Karyotipi)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">WES / WGS Dizi Analiz Testi</label>
                    <input type="text" name="sub_specialty_data[wes_result]" class="form-control" placeholder="ör: FGFR3 Mutasyonu (Akondroplazi Uyumlu)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Akraba Evliliği / Soyağacı Öyküsü</label>
                    <select name="sub_specialty_data[consanguinity]" class="form-select">
                        <option value="Akraba Evliliği Yok">Akraba Evliliği Yok</option>
                        <option value="1. Derece Akraba Evliliği (Kuzen)">1. Derece Akraba Evliliği (Kuzen)</option>
                        <option value="2. Derece Akraba Evliliği">2. Derece Akraba Evliliği</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Dismorfik Muayene & Genetik Danışmanlık Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Fasiyal dismorfizm bulguları, epikantus katlantısı, mikrosefali/makrosefali, sendromik ön tanılar ve aile genetik danışmanlığı..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Doç. Dr. Nesrin Aydın</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Genetik Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
