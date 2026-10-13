@extends('modules.anesthesiology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-syringe me-2" style="color: #7c3aed;"></i>Anesteziyoloji ve Reanimasyon (Ana Branş)
@endsection

@section('page_description')
    Pre-op anesteziyolojik risk değerlendirmesi (ASA I-IV), Mallampati zor havayolu skorlaması & spinal/epidural anestezi.
@endsection

@section('anesthesiology_workspace')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card ans-card h-100 border-start border-4" style="border-left-color: #7c3aed !important;">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0" style="color: #7c3aed;"><i class="fa-solid fa-heart-pulse me-2"></i>Pre-Op Risk Sınıflaması (ASA Skoru)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">ASA Risk Derecesi:</span>
                        <span class="badge bg-danger fs-6">ASA III (Sistemik Şiddetli Hastalık)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kardiyovasküler Risk (RCRI):</span>
                        <span class="badge bg-warning text-dark">Geçirilmiş MI & Hipertansiyon</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Açlık Süresi (NPO Status):</span>
                        <span class="fw-bold text-dark">8 Saat Katı Gıda Açlığı Tamamlandı</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Fonksiyonel Kapasite:</span>
                        <span class="badge bg-success">>4 MET (2 Kat Merdiven Tırmanabiliyor)</span>
                    </div>
                </div>
                <div class="p-2 rounded border small text-dark" style="background-color: #f3e8ff; border-color: #ddd6fe !important;">
                    <i class="fa-solid fa-circle-check me-1" style="color: #7c3aed;"></i><strong>Anestezi Kararı:</strong> Genel Anestezi + Endotrakeal Entübasyon İçin Ameliyathaneye Kabul Edildi.
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card ans-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-head-side-mask me-2"></i>Mallampati Skoru & Zor Havayolu</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Mallampati Sınıflaması:</span>
                        <span class="badge bg-danger fs-6">Evre 3 (Yalnızca Yumuşak Damak Görünüyor)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Tiromental Mesafe:</span>
                        <span class="badge bg-warning text-dark">5.5 cm (Kısa Çene Yapısı)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Ekipman Hazırlığı:</span>
                        <span class="fw-bold text-dark">Videolaringoskop (GlideScope) Standby</span>
                    </div>
                </div>
                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>Reanimasyon & Yoğun Bakım:</strong> Post-Op Derlenme Odası (PACU) Aldrete Skoru 9/10 Takibi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ans-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-file-medical me-2" style="color: #7c3aed;"></i>Anesteziyoloji Pre-Op Değerlendirme Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('anesthesiology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="general">
            <input type="hidden" name="redirect_route" value="anesthesiology.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Anestezi Teşhisi & ASA Skoru</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-purple" style="border-color: #7c3aed !important; color: #7c3aed;" value="ASA III Risk Grubu - Mallampati Evre 3 Zor Havayolu (Videolaringoskop Hazır)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Planlanan Anestezi Türü</label>
                    <select name="sub_specialty_data[anesthesia_type]" class="form-select">
                        <option value="Genel Anestezi + Endotrakeal Entübasyon">Genel Anestezi + Endotrakeal Entübasyon</option>
                        <option value="Spinal Anestezi (Subaraknoid Blok)">Spinal Anestezi (Subaraknoid Blok)</option>
                        <option value="Epidural Anestezi & Ağrı Kateteri">Epidural Anestezi & Ağrı Kateteri</option>
                        <option value="Kombine Spinal-Epidural (KSE) Anestezi">Kombine Spinal-Epidural (KSE)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Mallampati & NPO Süresi</label>
                    <input type="text" name="sub_specialty_data[ans_metrics]" class="form-control" value="Mallampati 3, 8 Saat Katı Gıda NPO, PACU Hazır">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Anesteziyolog Pre-Op Notları & Havayolu</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Pre-op lab tetkikleri (EKG, KOAG, EKO), zor entübasyon algoritması, premedikasyon (Midazolam mg), rejyonel blok planı ve reanimasyon notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Anesteziyolog: Prof. Dr. Vedat Orhan</span>
                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #7c3aed;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Anestezi Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
