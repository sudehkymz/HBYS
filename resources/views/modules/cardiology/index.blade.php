@extends('layouts.app')

@push('styles')
<style>
    .card-card {
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
        border-left-color: #ef4444;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Cardiology Main Department Header Banner -->
    <div class="card card-card mb-4 bg-white border-top border-4 border-danger">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-heart-pulse fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-heart text-danger"></i>Kardiyoloji Polikliniği
                        </h2>
                        <p class="text-muted small mb-0">Transtorasik Ekokardiyografi (EKO), koroner anjiyografi & stent, EKG Holter, Troponin/NT-proBNP & TAVI konseyi.</p>
                    </div>
                </div>

                <div class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-heart-circle-bolt me-1"></i>Kardiyovasküler & Anjiyografi Laboratuvarı
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
            <div class="card card-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-danger"></i>Kardiyoloji Başvuruları
                    </h5>
                    <span class="badge bg-danger-subtle text-danger rounded-pill">{{ count($cardAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($cardAdmissions as $adm)
                        <a href="{{ route('cardiology.index', ['admission_id' => $adm['id']]) }}" 
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
                <div class="card card-card mb-4 border-start border-danger border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger text-white mb-2">Aktif Kardiyoloji Hasta Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-danger me-1"></i>
                                    <strong>Kardiyolog:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cardiology Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- Echocardiography (EKO) & Valve Metrics Card -->
                    <div class="col-md-6">
                        <div class="card card-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-heart-pulse me-2"></i>Transtorasik Ekokardiyografi (EKO)</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Sol Ventrikül EF (LVEF):</span>
                                        <span class="badge bg-danger fs-6">LVEF: %45 (Orta Disfonksiyon)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Aort Kapak Alanı (AVA):</span>
                                        <span class="badge bg-warning text-dark">0.75 cm² (Ağır Aort Darlığı)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Aort Kapak Ortalama Gradyanı:</span>
                                        <span class="fw-bold text-dark">48 mmHg (Yüksek Gradyan)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">PASP (Pulmoner Arter Basıncı):</span>
                                        <span class="badge bg-secondary">45 mmHg (Hafif Pulmoner HT)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                                    <i class="fa-solid fa-heart me-1"></i><strong>Duvar Hareket Kusuru:</strong> LAD Sulkusunda Ön Duvar Hipokinezisi İzlendi.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coronary Angiography & PCI / Stent Log Card -->
                    <div class="col-md-6">
                        <div class="card card-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-heart-circle-bolt me-2"></i>Koroner Anjiyografi & PCI Stent Kaydı</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Sorumlu Damar (Lesion):</span>
                                        <span class="badge bg-danger">LAD Mid %90 Ciddi Darlık</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">İmplant Stent Tipi:</span>
                                        <span class="badge bg-primary">3.5 x 24 mm DES (Drug-Eluting)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">TIMI Akım Derecesi:</span>
                                        <span class="badge bg-success">TIMI III (Tam Açıklık Sağlandı)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">İkili Antiplatelet (DAPT):</span>
                                        <span class="fw-bold text-dark">Aspirin 100mg + Tikagrelor 90mg (12 Ay)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Kateter Lab Raporu:</strong> Primer Percutaneous Coronary Intervention (PCI) Tam Başarıyla Sonuçlandı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: EKG Holter / CHA2DS2 & Biomarkers Cards -->
                <div class="row g-4 mb-4">
                    <!-- EKG Holter & CHA2DS2-VASc Score Card -->
                    <div class="col-md-6">
                        <div class="card card-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-wave-square me-2"></i>24h EKG Holter & CHA2DS2-VASc Skoru</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Ritil Analizi:</span>
                                        <span class="badge bg-danger">Paroksismal Atriyal Fibrilasyon (AF)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">CHA2DS2-VASc Skoru:</span>
                                        <span class="badge bg-warning text-dark">4 Puan (Yüksek Emboli Riski)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Reçete Edilen Antikoagülan:</span>
                                        <span class="badge bg-success">Apiksaban (Eliquis) 5mg 2x1</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Antikoagülasyon Onayı:</strong> İnme Önleme Proflaksisi İçin DOAC Reçetesi Onaylandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cardiac Biomarkers & Pacemaker / ABPM Card -->
                    <div class="col-md-6">
                        <div class="card card-card h-100 border-start border-4 border-dark">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-flask-vial me-2"></i>Kardiyak Biyobelirteçler & CRT-D Kalp Pili</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Yüksek Hassasiyetli Troponin (hs-TnI):</span>
                                        <span class="badge bg-danger">hs-TnI: 4850 ng/L (Akut Hasar)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">NT-proBNP Düzeyi:</span>
                                        <span class="badge bg-warning text-dark">6400 pg/mL (Kalp Yetersizliği)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">CRT-D Pil Kontrolü:</span>
                                        <span class="badge bg-success">Batarya 3.1V (Pacing %98 Uygun)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-dark-subtle rounded border border-dark-subtle small text-dark">
                                    <strong>Konsey Kararı:</strong> TAVI (Transkateter Aort Kapak Enjeksiyonu) Konsey Onayı Çıktı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card card-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-danger"></i>Kardiyoloji Muayene & Anjiyo Rapor Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('cardiology.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Kardiyak Teşhis & LVEF %</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="LVEF: %45 Post-PCI STEMI LAD DES Stent (Troponin: 4850 ng/L)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Reçete Edilen Kardiyak İlaç</label>
                                    <select name="form_data[cardiac_medication]" class="form-select">
                                        <option value="DAPT (Aspirin 100mg + Tikagrelor 90mg 2x1)">DAPT (Aspirin + Tikagrelor)</option>
                                        <option value="DOAC Antikoagülan (Apiksaban 5mg 2x1)">DOAC Antikoagülan (Apiksaban 5mg)</option>
                                        <option value="ARNI (Sacubitril/Valsartan 49/51mg 2x1)">ARNI (Sacubitril/Valsartan 49/51mg)</option>
                                        <option value="SGLT2 İnhibitörü (Dapagliflozin 10mg 1x1)">SGLT2 İnhibitörü (Dapagliflozin 10mg)</option>
                                        <option value="Üçlü Antihipertansif (Olmesartan/Amlodipin/HCTZ)">Üçlü Antihipertansif Kombinasyon</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Planlanan Girişim / Konsey</label>
                                    <input type="text" name="form_data[planned_procedure]" class="form-control" value="Kontrol Korner Anjiyografi / TAVI Konseyi Hazırlığı">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kardiyolog Muayene & Anjiyografi Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Kalp sesleri (S1, S2, S3 üfürüm), EKO segmental duvar hareketleri, EKG ST-T değişiklikleri, anjiyo lezyon darlık yüzdesi ve DAPT süresi notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Kardiyoloji Uzmanı: Prof. Dr. Murat Can</span>
                                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Kardiyoloji Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card card-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-heart-pulse fa-4x text-danger mb-3 opacity-40"></i>
                        <h5>Kardiyoloji Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
