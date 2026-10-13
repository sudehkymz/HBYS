@extends('modules.obgyn.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-ribbon me-2 text-danger"></i>Jinekolojik Onkoloji Cerrahisi Polikliniği
@endsection

@section('page_description')
    Endometriyum/Serviks/Over kanseri laparoskopik TAH-BSO, pelvik lenf diseksiyonu, FIGO evrelemesi & CA-125 tümör belirteçleri.
@endsection

@section('obgyn_workspace')
<div class="row g-4 mb-4">
    <!-- FIGO Staging & Tumor Markers Card -->
    <div class="col-md-6">
        <div class="card obgyn-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-ribbon me-2"></i>FIGO Evrelemesi & Tümör Belirteçleri</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Jinekolojik Kanser Teşhisi:</span>
                        <span class="badge bg-danger fs-6">Endometriyum Karsinomu (Grade 1)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">FIGO Evresi:</span>
                        <span class="badge bg-warning text-dark">FIGO Evre IA (Miyometriyal İnvazyon <%50)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">CA-125 Serbest Düzeyi:</span>
                        <span class="badge bg-success">22 U/mL (Normal Sınırda <35)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">HE4 & ROMA Skoru:</span>
                        <span class="fw-bold text-dark">ROMA Skoru: %6.4 (Düşük Risk Grubu)</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Cerrahi Patoloji Yanıtı:</strong> Pelvik Lenf Nodu Biyopsisi (0/14) Metastaz Saptanmadı.
                </div>
            </div>
        </div>
    </div>

    <!-- Laparoscopic TAH-BSO & Surgical Oncologic Resection Card -->
    <div class="col-md-6">
        <div class="card obgyn-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-scalpel me-2"></i>Laparoskopik TAH-BSO & Lenfadenektomi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Uygulanan Cerrahi Prosedür:</span>
                        <span class="badge bg-primary">Laparoskopik TAH + BSO</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Pelvik Lenf Nodu Diseksiyonu:</span>
                        <span class="fw-bold text-dark">Bilateral Eksternal & İntra-İliyak Diseksiyon</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Omentektomi & Peritoneal Yıkama:</span>
                        <span class="badge bg-success">Infragastrik Omentektomi + Sitoloji Negatif</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>Jinekolojik Konsey Kararı:</strong> Düşük Risk Evre IA Nedeniyle Adjuvan Radyoterapi Gerekmemektedir, 3 Aylık Takip Planlandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card obgyn-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-ribbon me-2 text-danger"></i>Jinekolojik Onkoloji Muayene & Cerrahi Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('obgyn.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="gyn_oncology">
            <input type="hidden" name="redirect_route" value="obgyn.gyn_oncology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Jine-Onkolojik Teşhis & FIGO Evresi</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="Endometriyum Adenokarsinomu FIGO Evre IA - Laparoskopik TAH-BSO (CA-125: 22 U/mL)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Onkolojik Cerrahi Prosedür</label>
                    <select name="sub_specialty_data[gyn_onc_surg]" class="form-select">
                        <option value="Laparoskopik TAH-BSO + Pelvik Lenf Diseksiyonu">Laparoskopik TAH-BSO + Lenf Diseksiyonu</option>
                        <option value="Radikal Histerektomi (Wertheim-Meigs Ameliyatı)">Radikal Histerektomi (Wertheim-Meigs)</option>
                        <option value="Debulking Sitoredüktif Over Kanseri Cerrahisi">Sitoredüktif Over Kanseri Cerrahisi</option>
                        <option value="Radikal Vulvektomi + İnguinal Lenfadenektomi">Radikal Vulvektomi + Lenfadenektomi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tümör Belirteci & CA-125</label>
                    <input type="text" name="sub_specialty_data[ca125_status]" class="form-control" value="CA-125: 22 U/mL, HE4: 48 pmol/L (ROMA %6.4)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Jinekolojik Onkolog Muayene & Patoloji Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Pelvik bimanuel muayene bulguları, vajinal cuff pansumanı, frozen spesimen tümör derinliği, lenf nodu diseksiyon sayısı ve jinekolojik tümör konseyi kararları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Jinekolojik Onkolog: Doç. Dr. Selen Turgut</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Jine-Onkoloji Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
