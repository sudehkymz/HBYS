@extends('layouts.app')

@push('styles')
<style>
    .ns-card {
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
        background-color: #f3e8ff;
        border-left-color: #7c3aed;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Neurosurgery Main Department Header Banner -->
    <div class="card ns-card mb-4 bg-white border-top border-4 border-purple" style="border-top-color: #7c3aed !important;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px; background-color: #7c3aed;">
                        <i class="fa-solid fa-brain fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-brain" style="color: #7c3aed;"></i>Beyin ve Sinir Cerrahisi (Nöroşirürji)
                        </h2>
                        <p class="text-muted small mb-0">Nöronavigasyonlu kraniyotomi, omurga mikrodiskektomi/ACDF, İNMON nöromonitorizasyon & ICP takibi.</p>
                    </div>
                </div>

                <div class="badge border px-3 py-2 fs-6 rounded-pill" style="background-color: #f3e8ff; color: #7c3aed; border-color: #ddd6fe !important;">
                    <i class="fa-solid fa-microscope me-1"></i>Nöroşirürji & Omurga Cerrahi Merkezi
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
            <div class="card ns-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2" style="color: #7c3aed;"></i>Nöroşirürji Hasta Başvuruları
                    </h5>
                    <span class="badge rounded-pill" style="background-color: #f3e8ff; color: #7c3aed;">{{ count($nsAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($nsAdmissions as $adm)
                        <a href="{{ route('neurosurgery.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge border" style="background-color: #f3e8ff; color: #7c3aed; border-color: #ddd6fe !important;">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif nöroşirürji hastası bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card ns-card mb-4 border-start border-4" style="border-left-color: #7c3aed !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge text-white mb-2" style="background-color: #7c3aed;">Aktif Nöroşirürji Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Salon:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor me-1" style="color: #7c3aed;"></i>
                                    <strong>Nöroşirürjist:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Nörolojik Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Neurosurgery Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- Neuronavigation & Intra-operative Neuromonitoring (IONM) Card -->
                    <div class="col-md-6">
                        <div class="card ns-card h-100 border-start border-4" style="border-left-color: #7c3aed !important;">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0" style="color: #7c3aed;"><i class="fa-solid fa-crosshairs me-2"></i>Nöronavigasyon & İNMON Nöromonitorizasyon</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">MEP / SSEP Nöromonitorizasyon:</span>
                                        <span class="badge bg-success fs-6">Amplitüd %100 Stabil (Kord Koruması)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Nöronavigasyon Hizalama:</span>
                                        <span class="badge bg-primary">Sub-Milimetrik Hassasiyet (StealthStation)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Nöroşirürji Mikroskobu:</span>
                                        <span class="fw-bold text-dark">Zeiss Kinevo 900 4K 3D Ekranlama</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Ultrasonik Aspiratör (CUSA):</span>
                                        <span class="badge bg-secondary">Aktivasyonlu Tümör Debulking</span>
                                    </div>
                                </div>

                                <div class="p-2 rounded border small text-dark" style="background-color: #f3e8ff; border-color: #ddd6fe !important;">
                                    <i class="fa-solid fa-circle-check me-1" style="color: #7c3aed;"></i><strong>Motor Kortex Güvenliği:</strong> İntraoperatif Uyarılmış Potansiyel Kaybı Olmadan Rezeksiyon Tamamlandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GCS Score & Intracranial Pressure (ICP) Card -->
                    <div class="col-md-6">
                        <div class="card ns-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-brain me-2"></i>GCS Skoru & İntrakraniyal Basınç (ICP) Takibi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Glasgow Koma Skoru (GCS):</span>
                                        <span class="badge bg-success fs-6">GCS: 15 / 15 (E4M6V5 Tam Açık)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">İntrakraniyal Basınç (ICP):</span>
                                        <span class="badge bg-primary">ICP: 11 mmHg (Normal Sınır 5-15)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Pupil Işık Refleksi:</span>
                                        <span class="badge bg-success">Bilateral Izokorik (+/+) PIR Pozitif</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">EVD / BOS Drenajı:</span>
                                        <span class="fw-bold text-dark">EVD Drenajı 10 cmH2O Seviyesinde Açık</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                                    <strong>Nöro-Yoğun Bakım Takibi:</strong> Kafa İçi Basınç Artışı (KİBA) Belirtisi Yoktur.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card ns-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2" style="color: #7c3aed;"></i>Beyin ve Sinir Cerrahisi Muayene & Ameliyat Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('neurosurgery.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Nöroşirürji Teşhisi & GCS/ICP</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-purple" style="border-color: #7c3aed !important; color: #7c3aed;" value="Sol Parieto-oksipital GBM - Nöronavigasyonlu Kraniyotomi (GCS: 15, ICP: 11 mmHg)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Nöroşirürjik Ameliyat Türü</label>
                                    <select name="form_data[ns_surg_type]" class="form-select">
                                        <option value="Nöronavigasyonlu Kraniyotomi + Tümör Rezeksiyonu">Nöronavigasyonlu Kraniyotomi</option>
                                        <option value="Lomber Mikrodiskektomi (L4-L5 / L5-S1)">Lomber Mikrodiskektomi</option>
                                        <option value="Servikal Anterior Diskektomi ve Füzyon (ACDF)">ACDF Servikal Füzyon</option>
                                        <option value="Anevrizma Mikrocerrahi Kliplemesi">Anevrizma Mikrocerrahi Kliplemesi</option>
                                        <option value="Acil Epidural/Subdural Hematom Evakuasyonu">Acil Hematom Evakuasyonu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">İNMON Nöromonitorizasyon Yanıtı</label>
                                    <input type="text" name="form_data[ionm_result]" class="form-control" value="MEP / SSEP Amplitüdü %100 Korumalı">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nöroşirürjist Muayene & Operasyon Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Motor kuvvet muayenesi (5/5), kraniyotomi insizyon hattı pansumanı, duramater su sızdırmaz kapatma (water-tight), BOS kaçağı takibi ve kafa çiftleri (cranial nerves) muayenesi..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Nöroşirürjist: Prof. Dr. İbrahim Ziyal</span>
                                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #7c3aed;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Nöroşirürji Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card ns-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-brain fa-4x mb-3 opacity-40" style="color: #7c3aed;"></i>
                        <h5>Nöroşirürji Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
