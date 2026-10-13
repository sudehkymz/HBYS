@extends('layouts.app')

@push('styles')
<style>
    .sports-card {
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
        background-color: #f0fdf4;
        border-left-color: #16a34a;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Sports Medicine Main Department Header Banner -->
    <div class="card sports-card mb-4 bg-white border-top border-4 border-success">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-person-running fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-volleyball text-success"></i>Spor Hekimliği Polikliniği
                        </h2>
                        <p class="text-muted small mb-0">Ergospirometri (VO2 Max), Biodex izokinetik dinamometre, MSK ultrasonografi, PRP enjeksiyonu & Return to Play (RTP).</p>
                    </div>
                </div>

                <div class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-trophy me-1"></i>Sporcu Sağlığı & Performans Test Laboratuvarı
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
            <div class="card sports-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-success"></i>Sporcu Başvuruları
                    </h5>
                    <span class="badge bg-success-subtle text-success rounded-pill">{{ count($sportsAdmissions) }} Sporcu</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($sportsAdmissions as $adm)
                        <a href="{{ route('sports_medicine.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif sporcu bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card sports-card mb-4 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success text-white mb-2">Aktif Sporcu Sağlık Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-success me-1"></i>
                                    <strong>Spor Hekimi:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı/Performans:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sports Medicine Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- CPET Ergospirometry & VO2 Max Performance Card -->
                    <div class="col-md-6">
                        <div class="card sports-card h-100 border-start border-4 border-success">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-heart-pulse me-2"></i>CPET Ergospirometri & VO2 Max Testi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Aerobik Kapasite (VO2 Max):</span>
                                        <span class="badge bg-success fs-6">58.4 mL/kg/dk (Üst Düzey Atlet)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Anaerobik Laktat Eşiği:</span>
                                        <span class="fw-bold text-dark">168 Atım/Dk (310 Watt Yük)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Maksimum Kalp Hızı (HRmax):</span>
                                        <span class="badge bg-primary">192 Atım/Dk (%100 Kardiak)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Kan Laktat Düzeyi:</span>
                                        <span class="badge bg-warning text-dark">8.6 mmol/L (Zirve Efor)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                                    <i class="fa-solid fa-circle-check me-1"></i><strong>Kardiyopulmoner Uygunluk:</strong> Ani Kardiyak Ölüm Taraması Temiz (HCM Ekarte Edildi).
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biodex Isokinetic Dynamometer & Muscle Imbalance Card -->
                    <div class="col-md-6">
                        <div class="card sports-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-dumbbell me-2"></i>Biodex İzokinetik Dinamometre & H/Q Oranı</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Hamstring / Quadriceps (H/Q):</span>
                                        <span class="badge bg-success fs-6">H/Q Oranı: %64 (Denge Optimal)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Quadriceps Peak Torque:</span>
                                        <span class="fw-bold text-dark">280 Nm (60°/sn Hızda)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Hamstring Peak Torque:</span>
                                        <span class="fw-bold text-dark">178 Nm (60°/sn Hızda)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Taraf Asimetrisi (Defisit %):</span>
                                        <span class="badge bg-success"><%8 Sağ/Sol Fark (Risk Yok)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Kas Dengesi Raporu:</strong> Izokinetik Kuvvet Taraması Sahaya Dönüş Kriterlerini Karşılıyor.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: MSK USG Tendon Infiltration & RTP License Clearance Cards -->
                <div class="row g-4 mb-4">
                    <!-- MSK Ultrasonography & PRP Tendon Infiltration Card -->
                    <div class="col-md-6">
                        <div class="card sports-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-syringe me-2"></i>MSK USG & Otolog PRP Tendon Enjeksiyonu</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Ultrason (MSK USG) Bulgusu:</span>
                                        <span class="badge bg-warning text-dark">Aşil Tendonu %30 İğsi Kalınlaşma</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Uygulanan Hücresel Tedavi:</span>
                                        <span class="badge bg-success">3ml Otolog PRP (Trombositten Zengin)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Egzersiz Yükleme Modeli:</span>
                                        <span class="fw-bold text-dark">Stanish Eksantrik Tendon Protokolü</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Görüntüleme Kılavuzluğu:</strong> Tendon İçi USG Kılavuzluğunda Enjeksiyon Sorunsuz Tamamlandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Return to Play (RTP) & License Medical Clearance Card -->
                    <div class="col-md-6">
                        <div class="card sports-card h-100 border-start border-4 border-info">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-certificate me-2"></i>Return to Play (RTP) & Lisans Onay Raporu</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Sahaya Dönüş (RTP) Statüsü:</span>
                                        <span class="badge bg-success fs-6">RTP Onaylandı (Tam Performans)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Vücut Yağ Yüzdesi (DEXA):</span>
                                        <span class="fw-bold text-dark">%11.2 (Optimal Atletik Yağ Oranı)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Federasyon Sağlık Lisansı:</span>
                                        <span class="badge bg-info text-dark">E-Devlet Sporcu Lisans Raporu Onaylı</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                                    <strong>Sezon Öncesi Tarama:</strong> Sporcunun Resmi Yarışmalara Katılımında Tıbbi Sakınca Yoktur.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card sports-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-success"></i>Spor Hekimliği Muayene & Performans Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('sports_medicine.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Performans Teşhisi & VO2 Max</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-success text-success" value="VO2 Max: 58.4 mL/kg/dk - ÖÇB 6. Ay RTP Sahaya Dönüş Onaylandı">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Uygulanan Test / İntra-Tendon İşlem</label>
                                    <select name="form_data[sports_test]" class="form-select">
                                        <option value="CPET Ergospirometri & VO2 Max Testi">CPET Ergospirometri & VO2 Max Testi</option>
                                        <option value="Biodex İzokinetik Dinamometre H/Q Testi">Biodex İzokinetik Dinamometre H/Q Testi</option>
                                        <option value="USG Rehberliğinde Otolog PRP Enjeksiyonu">USG Rehberliğinde PRP Enjeksiyonu</option>
                                        <option value="Return to Play (RTP) Sahaya Dönüş Bataryası">Return to Play (RTP) Bataryası</option>
                                        <option value="Sezon Öncesi Lisans Sağlık Taraması">Sezon Öncesi Lisans Sağlık Taraması</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Lisans / RTP Onay Statüsü</label>
                                    <input type="text" name="form_data[licence_status]" class="form-control" value="Federasyon Tıbbi Lisans Raporu Onaylandı">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Spor Hekimi Muayene & Performans Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Kas-iskelet ultrasonografi bulguları, izokinetik kuvvet tork değerleri (Nm), anaerobik eşik nabzı, yaralanma nüks önleme egzersizleri ve sahaya dönüş kararı notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Spor Hekimi: Prof. Dr. Tolga Şahin</span>
                                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Sporcu Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card sports-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-person-running fa-4x text-success mb-3 opacity-40"></i>
                        <h5>Sporcu Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
