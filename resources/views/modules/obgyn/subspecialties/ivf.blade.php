@extends('modules.obgyn.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-vial-virus me-2 text-primary"></i>Tüp Bebek & İnfertilite Ünitesi (IVF / Üreme Sağlığı)
@endsection

@section('page_description')
    Ovülasyon indüksiyonu, folikülometri, OPU yumurta toplama, ICSI mikroenjeksiyon & 5. gün blastokist embriyo transferi.
@endsection

@section('obgyn_workspace')
<div class="row g-4 mb-4">
    <!-- Folliculometry & OPU Oocyte Retrieval Card -->
    <div class="col-md-6">
        <div class="card obgyn-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-vial-virus me-2"></i>Folikülometri USG & OPU Yumurta Toplama</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Matür Folikül Sayısı (USG):</span>
                        <span class="badge bg-primary fs-6">Bilateral 14 Matür Folikül (18-22mm)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">OPU Toplanan Oosit (Yumurta):</span>
                        <span class="badge bg-success">12 Adet MII Matür Oosit Alındı</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Serum Estradiol (E2) Seviyesi:</span>
                        <span class="fw-bold text-dark">E2: 2450 pg/mL (OHSS Riski Minimal)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Endometriyum Kalınlığı:</span>
                        <span class="badge bg-success">10.2 mm Üç Çizgi (Trilaminar Uyumlu)</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>ICSI Laboratuvar Yanıtı:</strong> 12 Oositten 10 Adedi ICSI (Mikroenjeksiyon) İle Döllendi (Döllenme Oranı %83).
                </div>
            </div>
        </div>
    </div>

    <!-- Embryo Transfer & Luteal Support Card -->
    <div class="col-md-6">
        <div class="card obgyn-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-dna me-2"></i>Embriyo Transferi & Lüteal Faz Desteği</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">5. Gün Blastokist Kalitesi:</span>
                        <span class="badge bg-success fs-6">4AA Üst Kalite Blastokist Embriyo</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Transfer Edilen Embriyo:</span>
                        <span class="badge bg-primary">1 Adet Taze Blastokist Transferi Yapıldı</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Lüteal Dondurulan Embriyolar:</span>
                        <span class="fw-bold text-dark">4 Adet Top Kalite Blastokist Donduruldu (Vitrifikasyon)</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                    <strong>Lüteal Faz Reçetesi:</strong> Progesteron (Crinone 8% Vajinal Jel 2x1) + Estrofem 2mg 3x1 Başlatıldı (12 Gün Sonra Beta-hCG Tahlili).
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card obgyn-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-vial-virus me-2 text-primary"></i>Tüp Bebek (IVF) Muayene & Embriyoloji Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('obgyn.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="ivf">
            <input type="hidden" name="redirect_route" value="obgyn.ivf">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">İnfertilite Teşhisi & OPU Sayısı</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-primary text-primary" value="Primer İnfertilite - OPU 12 Matür Oosit (10 ICSI Fertilizasyon)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">IVF Tedavi Protokolü</label>
                    <select name="sub_specialty_data[ivf_protocol]" class="form-select">
                        <option value="Gonal-F / Cetrotide Antagonist Protokolü">Antagonist Protokol (Gonal-F/Cetrotide)</option>
                        <option value="Agonist Uzun Protokol (Lucrin)">Agonist Uzun Protokol (Lucrin)</option>
                        <option value="Dondurulmuş Embriyo Transferi (FET) Siklusu">Dondurulmuş Embriyo Transferi (FET)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Embriyo Skoru & Beta-hCG Tarihi</label>
                    <input type="text" name="sub_specialty_data[embryo_detail]" class="form-control" value="4AA Blastokist Transferi, 12 Gün Sonra Beta-hCG">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">IVF Uzmanı Muayene & Embriyoloji Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Antral folikül sayısı (AFC), E2 ve Progesteron tetkik seviyeleri, OPU anestezi toleransı, ICSI fertilizasyon oranı, embriyo gelişim skoru ve lüteal faz protokol notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>IVF Uzmanı: Uzm. Dr. Burcu Ekin</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>IVF Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
