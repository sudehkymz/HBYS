@extends('layouts.app')

@push('styles')
<style>
    .derm-card {
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
        background-color: #fdf2f8;
        border-left-color: #db2777;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Dermatology Main Department Header Banner -->
    <div class="card derm-card mb-4 bg-white border-top border-4 border-pink" style="border-top-color: #db2777 !important;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px; background-color: #db2777;">
                        <i class="fa-solid fa-allergies fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-shield-cat" style="color: #db2777;"></i>Deri ve Zührevi Hastalıkları Polikliniği (Cildiye)
                        </h2>
                        <p class="text-muted small mb-0">Dijital dermatoskopi, PASI sedef evrelemesi, izotretinoin güvenlik takibi, fototerapi & zührevi venereoloji.</p>
                    </div>
                </div>

                <div class="badge border px-3 py-2 fs-6 rounded-pill" style="background-color: #fdf2f8; color: #db2777; border-color: #fbcfe8 !important;">
                    <i class="fa-solid fa-microscope me-1"></i>Dermatoskopi & Fototerapi Merkezi
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
            <div class="card derm-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2" style="color: #db2777;"></i>Cildiye Başvuruları
                    </h5>
                    <span class="badge rounded-pill" style="background-color: #fdf2f8; color: #db2777;">{{ count($dermAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($dermAdmissions as $adm)
                        <a href="{{ route('dermatology.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge border" style="background-color: #fdf2f8; color: #db2777; border-color: #fbcfe8 !important;">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card derm-card mb-4 border-start border-4" style="border-left-color: #db2777 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge text-white mb-2" style="background-color: #db2777;">Aktif Cildiye Hasta Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor me-1" style="color: #db2777;"></i>
                                    <strong>Cildiye Uzmanı:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dermatology Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- Dermoscopy & ABCDE Melanoma Screening Card -->
                    <div class="col-md-6">
                        <div class="card derm-card h-100 border-start border-4" style="border-left-color: #db2777 !important;">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0" style="color: #db2777;"><i class="fa-solid fa-magnifying-glass-plus me-2"></i>Dijital Dermatoskopi & ABCDE Nevüs Haritası</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Asimetri (Asymmetry):</span>
                                        <span class="badge bg-danger">Var (Asimetrik 2 Aks)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Sınır Düzensizliği (Border):</span>
                                        <span class="badge bg-warning text-dark">Çentikli Düzensiz Sınır</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Renk Çeşitliliği (Color):</span>
                                        <span class="fw-bold text-dark">Kahverengi-Siyah Alacalı</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Çap (Diameter):</span>
                                        <span class="badge bg-danger">6.5 mm (>6mm Riskli)</span>
                                    </div>
                                </div>

                                <div class="p-2 rounded border small text-dark" style="background-color: #fdf2f8; border-color: #fbcfe8 !important;">
                                    <i class="fa-solid fa-circle-exclamation me-1" style="color: #db2777;"></i><strong>Biyopsi Önerisi:</strong> Sol Sırt Lezyonu İçin Eksizyonel Biyopsi & Patoloji Kararı Alındı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Systemic Isotretinoin (Roaccutane) Safety Monitor Card -->
                    <div class="col-md-6">
                        <div class="card derm-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-pills me-2"></i>Sistemik İzotretinoin Doz & Lab Takibi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Günlük Doz:</span>
                                        <span class="fw-bold text-dark">40 mg/gün (0.6 mg/kg/gün)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kümülatif Doz Hedefi:</span>
                                        <span class="badge bg-primary">4200 mg / 7200 mg (%58)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">ALT / AST & Trigliserid:</span>
                                        <span class="badge bg-success">ALT: 22 U/L, Trigliserid: 145 mg/dL</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Gebelik Testi (Beta-hCG):</span>
                                        <span class="badge bg-success">Negatif (Onaylı Taahhüt)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Teratojenite Uyarısı:</strong> Çift Yöntem Kontrasepsiyon & Aylık Kan Testi Şartıyla Tedaviye Devam Edildi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: PASI Psoriasis & Phototherapy / Venereology Cards -->
                <div class="row g-4 mb-4">
                    <!-- PASI Psoriasis Severity Index Card -->
                    <div class="col-md-6">
                        <div class="card derm-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-calculator me-2"></i>PASI (Psoriasis Area & Severity Index)</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">PASI Skoru:</span>
                                        <span class="badge bg-danger fs-6">PASI: 14.8 (Şiddetli Psoriasis)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Tutulum Yüzdesi (BSA %):</span>
                                        <span class="fw-bold text-dark">%18 Vücut Yüzey Alanı</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Eritem / İndürasyon / Skam:</span>
                                        <span class="small text-muted">Eritem: 3, Şiddetli Skam: 3</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-danger-subtle rounded border border-danger small text-dark">
                                    <strong>Biyolojik Ajan Onayı:</strong> Anti-IL17 (Secukinumab 300mg) Biyolojik Tedavi Sağlık Kurulu Raporu Çıkarıldı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phototherapy & Cryotherapy Procedures Card -->
                    <div class="col-md-6">
                        <div class="card derm-card h-100 border-start border-4 border-info">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-snowflake me-2"></i>Fototerapi (UVB) & Kriyoterapi İşlemleri</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Dar Bant UVB (311nm):</span>
                                        <span class="badge bg-info text-dark">16. Seans (0.85 Joules/cm²)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kriyoterapi (Sıvı Azot -196°C):</span>
                                        <span class="fw-bold text-dark">Aktinik Keratoz / Verrua Sprey</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Wood Işığı İncelemesi:</span>
                                        <span class="badge bg-secondary">Vitiligo Lezyonlarında Mercan Kırmızı Yok</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                                    <strong>Zührevi Venereoloji Serolojisi:</strong> VDRL/RPR: Negatif, TPHA: Negatif (Syphilis Taraması Temiz).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card derm-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2" style="color: #db2777;"></i>Dermatoloji Muayene & İşlem Rapor Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('dermatology.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Dermatolojik Teşhis / Skor</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-pink" style="border-color: #db2777 !important; color: #db2777;" value="PASI: 14.8 Psoriasis Vulgaris - Dermatoskopi ABCDE Riskli">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Uygulanan Dermatolojik İşlem</label>
                                    <select name="form_data[procedure_type]" class="form-select">
                                        <option value="Dijital Dermatoskopi & Nevüs Haritalama">Dijital Dermatoskopi & Nevüs Haritalama</option>
                                        <option value="Sıvı Azot Kriyoterapi (-196°C)">Sıvı Azot Kriyoterapi (-196°C)</option>
                                        <option value="Elektrokoterizasyon Lezyon Tahribi">Elektrokoterizasyon Lezyon Tahribi</option>
                                        <option value="Dar Bant UVB (311nm) Fototerapi">Dar Bant UVB (311nm) Fototerapi</option>
                                        <option value="Punch / Eksizyonel Deri Biyopsisi">Punch / Eksizyonel Deri Biyopsisi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Reçete Edilen İlaç / Biyolojik</label>
                                    <input type="text" name="form_data[medication]" class="form-control" value="Sistemik İzotretinoin 40mg/gün veya Secukinumab 300mg">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Dermatolog Muayene, Dermatoskopi & Biyopsi Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Deri lezyonlarının lokasyonu, eritem/skam derecesi, dermatoskopik pigment ağı bulguları, kriyoterapi süresi ve histopatoloji gönderim notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Dermatolog: Prof. Dr. Nermin Keskin</span>
                                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #db2777;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Dermatoloji Muayenesini Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card derm-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-allergies fa-4x mb-3 opacity-40" style="color: #db2777;"></i>
                        <h5>Dermatoloji Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
