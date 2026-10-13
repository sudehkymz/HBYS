@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-ribbon text-primary me-2"></i>Tıbbi Onkoloji (Kanser Tedavisi & Kemoterapi)
@endsection

@section('page_description')
    ECOG Performans Skoru, TNM kanser evrelemesi, Kemoterapi & İmmünoterapi protokolü.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- ECOG Performance Status Score Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-user-check me-2"></i>ECOG Performans Skoru & Genel Durum</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">ECOG Skoru:</span>
                        <span class="badge bg-success">ECOG 1 (Tam Mobil, Hafif Semptomatik)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Karnofsky Performans Skoru:</span>
                        <span class="fw-bold text-dark">%90 (Normal Aktivite Sürdürülebilir)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Kilo Kaybı (Son 6 Ay):</span>
                        <span class="small text-muted">2.5 kg (%3.8 Kilo Kaybı - Stabil)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Kemoterapiye Uygunluk:</strong> ECOG 1 Performans ile Sistemik Kemoterapi Tolere Edilebilir.
                </div>
            </div>
        </div>
    </div>

    <!-- TNM Staging & Chemotherapy Protocol Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-vial-virus me-2"></i>TNM Kanser Evreleme & Kemoterapi Protokolü</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">TNM Evresi:</span>
                        <span class="badge bg-danger">Evre III (pT3 N1 M0 Kolorektal Ca)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Aktif Kemoterapi Kürü:</span>
                        <span class="fw-bold text-dark">FOLFOX6 Protokolü (4. Kür / 12 Kür)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Tümör Markörleri (CEA / CA19-9):</span>
                        <span class="badge bg-warning text-dark">CEA: 4.2 ng/mL (Düşüş Trendinde)</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger small text-dark">
                    <strong>Nöropati & Yan Etki Takibi:</strong> Oksaliplatin Bağlı Grade 1 Periferik Nöropati Mevcut.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-ribbon me-2 text-primary"></i>Tıbbi Onkoloji Kemoterapi & Muayene Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="oncology">
            <input type="hidden" name="redirect_route" value="internal_medicine.oncology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">ECOG Skoru & TNM Evresi</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="ECOG 1 - Stage III Kolorektal Ca (pT3N1M0)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kemoterapi / İmmünoterapi Şeması</label>
                    <select name="sub_specialty_data[chemo_protocol]" class="form-select">
                        <option value="FOLFOX6 (Oksaliplatin + 5-FU + Lökovorin)">FOLFOX6 (Oksaliplatin + 5-FU)</option>
                        <option value="FOLFIRI + Bevasizumab">FOLFIRI + Bevasizumab</option>
                        <option value="Pembrolizumab (İmmünoterapi)">Pembrolizumab (İmmünoterapi)</option>
                        <option value="Adjuvan Kemoterapi Kürü">Adjuvan Kemoterapi Kürü</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Aktif Seans / Toplam Kür</label>
                    <input type="text" name="sub_specialty_data[cycle_no]" class="form-control" value="4. Kür / Toplam 12 Kür">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Onkolog Muayene & Tümör Konseyi Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Nöropati evresi, bulantı/kusma kontrolü (NK1 antagonisti + 5-HT3), PET-CT yanıt değerlendirme ve konsey kararı..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Onkolog: Prof. Dr. İbrahim Yıldız</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Onkoloji Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
