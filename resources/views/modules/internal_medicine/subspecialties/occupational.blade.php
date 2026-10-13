@extends('modules.internal_medicine.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-briefcase-medical text-primary me-2"></i>İş ve Meslek Hastalıkları
@endsection

@section('page_description')
    ILO Pnömokonyoz akciğer grafisi evreleme, mesleki toksikoloji (ağır metal) ve iş göremezlik raporu.
@endsection

@section('internal_workspace')
<div class="row g-4 mb-4">
    <!-- ILO Pneumoconiosis Chest X-Ray Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-x-ray me-2"></i>ILO Pnömokonyoz Akciğer Grafisi Evreleme</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">ILO Pnömokonyoz Kategorisi:</span>
                        <span class="badge bg-danger">Kategori 1/1 q/t (Küçük Opasiteler)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">SFT (Solunum Fonksiyon Testi):</span>
                        <span class="badge bg-warning text-dark">FEV1/FVC: %68 (Restriktif / Mikst)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Maruziyet Sektörü / Süre:</span>
                        <span class="small text-muted">Kömür/Silika Madenciliği (14 Yıl)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-lungs me-1"></i><strong>Mesleki Maruziyet Kararı:</strong> Tozlu ortamda çalışması sakıncalıdır, iş yeri değişikliği kararı verildi.
                </div>
            </div>
        </div>
    </div>

    <!-- Heavy Metal & Toxicology Panel Card -->
    <div class="col-md-6">
        <div class="card internal-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-flask-vial me-2"></i>Mesleki Toksikoloji & Ağır Metal Paneli</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kanda Kurşun (Pb) Düzeyi:</span>
                        <span class="badge bg-danger">42 µg/dL (Toksik Maruziyet)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">İdrarda Cıva (Hg) / Arsenik:</span>
                        <span class="fw-bold text-dark">Hg: 12 µg/g Kreatinin (Normal Sınırda)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Benzen / Toluen Metabolit:</span>
                        <span class="small text-muted">S-Pfenilmerkaptürik Asit Normal</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Şelasyon Tedavisi:</strong> Yüksek kurşun maruziyeti nedeniyle EDTA Şelasyon Tedavisi başlandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card internal-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-briefcase-medical me-2 text-primary"></i>İş ve Meslek Hastalıkları Kurul Rapor Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('internal_medicine.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="occupational">
            <input type="hidden" name="redirect_route" value="internal_medicine.occupational">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">ILO Kategori & Toksikoloji Notu</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="ILO 1/1 q/t Silikozis - Kanda Kurşun 42 ug/dL">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Mesleki İş Göremezlik Kararı</label>
                    <select name="sub_specialty_data[incapacity_status]" class="form-select">
                        <option value="Tozlu / Riskli İş Ortamında Çalışamaz">Tozlu / Riskli İş Ortamında Çalışamaz</option>
                        <option value="Sürekli Meslekte Kazanma Gücü Kaybı (%10+)">Sürekli Meslekte Kazanma Gücü Kaybı</option>
                        <option value="Geçici İş Göremezlik (Tedavi Süresince)">Geçici İş Göremezlik (Tedavi Süresince)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Maruz Kalınan İş Kolu</label>
                    <input type="text" name="sub_specialty_data[industry]" class="form-control" value="Yeraltı Madencilik / Dökümhane">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Meslek Hastalıkları Uzmanı Sağlık Kurulu Rapor Metni</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Mesleki maruziyet öyküsü, anamnez, ILO akciğer grafisi okuma kartı, şelasyon tedavisi ve SGK meslek hastalığı bildirim notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Meslek Hastalıkları Uzmanı: Uzm. Dr. Kemal Vural</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Meslek Hastalığı Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
