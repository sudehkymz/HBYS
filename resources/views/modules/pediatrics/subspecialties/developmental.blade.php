@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-hands-holding-child text-indigo me-2"></i>Gelişimsel Pediatri
@endsection

@section('page_description')
    DENVER II Gelişimsel Tarama Formu, M-CHAT Otizm Taraması, Motor-Dil-Sosyal Gelişim Basamakları.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-hands-holding-child me-2 text-indigo"></i>DENVER II & M-CHAT Gelişimsel Tarama Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="developmental_pediatrics">
            <input type="hidden" name="redirect_route" value="pediatrics.developmental">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">DENVER II Test Skoru</label>
                    <select name="sub_specialty_data[denver_score]" class="form-select">
                        <option value="Normal">DENVER II - Normal Gelişim</option>
                        <option value="Şüpheli">DENVER II - Şüpheli Gelişim Gecikmesi</option>
                        <option value="Anormal">DENVER II - Anormal (Belirgin Gecikme)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">M-CHAT Otizm Tarama Skoru</label>
                    <select name="sub_specialty_data[mchat_score]" class="form-select">
                        <option value="Düşük Risk">M-CHAT - Düşük Risk (0-2 Puan)</option>
                        <option value="Orta Risk">M-CHAT - Orta Risk (3-7 Puan)</option>
                        <option value="Yüksek Risk">M-CHAT - Yüksek Risk (8-20 Puan)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Konuşma & Dil Gelişim Düzeyi</label>
                    <input type="text" name="sub_specialty_data[language_level]" class="form-control" placeholder="ör: 2 kelimeli cümleler kurabiliyor">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Gelişimsel Basamak Değerlendirme Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Kaba motor, ince motor, dil ve kişisel-sosyal alan gelişim değerlendirmesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Uzm. Dr. Canan Yılmaz</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Gelişimsel Muayeneyi Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
