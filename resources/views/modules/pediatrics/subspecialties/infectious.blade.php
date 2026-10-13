@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-shield-virus text-indigo me-2"></i>Çocuk Enfeksiyon Hastalıkları
@endsection

@section('page_description')
    İzolasyon Tipi Yönetimi (Temas, Damlacık, Solunum), Bulaşıcı Hastalık Bildirimi.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-shield-virus me-2 text-indigo"></i>Çocuk Enfeksiyon & İzolasyon Paneli
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_infectious">
            <input type="hidden" name="redirect_route" value="pediatrics.infectious">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">İzolasyon Tipi</label>
                    <select name="sub_specialty_data[isolation_type]" class="form-select">
                        <option value="İzolasyon Yok">İzolasyon Yok (Standart Önlemler)</option>
                        <option value="Temas İzolasyonu">Temas İzolasyonu (Sarı Kutu)</option>
                        <option value="Damlacık İzolasyonu">Damlacık İzolasyonu (Mavi Kutu)</option>
                        <option value="Solunum İzolasyonu">Solunum İzolasyonu (Kırmızı Kutu - Negatif Basınç)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Bulaşıcı Hastalık Bildirimi (Form 014)</label>
                    <select name="sub_specialty_data[notifiable_disease]" class="form-select">
                        <option value="Bildirime Tabi Değil">Bildirime Tabi Değil</option>
                        <option value="Kızamık / Kızamıkçık">Kızamık / Kızamıkçık Bildirimi Yapıldı</option>
                        <option value="Menenjit / Meningokok">Meningokoksemik Menenjit Bildirimi</option>
                        <option value="Boğmaca">Boğmaca Bildirimi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Geniş Spektrumlu Antibiyotik Onayı</label>
                    <input type="text" name="sub_specialty_data[antibiotic_approval]" class="form-control" placeholder="ör: Meropenem 60 mg/kg/gün (Enfeksiyon Onaylı)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Enfeksiyon Muayenesi & Ateş Etyolojisi Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Dirençli ateş odağı, kan/idrar kültür sonuçları, prokalsitonin düzeyi ve geniş spektrumlu antibiyoterapi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Uzm. Dr. Serkan Bulut</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Enfeksiyon Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
