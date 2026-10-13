@extends('modules.general_surgery.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-ribbon me-2 text-warning"></i>Cerrahi Onkolojisi Polikliniği (Yan Dal)
@endsection

@section('page_description')
    Sitoredüktif Cerrahi (CRS), HIPEC sıcak kemoterapi perfüzyonu, Peritoneal Karsinomatoz Skoru (PCI) & R0 rezeksiyon sınırı.
@endsection

@section('general_surgery_workspace')
<div class="row g-4 mb-4">
    <!-- CRS & HIPEC Chemoperfusion Card -->
    <div class="col-md-6">
        <div class="card surg-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-flask-vial me-2"></i>Sitoredüktif Cerrahi & HIPEC Perfüzyonu</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">HIPEC Sıcak Kemoterapi:</span>
                        <span class="badge bg-danger fs-6">42°C Mitomisin-C (90 Dk Perfüzyon)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">PCI Skoru (Peritoneal İndeks):</span>
                        <span class="badge bg-warning text-dark">PCI: 12 / 39 (Sitoredüksiyona Uygun)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Rezeksiyon Skoru (CC):</span>
                        <span class="badge bg-success">CC-0 (Mikroskobik Tam Sitoredüksiyon)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Peritoneal Silikon Drenler:</span>
                        <span class="fw-bold text-dark">4 Adet Abdominal Dren (Toplam 220 ml/gün)</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Hipertermik İntraperitoneal Perfüzyon:</strong> 42°C Sabit Sıcaklıkta Kapalı Devra HIPEC Tamamlandı.
                </div>
            </div>
        </div>
    </div>

    <!-- Tumor Board & Surgical Margins Card -->
    <div class="col-md-6">
        <div class="card surg-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-microscope me-2"></i>Tümör Konseyi & Cerrahi Sınır (Frozen)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Cerrahi Sınır (R0 Status):</span>
                        <span class="badge bg-success">R0 Rezeksiyon (Tümör Sınırı Temiz)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">SLNB (Sentinel Nodu Biyopsisi):</span>
                        <span class="badge bg-primary">Frozen İnceleme 3/3 Lenf Nodu Reaktif Negatif</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Evreleme (pTNM):</span>
                        <span class="fw-bold text-dark">pT3 N1a M0 (Evre IIIB Kolorektal Ca)</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <strong>Konsey Kararı:</strong> Post-Op 4. Haftada Adjuvan FOLFOX-6 Kemoterapisi Başlanması Uygundur.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card surg-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-ribbon me-2 text-warning"></i>Cerrahi Onkolojisi Muayene & HIPEC Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('general_surgery.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="surgical_oncology">
            <input type="hidden" name="redirect_route" value="general_surgery.surgical_oncology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Onkolojik Teşhis & PCI Skoru</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-warning text-dark" value="PCI: 12 Periton Karsinomatoz - CRS + 42°C HIPEC Mitomisin-C">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Onkolojik Cerrahi Prosedür</label>
                    <select name="sub_specialty_data[oncologic_procedure]" class="form-select">
                        <option value="Sitoredüktif Cerrahi (CRS) + 42°C HIPEC">Sitoredüktif Cerrahi + HIPEC</option>
                        <option value="Total Gastrektomi + D2 Lenf Nodu Diseksiyonu">Total Gastrektomi + D2 Diseksiyon</option>
                        <option value="Laparoskopik Düşük Ön Rezeksiyon + TME">Laparoskopik LAR + TME (Rektum Ca)</option>
                        <option value="Modifiye Radikal Mastektomi + Aksiller Diseksiyon">MRM + Aksiller Diseksiyon</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">HIPEC Süresi & Kemoterapötik</label>
                    <input type="text" name="sub_specialty_data[hipec_detail]" class="form-control" value="90 Dk 42°C Mitomisin-C İntraperitoneal Perfüzyon">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Cerrahi Onkolog Muayene & Tümör Konsey Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Peritoneal karsinomatoz indeksi (PCI), sitoredüksiyon skoru (CC-0), frozen cerrahi sınır durumu, HIPEC sonrası idrar çıkışı ve adjuvan kemoterapi planı..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Cerrahi Onkolog: Prof. Dr. Cemalettin Ertekin</span>
                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Onkolojik Cerrahi Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
