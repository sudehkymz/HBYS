@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-child-check text-success me-2"></i>Sağlık Kurulu ÇÖZGER (Çocuk Özel Gereksinim)
@endsection

@section('page_description')
    0-18 yaş çocuklar için ÇÖZGER kurulu, özel eğitim, rehabilitasyon ve evde bakım desteği kararı.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- ÇÖZGER Category & Level Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-award me-2"></i>ÇÖZGER Derecelendirme Kriteri</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Gereksinim Derecesi:</span>
                        <span class="badge bg-success">Özel Gereksinimi Var (ÖGG %20-39)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">ÇÖZGER Kategorisi:</span>
                        <span class="fw-bold text-dark">Belirgin Derecede Özel Gereksinim (ÖKGV)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Özel Eğitim İhtiyacı:</span>
                        <span class="badge bg-primary">RAM Rehberlik & Özel Eğitim Uygun</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-check-circle me-1"></i>Milli Eğitim Bakanlığı RAM (Rehberlik Araştırma Merkezi) Sevk Onayı Verildi.
                </div>
            </div>
        </div>
    </div>

    <!-- Home Care & Allowance Decision Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-house-chimney-medical me-2"></i>Evde Bakım & Desteği Kararı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Evde Bakım Aylığı Uyum:</span>
                        <span class="badge bg-success">Evde Bakım Desteği Uygundur</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Rapor Geçerlilik Süresi:</span>
                        <span class="badge bg-dark">2 Yıl Süreli (ÇÖZGER)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Pediatrik Branşlar:</span>
                        <span class="small text-muted">Pediatri + Nöroloji + Gelişimsel</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small">
                    <i class="fa-solid fa-child me-1"></i>Çocuk Özel Gereksinim Raporu e-Devlet sistemine aktarıldı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-child-check me-2 text-success"></i>ÇÖZGER Çocuk Sağlık Kurulu Rapor Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="health_board_cozger">
            <input type="hidden" name="redirect_route" value="specialized.cozger">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">ÇÖZGER Gereksinim Derecesi</label>
                    <select name="status_score" class="form-select border-success">
                        <option value="Özel Gereksinimi Var (ÖGG)">Özel Gereksinimi Var (%20-39)</option>
                        <option value="Hafif Düzeyde Özel Gereksinim">Hafif Düzeyde Özel Gereksinim (%40-49)</option>
                        <option value="Orta Düzeyde Özel Gereksinim">Orta Düzeyde Özel Gereksinim (%50-59)</option>
                        <option value="Çok İleri Düzeyde Özel Gereksinim (ÖKGV)">Çok İleri Düzeyde (ÖKGV - %90+)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Özel Eğitim & RAM Sevk Durumu</label>
                    <select name="sub_specialty_data[ram_status]" class="form-select">
                        <option value="Özel Eğitim Raporu Uygundur">Özel Eğitim Raporu Uygundur</option>
                        <option value="Fizik Tedavi & Rehabilitasyon Uygun">Fizik Tedavi & Rehabilitasyon Uygun</option>
                        <option value="Gerek Yok">Gerek Yok</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Evde Bakım Ücreti Kararı</label>
                    <input type="text" name="sub_specialty_data[home_care]" class="form-control" value="Evde Bakım Destek Aylığı Alması Uygundur">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">ÇÖZGER Heyet Kararı & Klinik Değerlendirme Notları</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="Çocuğun nöromotor gelişim seviyesi, zihinsel/bedensel gereksinim oranları ve ÇÖZGER kurul heyet kararı..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Kurul Sorumlusu: Doç. Dr. Nesrin Aydın</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>ÇÖZGER Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
