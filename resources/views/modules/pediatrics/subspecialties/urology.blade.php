@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-notes-medical text-indigo me-2"></i>Çocuk Ürolojisi
@endsection

@section('page_description')
    İşeme Günlüğü Modülü, Üroflovmetri Test Veri Şablonu, Sünnet ve Anomali Operasyon Raporları.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-notes-medical me-2 text-indigo"></i>Çocuk Ürolojisi & Üroflovmetri Takip Ekranı
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatric_urology">
            <input type="hidden" name="redirect_route" value="pediatrics.urology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Üroflovmetri Akım Eğrisi (Qmax)</label>
                    <input type="text" name="sub_specialty_data[uroflow_qmax]" class="form-control" placeholder="ör: Qmax: 18 mL/sn (Bell-shaped Çan Eğrisi)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">İnmemiş Testis / Hipospadias Evresi</label>
                    <select name="sub_specialty_data[anomaly_stage]" class="form-select">
                        <option value="Anomali Yok">Anomali Yok</option>
                        <option value="Sağ İnmemiş Testis (Palpabl)">Sağ İnmemiş Testis (Palpabl)</option>
                        <option value="Distal Hipospadias">Distal Hipospadias (Peygamber Sünneti)</option>
                        <option value="VUR (Vezikoüreteral Reflü Evre 3)">VUR (Vezikoüreteral Reflü Evre 3)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">İşeme Günlüğü (Noktüral Enürezis)</label>
                    <input type="text" name="sub_specialty_data[voiding_diary]" class="form-control" placeholder="ör: Gece Altını Islatma: 3 kez/hafta">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Pediatrik Üroloji Muayene & Operasyon Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Orşidopeksi, hipospadias onarımı, sünnet (sirkumsizyon) ve voiding sistoüretrografi (VCUG) bulguları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Uzm. Dr. Mehmet Öz</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Üroloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
