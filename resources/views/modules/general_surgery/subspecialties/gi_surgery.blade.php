@extends('modules.general_surgery.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-stomach me-2 text-primary"></i>Gastroenteroloji Cerrahisi Polikliniği (Yan Dal)
@endsection

@section('page_description')
    Pankreatikoduodenektomi (Whipple), laparoskopik gastrektomi, bariyatri (tüp mide / bypass) & pankreas loj dren amilaz takibi.
@endsection

@section('general_surgery_workspace')
<div class="row g-4 mb-4">
    <!-- Whipple & Pancreatic Fistula Amylase Card -->
    <div class="col-md-6">
        <div class="card surg-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-notes-medical me-2"></i>Whipple Prosedürü & Dren Amilaz Monitorü</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Uygulanan Ameliyat:</span>
                        <span class="badge bg-primary fs-6">Whipple (Pankreatikoduodenektomi)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Dren Amilaz Değeri (Post-op 3. Gün):</span>
                        <span class="badge bg-success">180 U/L (Fistül Ekarte Edildi)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Pankreatikojejunostomi Tekniği:</span>
                        <span class="fw-bold text-dark">Duct-to-Mucosa Stentli Anastomoz</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Hepatikojejunostomi Dren Debisi:</span>
                        <span class="badge bg-info text-dark">40 ml/gün Berrak Safrasız Seröz</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Pankreatik Fistül Taraması:</strong> ISGPS Kriterlerine Göre Post-Op Pankreatik Fistül (POPF) Gelişmedi.
                </div>
            </div>
        </div>
    </div>

    <!-- Bariatric Surgery & Methylene Blue Leak Test Card -->
    <div class="col-md-6">
        <div class="card surg-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-weight-scale me-2"></i>Bariyatri (Tüp Mide) & Metilen Mavisi Kaçak Testi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Bariyatri Ameliyatı Türü:</span>
                        <span class="badge bg-success">Laparoskopik Sleeve Gastrektomi (Tüp Mide)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Metilen Mavisi Kaçak Testi:</span>
                        <span class="badge bg-success">Negatif (Zımba Hattı Sızdırmaz)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Zımba Hattı Destekleme:</span>
                        <span class="fw-bold text-dark">Seamguard / Dikiş İle Desteklendi</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <strong>Bariyatri Diyet Protokolü:</strong> Post-op 1. Gün Sıvı Diyet Fazı Başlatıldı (Ağrı Skoru VAS 1).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card surg-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-stomach me-2 text-primary"></i>Gastroenteroloji Cerrahisi Muayene Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('general_surgery.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="gi_surgery">
            <input type="hidden" name="redirect_route" value="general_surgery.gi_surgery">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">GI Cerrahi Teşhis & Amilaz</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="Pankreas Baş Ca - Whipple Prosedürü (Dren Amilaz: 180 U/L Normal)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Gastrointestinal Ameliyat Türü</label>
                    <select name="sub_specialty_data[gi_surg_type]" class="form-select">
                        <option value="Pankreatikoduodenektomi (Whipple Ameliyatı)">Whipple (Pankreatikoduodenektomi)</option>
                        <option value="Laparoskopik Subtotal / Total Gastrektomi">Laparoskopik Total Gastrektomi</option>
                        <option value="Laparoskopik Sleeve Gastrektomi (Tüp Mide)">Laparoskopik Sleeve Gastrektomi</option>
                        <option value="Roux-en-Y Gastrik Bypass (RYGB)">Roux-en-Y Gastrik Bypass</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pankreas / Kaçak Dren Değeri</label>
                    <input type="text" name="sub_specialty_data[gi_leak_status]" class="form-control" value="Metilen Mavisi Kaçak Testi Negatif, Dren Amilaz 180 U/L">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Gastroenteroloji Cerrahı Muayene Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Gastrointestinal anastomoz hattı dikiş/zımba güvenliği, dren amilaz ve bilirubin seviyesi takibi, oral gıda toleransı ve bağırsak pasajının (gaz/gaita çıkışı) kontrolü..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>GI Cerrahı: Doç. Dr. Serkan Uysal</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>GI Cerrahi Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
