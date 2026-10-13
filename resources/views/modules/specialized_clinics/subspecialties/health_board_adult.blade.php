@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-file-signature text-success me-2"></i>Sağlık Kurulu Erişkin (Engellilik & Heyet)
@endsection

@section('page_description')
    Erişkin engellilik sağlık kurulu raporu, Balthazard formülü engellilik oranı (%), heyet kararları.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- Balthazard Formula Disability Calculator Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-calculator me-2"></i>Balthazard Engellilik Oranı Formülü</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="fw-bold text-dark mb-1">Balthazard Formülü:</div>
                    <code class="text-success fs-6 fw-bold">Toplam Oran = En Yüksek Oran + (100 - En Yüksek Oran) × İkinci Oran / 100</code>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Dahiliye / Kardiyoloji Oranı</label>
                        <input type="number" class="form-control form-control-sm" value="30">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Ortopedi / Fizik Tedavi Oranı</label>
                        <input type="number" class="form-control form-control-sm" value="20">
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success d-flex justify-content-between align-items-center">
                    <span class="small fw-bold">Hesaplanan Toplam Engel Oranı:</span>
                    <span class="badge bg-success fs-6">%44 Engelli Oranı (Sürekli)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Health Board Committee Decision Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-dark">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-gavel me-2"></i>Sağlık Kurulu Heyet Kararı & Onay</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Heyet Karar Tipi:</span>
                        <span class="badge bg-success">Oy Birliği İle Onaylandı</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Rapor Süresi:</span>
                        <span class="badge bg-dark">Sürekli (Süresiz Rapor)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Ağır Engellilik / Bağımlılık:</span>
                        <span class="badge bg-secondary">Tam Bağımlı Değil (Kısmi)</span>
                    </div>
                </div>

                <div class="p-2 bg-dark-subtle rounded border border-dark-subtle small">
                    <i class="fa-solid fa-stamp me-1"></i><strong>Kurul Başkanı:</strong> Prof. Dr. Harun Tekin (E-İmzalı e-Rapor Sistemine Gönderildi).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-file-signature me-2 text-success"></i>Erişkin Sağlık Kurulu Heyet Rapor Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="health_board_adult">
            <input type="hidden" name="redirect_route" value="specialized.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Engellilik Oranı (%)</label>
                    <input type="text" name="status_score" class="form-control fw-bold border-success text-success" value="%45 Engellilik Oranı (Sürekli)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Heyet Karar Şekli</label>
                    <select name="sub_specialty_data[vote_status]" class="form-select">
                        <option value="Oy Birliği İle Kabul">Oy Birliği İle Kabul Edildi</option>
                        <option value="Oy Çokluğu İle Kabul">Oy Çokluğu İle Kabul Edildi</option>
                        <option value="Red (Engellilik Kriterine Uymuyor)">Red (Kriter Sağlamıyor)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kullanım Amacı / Haklar</label>
                    <input type="text" name="sub_specialty_data[purpose]" class="form-control" value="Vergi İndirimi, Evde Bakım, H-Tipi Ehliyet">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Sağlık Kurulu Heyet Kararı & Klinik Bulgular Notu</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="Tüm branş muayene teşhisleri, Balthazard hesaplama dökümü, engel oranı ve heyet karar gerekçesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Kurul Başkanı: {{ $selectedAdmission['attending_physician'] }}</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Sağlık Kurulu Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
