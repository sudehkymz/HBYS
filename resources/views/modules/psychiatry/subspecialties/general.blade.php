@extends('modules.psychiatry.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-brain me-2" style="color: #0284c7;"></i>Ruh Sağlığı ve Hastalıkları Polikliniği (Psikiyatri)
@endsection

@section('page_description')
    Ruhsal durum muayenesi (MSE), HAM-D / HAM-A ölçekleri, PANSS skoru, rTMS nöromodülasyon & EKT elektroşok tedavi takibi.
@endsection

@section('psychiatry_workspace')
<div class="row g-4 mb-4">
    <!-- HAM-D & HAM-A Depression/Anxiety Scales Card -->
    <div class="col-md-6">
        <div class="card psych-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-calculator me-2"></i>HAM-D Depresyon & HAM-A Anksiyete Ölçekleri</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">HAM-D (Hamilton Depresyon):</span>
                        <span class="badge bg-danger fs-6">HAM-D: 26 / 52 (Şiddetli Depresif Nöbet)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">HAM-A (Hamilton Anksiyete):</span>
                        <span class="badge bg-warning text-dark">HAM-A: 28 / 56 (Şiddetli Anksiyete)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">CGI (Klinik Global İzlenim):</span>
                        <span class="fw-bold text-dark">CGI: 5 (Belirgin Derecede Hasta)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Lityum Kan Düzeyi:</span>
                        <span class="badge bg-success">0.7 mEq/L (Terapötik Hedef 0.6-1.0)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Psikoterapi Entegrasyonu:</strong> Bilişsel Davranışçı Terapi (BDT) 8. Seans Tamamlandı.
                </div>
            </div>
        </div>
    </div>

    <!-- rTMS Neuromodulation & ECT Electroconvulsive Therapy Card -->
    <div class="col-md-6">
        <div class="card psych-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-bolt me-2"></i>rTMS Nöromodülasyon & EKT Terapi Protokolü</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">rTMS Manyetik Uyarım:</span>
                        <span class="badge bg-primary">12. Seans Sol DLPFC Protokolü (%110 MT)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">EKT (Elektrokonvülsif Terapi):</span>
                        <span class="badge bg-danger">6. Seans Bilateral EKT (Motor Nöbet: 38 sn)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">PANSS Skoru (Psikoz):</span>
                        <span class="badge bg-warning text-dark">PANSS: 84 (Pozitif Alevlenme Geriledi)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Nöroleptik / Antipsikotik:</span>
                        <span class="fw-bold text-dark">Olanzapin 15mg/gün + Valproik Asit 1000mg</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <strong>Anestezi & EKT Onayı:</strong> Genel Anestezi Altında Süksinilkolin Nöromüsküler Blokajlı EKT Onaylı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card psych-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-head-side-virus me-2" style="color: #0284c7;"></i>Psikiyatri Muayene & Ruhsal Durum Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('psychiatry.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="general">
            <input type="hidden" name="redirect_route" value="psychiatry.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Psikiyatrik Teşhis & HAM-D/PANSS</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-info" style="border-color: #0284c7 !important; color: #0284c7;" value="HAM-D: 26 Dirençli Depresyon - rTMS DLPFC 12. Seans">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Reçete Edilen Psikotrop İlaç</label>
                    <select name="sub_specialty_data[psychiatry_medication]" class="form-select">
                        <option value="Vortioksetin 20mg 1x1 + Lityum 300mg 2x1">Vortioksetin 20mg + Lityum 300mg</option>
                        <option value="Olanzapin 15mg/gün + Valproik Asit 1000mg">Olanzapin 15mg + Valproik Asit 1000mg</option>
                        <option value="Escitalopram 20mg 1x1 + Alprazolam 0.5mg">Escitalopram 20mg + Alprazolam 0.5mg</option>
                        <option value="Ketiapin 300mg XR (Bipolar Depresyon)">Ketiapin 300mg XR (Bipolar Depresyon)</option>
                        <option value="Aripiprazol 15mg 1x1 + Bilişsel Terapi">Aripiprazol 15mg + Bilişsel Terapi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Somatik / Terapi İslemi</label>
                    <input type="text" name="sub_specialty_data[somatic_therapy]" class="form-control" value="Sol DLPFC rTMS Nöromodülasyon / Bilateral EKT">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Ruhsal Durum Muayenesi (MSE) & Psikiyatrist Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Dış görünüş, özbakım, duygudurum (mood) ve duygunayım (affect), düşünce içeriği (hezeyan), algı bozuklukları (halüsinasyon), oryantasyon ve intihar riski değerlendirmesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Psikiyatrist: Prof. Dr. Evren Şimşek</span>
                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #0284c7;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Psikiyatri Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
