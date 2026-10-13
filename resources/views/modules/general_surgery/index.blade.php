@extends('layouts.app')

@push('styles')
<style>
    .surg-card {
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
        background-color: #fef2f2;
        border-left-color: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- General Surgery Main Department Header Banner -->
    <div class="card surg-card mb-4 bg-white border-top border-4 border-danger">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-scalpel fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-hand-holding-medical text-danger"></i>Genel Cerrahi Polikliniği & Ameliyathane
                        </h2>
                        <p class="text-muted small mb-0">Laparoskopik & onkolojik cerrahi, ASA skoru, dren takibi, pre-op kan hazırlığı & post-op bakım.</p>
                    </div>
                </div>

                <div class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-notes-medical me-1"></i>2. Cerrahi Tıp Bilimleri Bölümü
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
            <div class="card surg-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-danger"></i>Cerrahi Hasta Başvuruları
                    </h5>
                    <span class="badge bg-danger-subtle text-danger rounded-pill">{{ count($surgAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($surgAdmissions as $adm)
                        <a href="{{ route('general_surgery.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif cerrahi hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card surg-card mb-4 border-start border-danger border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger text-white mb-2">Aktif Genel Cerrahi Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Salon:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-danger me-1"></i>
                                    <strong>Sorumlu Cerrah:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Cerrahi Endikasyon:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- General Surgery Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- ASA Score & Anesthesia Pre-Op Clearance Card -->
                    <div class="col-md-6">
                        <div class="card surg-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-heart-pulse me-2"></i>ASA Anestezi Derecesi & Pre-Op Değerlendirme</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">ASA Fiziksel Durum Skoru:</span>
                                        <span class="badge bg-danger fs-6">ASA II (Sistemik Hastalık Kontrollü)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Mallampati Hava Yolu Skoru:</span>
                                        <span class="badge bg-primary">Class I (Kolay Entübasyon)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">NPO (Açlık) Durumu:</span>
                                        <span class="badge bg-warning text-dark">8 Saat Katı/Sıvı Açlık Tam</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Pre-Op Kan Hazırlığı:</span>
                                        <span class="fw-bold text-dark">2 Ünite ES Rezerve (Crossmatch Uygun)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                                    <i class="fa-solid fa-circle-check me-1"></i><strong>Anestezi Onayı:</strong> Genel Anestezi Altında Ameliyat Edilebilir Onayı Verildi.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Surgical Procedure & Intra-Op Details Card -->
                    <div class="col-md-6">
                        <div class="card surg-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-scissors me-2"></i>Ameliyat Tekniği & İntra-Op Parametreler</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Uygulanan Ameliyat:</span>
                                        <span class="badge bg-primary">Laparoskopik Kolesistektomi</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Cerrahi Yaklaşım:</span>
                                        <span class="fw-bold text-dark">4 Port Minimal İnvaziv Laparoskopi</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">İntra-Op Kanama Miktarı:</span>
                                        <span class="badge bg-success"> Minimal (<30 ml)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Cerrahi Sınır (Frozen):</span>
                                        <span class="badge bg-success">Salim (Cerrahi Sınır Temiz)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Spesimen / Patoloji:</strong> Safra Kesesi Spesimeni Histopatolojik İncelemeye Gönderildi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: Post-Op Drain Log & Wound Healing Cards -->
                <div class="row g-4 mb-4">
                    <!-- Post-Op Drain Output & Nutrition Card -->
                    <div class="col-md-6">
                        <div class="card surg-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-droplet me-2"></i>Post-Op Dren Takibi & Beslenme</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Jackson-Pratt Dren Debisi:</span>
                                        <span class="badge bg-warning text-dark">30 ml / Gün (Seröz Mayi)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Dren İçerik Karakteri:</span>
                                        <span class="badge bg-success">Berrak Seröz (Safra Kaçağı Yok)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Oral Beslenme Başlangıcı:</span>
                                        <span class="fw-bold text-dark">Post-op 1. Gün Berrak Sıvı Diyet</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Dren Çekilme Kriteri:</strong> Dren Debisi <50 ml/gün Olduğundan 24 Saat İçinde Çekilmesi Planlandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wound Healing & Surgical Site Infection (SSI) Card -->
                    <div class="col-md-6">
                        <div class="card surg-card h-100 border-start border-4 border-secondary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-band-aid me-2"></i>Yara Yeri Pansumanı & Enfeksiyon Kontrol (SSI)</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kesi Pansuman Durumu:</span>
                                        <span class="badge bg-success">Kuru & Temiz (Aseptik Kapatma)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Cerrahi Alan Enfeksiyonu (SSI):</span>
                                        <span class="badge bg-success">Sınıf 1 Temiz Yara (Enfeksiyon Yok)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Profilaktik Antibiyotik:</span>
                                        <span class="fw-bold text-dark">1gr İntravenöz Sefazolin (Pre-op 30 Dk)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-secondary-subtle rounded border border-secondary-subtle small text-dark">
                                    <strong>Taburculuk Planı:</strong> Post-op 2. Gün Analjezik ve Dikiş Bakımı Önerileri ile Taburculuk Uyumlu.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card surg-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-danger"></i>Genel Cerrahi Muayene & Ameliyat Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('general_surgery.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Cerrahi Teşhis & ASA Skoru</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="Semptomatik Kolelitiazis - Laparoskopik Kolesistektomi (ASA II)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Ameliyat Türü / Yaklaşım</label>
                                    <select name="form_data[surg_type]" class="form-select">
                                        <option value="Laparoskopik Kolesistektomi (Minimal İnvaziv)">Laparoskopik Kolesistektomi</option>
                                        <option value="Laparoskopik Apandektomi">Laparoskopik Apandektomi</option>
                                        <option value="Laparoskopik Düşük Ön Rezeksiyon (LAR + TME)">Laparoskopik LAR + TME (Kolorektal)</option>
                                        <option value="Modifiye Radikal Mastektomi + SLNB">Modifiye Radikal Mastektomi + SLNB</option>
                                        <option value="Lichtenstein İnguinal Hernioflasti (Mesh)">Lichtenstein İnguinal Hernioflasti</option>
                                        <option value="Total Tiroidektomi & Santral Dissection">Total Tiroidektomi & Santral Dissection</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Dren Debisi & Mayi Karakteri</label>
                                    <input type="text" name="form_data[drain_status]" class="form-control" value="Jackson-Pratt Dren: 30 ml/gün Seröz Mayi">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Cerrah Ameliyat Notları & Post-Op İnceleme</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Abdominal palpasyon, hassasiyet/defans/rebound varlığı, insizyon hattı Pansuman görünümü, dren çıkışı miktar/renk takibi ve taburculuk kriterleri notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Sorumlu Cerrah: Prof. Dr. Cemalettin Ertekin</span>
                                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Cerrahi Kaydı Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card surg-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-scalpel fa-4x text-danger mb-3 opacity-40"></i>
                        <h5>Cerrahi Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
