@extends('modules.psychiatry.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-capsules me-2 text-danger"></i>AMATEM Polikliniği (Alkol ve Madde Bağımlılığı Özel Birimi)
@endsection

@section('page_description')
    CIWA-Ar alkol yoksunluk takibi, COWS opiyat skalası, idrar toksikoloji doğrulama paneli, Suboxone/Naltrekson ve denetimli serbestlik.
@endsection

@section('psychiatry_workspace')
<div class="row g-4 mb-4">
    <!-- CIWA-Ar & COWS Withdrawal Assessment Card -->
    <div class="col-md-6">
        <div class="card psych-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-notes-medical me-2"></i>CIWA-Ar & COWS Yoksunluk Derecelendirmesi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">CIWA-Ar (Alkol Yoksunluğu):</span>
                        <span class="badge bg-danger fs-6">CIWA-Ar: 18 (Orta-Şiddetli Tremor & Terleme)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">COWS (Opiyat Yoksunluğu):</span>
                        <span class="badge bg-warning text-dark">COWS Skoru: 14 (Pupil Dilatasyonu & Ağrı)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Suboxone (Buprenorfin/Nalokson):</span>
                        <span class="badge bg-success">8mg/2mg Dil Altı Tablet (1x1 İdame)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Naltrekson Depo Enjeksiyon:</span>
                        <span class="fw-bold text-dark">Vivitrol 380mg IM Aylık Enjeksiyon</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <i class="fa-solid fa-shield-virus me-1"></i><strong>Detoksifikasyon Protokolü:</strong> Diazepam Tapering (Detoks) + B-Kompleks Hidrasyon Başlandı.
                </div>
            </div>
        </div>
    </div>

    <!-- Toxicology Urine Panel & Probation Mandate Card -->
    <div class="col-md-6">
        <div class="card psych-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-vial me-2"></i>İdrar Toksikoloji Paneli & Denetimli Serbestlik</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">THC (Esrar Taraması):</span>
                        <span class="badge bg-success">Negatif (Temiz İdrar)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">AMP / OPI (Amfetamin/Opiyat):</span>
                        <span class="badge bg-success">Negatif (Doğrulama Temiz)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">BZO / BUP (Benzodiazepin/Buprenorfin):</span>
                        <span class="badge bg-primary">BUP Pozitif (Tedavi İlacı Uyumlu)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Denetimli Serbestlik Statüsü:</span>
                        <span class="badge bg-info text-dark">Adli Kurum İdrar Takip Onaylı</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Adli Toksikoloji Kararı:</strong> Kamera Gözetimli İdrar Örneği Alındı, E-Adli Sistemi Bildirimi Yapıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card psych-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-capsules me-2 text-danger"></i>AMATEM Bağımlılık Muayene & Toksikoloji Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('psychiatry.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="amatem">
            <input type="hidden" name="redirect_route" value="psychiatry.amatem">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">AMATEM Teşhis & Yoksunlık Skoru</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="CIWA-Ar: 18 Alkol Yoksunluğu / Suboxone 8mg İdame Tedavisi">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">İkame / Substitüsyon İlacı</label>
                    <select name="sub_specialty_data[substitution_med]" class="form-select">
                        <option value="Buprenorfın/Nalokson (Suboxone) 8mg/2mg Dil Altı">Suboxone 8mg Dil Altı Tablet</option>
                        <option value="Naltrekson (Vivitrol 380mg IM Aylık Enjeksiyon)">Vivitrol 380mg IM Enjeksiyon</option>
                        <option value="Disülfiram (Antabuse) 500mg 1x1 (Alkol Aversiyon)">Disülfiram (Antabuse) 500mg</option>
                        <option value="Diazepam Detoksifikasyon Protokolü (Tapering)">Diazepam Detoks Protokolü</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">İdrar Toksikoloji Paneli İstemi</label>
                    <input type="text" name="sub_specialty_data[toxicology_request]" class="form-control" value="THC, AMP, OPI, BZO, BUP 5'li Gözetimli İdrar Paneli">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">AMATEM Hekim Muayene & Bağımlılık Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Madde kullanım öyküsü (aşerme/craving), en son kullanım zamanı, yoksunluk belirtileri (tremor, terleme, ajitasyon), toksikoloji doğrulaması ve denetimli serbestlik bildirim notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>AMATEM Hekimi: Prof. Dr. Evren Şimşek</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>AMATEM Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
