@extends('layouts.app')

@push('styles')
<style>
    .aero-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
    }
    .patient-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    .patient-item:hover {
        background-color: #f8f9fa;
    }
    .patient-item.active {
        background-color: #f0f9ff;
        border-left-color: #0369a1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Aerospace Medicine Main Department Header Banner -->
    <div class="card aero-card mb-4 bg-white border-top border-4 border-info" style="border-top-color: #0369a1 !important;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px; background-color: #0369a1;">
                        <i class="fa-solid fa-plane-up fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-jet-fighter" style="color: #0369a1;"></i>Hava ve Uzay Hekimliği Polikliniği
                        </h2>
                        <p class="text-muted small mb-0">Uçuş fizyolojisi (+9Gz santrifüj), SHGM Sınıf 1 pilot muayenesi, hipobarik irtifa kamarası, HBO vurgun tedavisi & uzay fizyolojisi.</p>
                    </div>
                </div>

                <div class="badge border px-3 py-2 fs-6 rounded-pill" style="background-color: #f0f9ff; color: #0369a1; border-color: #bae6fd !important;">
                    <i class="fa-solid fa-user-astronaut me-1"></i>SHGM Havacılık & Uzay Tıp Merkezi
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Patient List Column -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card aero-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2" style="color: #0369a1;"></i>Pilot & Uzay Hasta Başvuruları
                    </h5>
                    <span class="badge rounded-pill" style="background-color: #f0f9ff; color: #0369a1;">{{ count($aeroAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($aeroAdmissions as $adm)
                        <a href="{{ route('aerospace_medicine.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge border" style="background-color: #f0f9ff; color: #0369a1; border-color: #bae6fd !important;">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif pilot/astronot bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card aero-card mb-4 border-start border-4" style="border-left-color: #0369a1 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge text-white mb-2" style="background-color: #0369a1;">Aktif Hava ve Uzay Hekimliği Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor me-1" style="color: #0369a1;"></i>
                                    <strong>Havacılık Hekimi (Flight Surgeon):</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Uçuş Statüsü:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aerospace Medicine Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- G-Force Centrifuge & Hypobaric Altitude Chamber Card -->
                    <div class="col-md-6">
                        <div class="card aero-card h-100 border-start border-4" style="border-left-color: #0369a1 !important;">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0" style="color: #0369a1;"><i class="fa-solid fa-gauge-high me-2"></i>+9Gz Santrifüj & 25.000ft Hipobarik Kamara</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">+Gz İvme Toleransı:</span>
                                        <span class="badge bg-danger fs-6">+9Gz (15 Saniye Dayanıklılık - G-LOC Yok)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">AGSM (Anti-G Manevrası):</span>
                                        <span class="badge bg-success">AGSM Efektif Solunum & Kas Kasıntısı</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Hipobarik Kamara İrtifası:</span>
                                        <span class="badge bg-primary">25.000 Feet (Hipoksi Toleransı)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">TUC (Bilinçli Kullanım Süresi):</span>
                                        <span class="fw-bold text-dark">4 Dk 12 Sn (Normal Tolerans Sınırında)</span>
                                    </div>
                                </div>

                                <div class="p-2 rounded border small text-dark" style="background-color: #f0f9ff; border-color: #bae6fd !important;">
                                    <i class="fa-solid fa-circle-check me-1" style="color: #0369a1;"></i><strong>Jet Uçuş Uygunluğu:</strong> Yüksek Performanslı Savaş Uçağı Fizyolojisi Testi Başarılı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SHGM / EASA Class 1 Medical Certification Card -->
                    <div class="col-md-6">
                        <div class="card aero-card h-100 border-start border-4 border-success">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-certificate me-2"></i>SHGM / EASA Sınıf 1 Uçuş Muayene Sertifikası</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Görme Keskinliği / Uzak-Yakın:</span>
                                        <span class="badge bg-success">Bilateral 6/6 (Düzeltmesiz Tam)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Renk Görmesi (Ishihara Testi):</span>
                                        <span class="badge bg-success">38/38 Levha Tam Doğru (Renk Körlüğü Yok)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Saf Ses Odyometri İletimi:</span>
                                        <span class="fw-bold text-dark">500-4000 Hz <15 dB (Mükemmel İşitme)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Pilot Sağlık Lisansı (Class 1):</span>
                                        <span class="badge bg-success fs-6">SHGM Class 1 Medical Certificate Approved</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                                    <strong>E-Devlet / SHGM Entegrasyonu:</strong> Ticari Havayolu Kaptan Pilot Sağlık Lisansı Onaylandı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: HBO Decompression & Microgravity Cards -->
                <div class="row g-4 mb-4">
                    <!-- Hyperbaric Oxygen Therapy (HBO) & Decompression (Vurgun) Card -->
                    <div class="col-md-6">
                        <div class="card aero-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-water me-2"></i>Hiperbarik Oksijen (HBO) & Vurgun (DCS) Tedavisi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Dekompresyon Hastalığı (DCS):</span>
                                        <span class="badge bg-danger">Tip II Vurgun (Eklem & Nörolojik Tutulum)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">HBO Tedavi Protokolü:</span>
                                        <span class="badge bg-primary">US Navy Treatment Table 6 (2.8 ATA)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Östaki & Kulak Barotravması:</span>
                                        <span class="badge bg-success">Östaki Tüp İletimi Normal (Timpanometri A)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                                    <strong>Basınç Odası Seansı:</strong> 2.8 ATA %100 Oksijen İnfazı İle Vurgun Semptomları Geriledi.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Spaceflight Physiology & Microgravity Adaptation Card -->
                    <div class="col-md-6">
                        <div class="card aero-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-user-astronaut me-2"></i>Uzay Fizyolojisi & Mikrogravite Adaptasyonu</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Ortostatik Tolerans Testi:</span>
                                        <span class="badge bg-success">LBNP & Tilt Table Testi Stabil</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kemik Mineral Yoğunluğu (DEXA):</span>
                                        <span class="fw-bold text-dark">Uzay Görevi Kaybı <%1.2 (Optimal)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Uzay Hareket Hastalığı (SMS):</span>
                                        <span class="badge bg-secondary">Vestibüler Rehabilitasyon Tamamlandı</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Astronot Görev Sonrası Takip:</strong> Dünyaya Adaptasyon & Yerçekimi Egzersiz Protokolü Onaylandı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card aero-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2" style="color: #0369a1;"></i>Hava ve Uzay Hekimliği Muayene & Uçuş Rapor Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('aerospace_medicine.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Uçuş Muayene Teşhisi & G-Toleransı</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-info" style="border-color: #0369a1 !important; color: #0369a1;" value="+9Gz Santrifüj Toleransı Tam - SHGM Class 1 Pilot Raporu">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Uygulanan Test / Simülasyon</label>
                                    <select name="form_data[aero_test]" class="form-select">
                                        <option value="SHGM Sınıf 1 Pilot Periyodik Muayenesi">SHGM Sınıf 1 Pilot Periyodik Muayenesi</option>
                                        <option value="+9Gz İvme Santrifüj & AGSM Testi">+9Gz İvme Santrifüj & AGSM Testi</option>
                                        <option value="25.000ft Hipobarik İrtifa Kamara Taraması">25.000ft Hipobarik İrtifa Kamarası</option>
                                        <option value="US Navy Table 6 Hiperbarik Oksijen (Vurgun)">US Navy Table 6 HBO (Vurgun)</option>
                                        <option value="Mikrogravite & Uzay Görevi Adaptasyonu">Mikrogravite & Uzay Görevi Adaptasyonu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">SHGM / Lisans Kararı</label>
                                    <input type="text" name="form_data[flight_clearance]" class="form-control" value="SHGM Sınıf 1 Uçuşa Elverişli (Unrestricted Fit for Flying)">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Havacılık Hekimi (Flight Surgeon) Muayene Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="G-LOC eşiği, AGSM manevra tekniği, görme keskinliği ve Ishihara levha sonuçları, kulak zarı barotravma görünümü ve uçuşa elverişlilik (Fit for Flying) sertifikasyon kararı..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Flight Surgeon: Prof. Dr. Erkan Göksu</span>
                                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #0369a1;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Uçuş Muayene Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card aero-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-plane-up fa-4x mb-3 opacity-40" style="color: #0369a1;"></i>
                        <h5>Pilot / Uzay Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
