@extends('modules.obgyn.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-baby me-2 text-warning"></i>Perinatoloji Polikliniği (Riskli Gebelik)
@endsection

@section('page_description')
    Uterin/umbilikal arter Doppler USG, fetal gelişme geriliği (IUGR), preeklampsi takibi & detaylı ultrasonografi.
@endsection

@section('obgyn_workspace')
<div class="row g-4 mb-4">
    <!-- Doppler Ultrasound & Fetal Hemodynamics Card -->
    <div class="col-md-6">
        <div class="card obgyn-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-wave-square me-2"></i>Uterin & Umbilikal Arter Doppler USG</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Umbilikal Arter Doppler (PI):</span>
                        <span class="badge bg-warning text-dark fs-6">Pulsatilite İndeksi PI: 1.28 (Direnç Artmış)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Diastolik Akım (AEDF / REDF):</span>
                        <span class="badge bg-success">Pozitif İleri Diastolik Akım Var</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Orta Serebral Arter (MCA PI):</span>
                        <span class="fw-bold text-dark">MCA PI: 1.62 (Beyin Koruyucu Etki CPR >1.08)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Ductus Venosus (DV S/A Oranı):</span>
                        <span class="badge bg-success">Normal A-Dalgası Pozitif</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>IUGR Risk Yönetimi:</strong> Haftalık Doppler USG & Günlük Biyofizik Profil (BPP Skoru 8/10) Takibi.
                </div>
            </div>
        </div>
    </div>

    <!-- Preeclampsia & Maternal Monitoring Card -->
    <div class="col-md-6">
        <div class="card obgyn-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-shield-cat me-2"></i>Preeklampsi & Maternal Risk Taraması</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kan Basıncı İzlemi:</span>
                        <span class="badge bg-danger fs-6">150 / 95 mmHg (Orta Şiddette Hipertansiyon)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">24 Saatlik İdrarda Protein:</span>
                        <span class="badge bg-danger">450 mg / Gün (Proteinüri Pozitif)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">sFlt-1 / PlGF Oranı:</span>
                        <span class="badge bg-warning text-dark">sFlt-1/PlGF: 64 (Yüksek Preeklampsi Riski)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Maternal Profilaktik İlaç:</span>
                        <span class="fw-bold text-dark">Alfa-Metildopa 250mg 3x1 + Asetilsalisilik Asit</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <strong>Fetal Akciğer Maturasyonu:</strong> 34. Hafta Öncesi Doğum İhtimaline Karşı Betametazon (Celestone) 12mg 2 Doz Yapıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card obgyn-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-baby me-2 text-warning"></i>Perinatoloji Muayene & Riskli Gebelik Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('obgyn.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="perinatology">
            <input type="hidden" name="redirect_route" value="obgyn.perinatology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Perinatoloji Teşhisi & Doppler PI</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-warning text-dark" value="Preeklampsi & IUGR - Umbilikal PI: 1.28 (Proteinüri: 450 mg/gün)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Maternal Antihipertansif / Steroid</label>
                    <select name="sub_specialty_data[perinatology_med]" class="form-select">
                        <option value="Alfa-Metildopa 250mg 3x1 + Betametazon Steroid">Alfa-Metildopa + Betametazon Steroid</option>
                        <option value="Magnezyum Sülfat İnfazı (Eklampsi Profilaksisi)">Magnezyum Sülfat İnfazı</option>
                        <option value="Düşük Molekül Ağırlıklı Heparin (Enoksaparin)">Enoksaparin LMWH 4000 Anti-Xa</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Doppler Akım & BPP Skoru</label>
                    <input type="text" name="sub_specialty_data[doppler_bpp]" class="form-control" value="Umbilikal PI: 1.28, Biyofizik Profil BPP: 8/10">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Perinatolog Muayene & Detaylı USG Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Detaylı fetal anomali taraması, uterin ve umbilikal arter Doppler spektre dalgası, ductus venosus A dalgası, preeklampsi tansiyon seyri ve doğum zamanlaması kararı..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Perinatolog: Prof. Dr. Ayşe Şevket</span>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Perinatoloji Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
