@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-flask text-indigo me-2"></i>Çocuk Metabolizma Hastalıkları
@endsection

@section('page_description')
    Yenidoğan Topuk Kanı Taraması, Fenilketonüri, Nadir Hastalık Özel Diyet & Mama Raporlama.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-flask me-2 text-indigo"></i>Çocuk Metabolizma & Tarama Ekranı
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_metabolism">
            <input type="hidden" name="redirect_route" value="pediatrics.metabolism">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Yenidoğan Topuk Kanı Tarama Sonucu</label>
                    <select name="sub_specialty_data[heel_blood_result]" class="form-select">
                        <option value="Normal (Temiz)">Topuk Kanı Taraması - Normal (Temiz)</option>
                        <option value="Fenilketonüri Yüksek">Fenilalanin Yüksek (Fenilketonüri Şüphesi)</option>
                        <option value="Kistik Fibrozis Yüksek">IRT Yüksek (Kistik Fibrozis Şüphesi)</option>
                        <option value="Biyotinidaz Yüksek">Biyotinidaz Eksikliği Şüphesi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kan Fenilalanin / Amino Asit Seviyesi</label>
                    <input type="text" name="sub_specialty_data[phenylalanine_level]" class="form-control" placeholder="ör: Fenilalanin: 4.2 mg/dL">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Özel Diyet / Mama Rapor Onayı</label>
                    <input type="text" name="sub_specialty_data[special_formula_report]" class="form-control" placeholder="ör: Fenilalaninsiz Mama Raporu Onaylandı">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Metabolik Klinik Notlar & Diyet Protokolü</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Tandem MS metabolik tarama paneli, organik asidemi takibi, kısıtlı diyet tedavisi ve enzim replasmanı..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Doç. Dr. Nesrin Aydın</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Metabolizma Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
