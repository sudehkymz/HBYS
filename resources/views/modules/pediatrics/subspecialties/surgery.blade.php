@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-scalpel text-indigo me-2"></i>Çocuk Cerrahisi
@endsection

@section('page_description')
    Pediatrik Cerrahi Sarf Malzeme Boyutlandırma (Kateter/Tüp), Pre-Op NPO (Açlık) Sayacı, Vasi Dijital Onam.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-scalpel me-2 text-indigo"></i>Çocuk Cerrahisi & Pre-Op Malzeme Önerici Ekranı
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_surgery">
            <input type="hidden" name="redirect_route" value="pediatrics.surgery">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Yaş/Kiloya Göre Kateter & Entübe Tüp Önerisi</label>
                    <input type="text" class="form-control fw-bold text-indigo bg-white" value="Tüp Çapı: {{ 4 + ($selectedAdmission['age']/4) }} mm Uncuffed" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pre-Op NPO (Açlık) Süre Sayacı</label>
                    <select name="sub_specialty_data[npo_duration]" class="form-select">
                        <option value="Anne Sütü: 4 Saat Açlık">Anne Sütü (4 Saat Açlık Tamamlandı)</option>
                        <option value="Berrak Sıvı: 2 Saat Açlık">Berrak Sıvı (2 Saat Açlık Tamamlandı)</option>
                        <option value="Katı Gıda: 6 Saat Açlık">Katı Gıda (6 Saat Açlık Tamamlandı)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Vasi Cerrahi Aydınlatılmış Dijital Onam</label>
                    <input type="text" class="form-control" value="Dijital İmzalandı (Vasi T.C.: {{ $guardian['tc'] ?? '-' }})" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Cerrahi Muayene & Operasyon Plan Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="İnguinal fıtık, apandisit, sünnet veya konjenital malformasyon cerrahi planı ve pre-op hazırlık notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Prof. Dr. Ahmet Can (Çocuk Cerrahı)</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Cerrahi Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
